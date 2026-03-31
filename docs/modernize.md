# Sistema Presentismo CAT — Modernization History

This document tells the story of how the system was modernized from PHP 5.6 + Laravel 5.2 to PHP 8.3 + Laravel 12. It is written for agents and developers who need to understand what changed, why, and what the current state of the codebase is.

---

## Where We Started

The original codebase was running:

- **PHP** `>=5.5.9`
- **Laravel** `5.2.*`
- **MySQL** (docker-compose with `mysql/mysql-server:8.0`)
- **Excel**: `maatwebsite/excel` `2.1.17` (old callback-based API)
- **Permissions**: `spatie/laravel-permission` `^1.12`
- **No tests**, no CI/CD, no test framework
- Custom Docker setup (not Sail)

---

## Phase 1 — PHP 7.4 (tag: `php-7.4-upgrade`)

**Date**: December 2025
**Branch**: `upgrade/php-7.4`

**Stack after this phase:**
- PHP: `>=5.5.9` _(composer.json not yet updated, but runtime moved to 7.4)_
- Laravel: `5.2.*`
- Docker: custom `docker-compose.php74.yml`

**What happened:**

The first step was purely about getting the code running under PHP 7.4 while keeping Laravel 5.2 intact. The goal was to isolate PHP-specific issues from framework issues.

Key work done:
- Created a PHP 7.4 Docker configuration (`docker/php/7.4/`)
- Ran Rector to automate PHP 5.6 → 7.4 compatibility fixes (deprecated curly-brace string access, `implode()` argument order, `compact()` with undefined variables)
- Updated namespace references in migrations and application code
- The app ran but had a number of errors — this was expected at this stage

> **Note:** The `composer.json` `php` requirement was not bumped at this tag. That happened in the next phase.

---

## Phase 2 — Laravel 6.0 (tag: `laravel-6.0-upgrade`)

**Date**: December 2025
**Branch**: `upgrade/laravel-6.0`

**Stack after this phase:**
- PHP: `^7.2.5|^8.0`
- Laravel: `^6.0`
- Excel: `maatwebsite/excel` `^3` (major rewrite from 2.x)
- Permissions: `spatie/laravel-permission` `^4`
- Docker: Sail introduced with MySQL 8.0

**What happened:**

This was the heaviest phase. Jumping from Laravel 5.2 to 6.0 required:

- **Rector** applied for Laravel 6.0 ruleset
- **Routes** migrated from `app/Http/routes.php` to `routes/web.php`
- **Migrations** fixed for compatibility
- **`maatwebsite/excel` 2.x → 3.x**: Complete rewrite of all export classes. The old callback-based API (`Excel::create(...)`) was replaced with dedicated export classes implementing `FromCollection` / `WithHeadings`
- **Laravel Sail** introduced as the Docker development environment (replaced manual Docker setup), at this point still using **MySQL**
- 90% of views were rendering correctly by end of this phase

> **Key insight:** The Excel package upgrade was the riskiest part. It was a complete API rewrite, not a minor bump.

---

## Phase 3 — Laravel 7.0 (tag: `laravel-7.0-upgrade`)

**Date**: December 2025
**Branch**: `upgrade/laravel-7.0`

**Stack after this phase:**
- PHP: `^7.2.5|^8.0`
- Laravel: `^7.0`
- Excel: `^3.1`
- Permissions: `^4`
- Testing: **PHPUnit `^8.5`** (first tests introduced)

**What happened:**

Laravel 7.0 was a relatively smooth upgrade from 6.0. The notable additions:

- **First tests written** using PHPUnit 8.5 — this was the first time the project had automated tests
- Rector applied again for Laravel 7.0 ruleset
- Docker startup script updated to create the testing database automatically
- Various fixes to presenter classes and module structure (classes moved to correct locations)

---

## Phase 4 — Laravel 8.0 (tag: `laravel-8.0-upgrade`)

**Date**: February 2026
**Branch**: `upgrade/laravel-8.0`

**Stack after this phase:**
- PHP: `^7.2.5|^8.0`
- Laravel: `^8.0`
- Excel: `^3.1`
- Permissions: `^4`
- Docker: Sail + MySQL 8.0

**What happened:**

Laravel 8 introduced significant structural changes:

- **Model factories** redesigned — from global factory functions to dedicated `Factory` classes per model with `HasFactory` trait
- **Route namespace** removed from `RouteServiceProvider` — routes updated to use fully qualified controller class names (array syntax `[Controller::class, 'method']`)
- Migrations and seeders updated
- `.env.testing` introduced for test environment configuration

---

## Phase 5 — Laravel 9.0 (tag: `laravel-9.0-upgrade`)

**Date**: February 2026
**Branch**: `upgrade/laravel-9.0`

**Stack after this phase:**
- PHP: `^8.0.2`
- Laravel: `^9.0`
- Excel: `^3.1`
- Permissions: `spatie/laravel-permission` `^5.5`
- Docker: Sail + MySQL 8.0
- Testing: PHPUnit `^9.5`
- **CI/CD pipeline introduced** (GitHub Actions)

**What happened:**

Laravel 9 required PHP 8.0 minimum, which was the first hard PHP floor change. Key work:

- **PHP minimum bumped to `^8.0.2`** — PHP 8.x features became available (nullsafe operator, match expressions, named arguments, constructor property promotion)
- **Excel reports fixed** — this was a notable pain point; the Excel library had issues that required multiple commits to resolve (`fixed excel reports. Yay`)
- Tests expanded
- **GitHub Actions CI/CD pipeline added** — automated testing on push/PR
- Anonymous migration classes introduced (Laravel 9 style)
- Docker: custom `docker-compose.php81.yml` added alongside existing files

---

## Phase 6 — Laravel 10.0 (tag: `laravel-10.0-upgrade`)

**Date**: February 2026
**Branch**: `upgrade/10x`

**Stack after this phase:**
- PHP: `^8.1`
- Laravel: `^10.0`
- Excel: `^3.1`
- Permissions: `spatie/laravel-permission` `^6.0`
- **Database: switched from MySQL to PostgreSQL 13**
- Docker: `docker-compose.php81.yml` with `postgres:13`

**What happened:**

Two major shifts happened in this phase:

1. **Database migrated from MySQL to PostgreSQL 13**. The `docker-compose.php74.yml` and `docker-compose.php81.yml` files were updated to use `postgres:13`. A `docker/postgres/init-databases.sh` script was added to initialize both the app and test databases.

2. **PHP minimum bumped to `^8.1`** — enums, readonly properties, fibers, intersection types became available.

Other changes:
- `AuthServiceProvider` fixed for Laravel 10 compatibility
- Seeders sanitized using Faker data
- Stale Docker files removed
- CI/CD updated to PHP 8.1

> **Key architectural decision:** The PostgreSQL migration happened here. All subsequent work assumes PostgreSQL 13.

---

## Phase 7 — Laravel 11.0 (tag: `laravel-11.0-upgrade`)

**Date**: March 2026
**Branch**: `upgrade/laravel-11.0`

**Stack after this phase:**
- PHP: `^8.2`
- Laravel: `^11.0`
- Excel: `^3.1`
- Permissions: `^6.0`
- Docker: `docker-compose.php82.yml` with `postgres:13`

**What happened:**

Laravel 11 introduced a streamlined application structure:

- **`app/Http/Kernel.php` removed** — middleware now configured in `bootstrap/app.php`
- **`app/Console/Kernel.php` removed** — console commands auto-discovered
- **PHP minimum bumped to `^8.2`** — readonly classes, DNF types
- Bug fixes in `Laborales` store/update operations
- `docker-compose.php82.yml` added using `sail-8.2/app`

---

## Phase 8 — Laravel 12.0 + Sail + Pest (tag: `laravel-12.0-upgrade`)

**Date**: March 2026
**Branch**: `laravel-12.0-upgrade`

**Stack after this phase (current):**
- PHP: `^8.3`
- Laravel: `^12.0`
- Excel: `^3.1`
- Permissions: `^6.0`
- **Docker: Laravel Sail with `compose.yaml`** (official Sail format)
- **Testing: Pest 3** (replaced PHPUnit directly)
- Database: PostgreSQL 13

**What happened:**

This phase consolidated everything and modernized the developer tooling:

- **All custom `docker-compose.phpXX.yml` files replaced** with a single `compose.yaml` (the standard Sail filename). The image is now `sail-8.3/app` with `postgres:13`.
- **PHPUnit replaced by Pest 3** — `tests/Pest.php` added, `pestphp/pest` and `pestphp/pest-plugin-laravel` added as dev dependencies. Feature tests rewritten in Pest style.
- **PHP minimum bumped to `^8.3`** — typed class constants, `json_validate()`, `#[\Override]` attribute
- **Carbon 3 compatibility fix** applied
- **GitHub Actions updated** to use PHP 8.3 and run Pest
- `AGENTS.md` added for AI agent context
- `CLAUDE.md` fully updated with Sail commands

---

## Phase 9 — Laravel 13.0 + PHP 8.5 (branch: `upgrade/laravel-13`)

**Date**: March 2026
**Branch**: `upgrade/laravel-13`

**Stack after this phase:**
- PHP: `^8.5`
- Laravel: `^13.0`
- Excel: `^3.1`
- Permissions: `^6.0`
- Docker: Laravel Sail with `compose.yaml` (PHP 8.5 runtime)
- Testing: **Pest 4** (upgraded from Pest 3)
- Database: PostgreSQL 13

**What happened:**

- **Laravel bumped from `^12.0` to `^13.0`** (v13.2.0)
- **PHP minimum bumped to `^8.5`** — Sail runtime updated to `sail-8.5/app`
- **Pest upgraded from `^3.8` to `^4.0`**, Tinker from `^2.9` to `^3.0`
- **`prettus/l5-repository` removed entirely** — was the only incompatible dependency. Replaced with custom `Cat\Repositories\BaseRepository` using direct Eloquent (PR #24). This also eliminated the inline composer repository hack that was initially needed.
- **CSRF middleware base class** changed from `VerifyCsrfToken` to `PreventRequestForgery`
- **Cache `serializable_classes`** config added for L13 security default
- Rector applied: validation string rules → array, closure return types
- CargoFactory faker overflow fix on `varchar(80)` column

---

## Stack Evolution Summary

| Tag | PHP | Laravel | Database | Testing | Docker |
|-----|-----|---------|----------|---------|--------|
| _(origin)_ | ≥5.5.9 | 5.2 | MySQL | — | Custom |
| `php-7.4-upgrade` | 7.4 (runtime) | 5.2 | MySQL | — | Custom php74 |
| `laravel-6.0-upgrade` | ^7.2.5 | ^6.0 | MySQL | — | Sail + MySQL |
| `laravel-7.0-upgrade` | ^7.2.5 | ^7.0 | MySQL | PHPUnit 8 | Sail + MySQL |
| `laravel-8.0-upgrade` | ^7.2.5 | ^8.0 | MySQL | PHPUnit 8 | Sail + MySQL |
| `laravel-9.0-upgrade` | ^8.0.2 | ^9.0 | MySQL | PHPUnit 9 | Sail + MySQL |
| `laravel-10.0-upgrade` | ^8.1 | ^10.0 | **PostgreSQL 13** | PHPUnit 10 | Sail + PgSQL |
| `laravel-11.0-upgrade` | ^8.2 | ^11.0 | PostgreSQL 13 | PHPUnit 11 | Sail + PgSQL |
| `laravel-12.0-upgrade` | ^8.3 | ^12.0 | PostgreSQL 13 | **Pest 3** | **Sail compose.yaml** |
| `upgrade/laravel-13` | ^8.5 | ^13.0 | PostgreSQL 13 | **Pest 4** | Sail compose.yaml |

---

## Key Package Evolution

| Package | Origin | Current |
|---------|--------|---------|
| `maatwebsite/excel` | `2.1.17` (callback API) | `^3.1` (class-based exports) |
| `spatie/laravel-permission` | `^1.12` | `^6.0` |
| `intervention/image` | `^2.4` | `^2.7` |
| `prettus/l5-repository` | `^2.6` | **Removed** (custom BaseRepository) |
| Test runner | none | Pest 4 |
| CI/CD | none | GitHub Actions |
| Docker | Custom Dockerfile | Laravel Sail |

---

## Current State

The latest upgrade is on branch `upgrade/laravel-13` (PHP 8.5 + Laravel 13.0). Previous phases have been merged to `develop`.

**To work with the project today:**

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan test --compact
```

See `CLAUDE.md` for the full development workflow and `AGENTS.md` for AI agent context.
