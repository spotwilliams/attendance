# Laravel 11 Upgrade

**From**: Laravel 10.x / PHP 8.1
**To**: Laravel 11.x / PHP 8.2+
**Branch**: `upgrade/laravel-11.0` (from `develop`)

---

## Checklist

### Setup
- [X] Create branch `upgrade/laravel-11.0`
- [X] Create `docker/php/8.2/` Docker environment (already existed, verified correct)
- [X] Create `docker-compose.php82.yml`
- [X] Build and start PHP 8.2 container (`sail-8.2/app` image)
- [ ] Backup database

### Composer
- [X] `php`: `^8.1` → `^8.2`
- [X] `laravel/framework`: `^10.0` → `^11.0`
- [X] `nunomaduro/collision`: `^7.0` → `^8.0`
- [X] `phpunit/phpunit`: `^10.0` → `^11.0`
- [X] `symfony/css-selector`: `^6.0` → `^7.0`
- [X] `symfony/dom-crawler`: `^6.0` → `^7.0`
- [X] `mockery/mockery`: `^1.4.4` → `^1.6`
- [X] `laravel/tinker`: `^2.7` → `^2.9`
- [X] `spatie/laravel-permission`: `^6.0` (no change needed)
- [X] `laravelcollective/html` — **removed** (abandoned, not L11 compatible)
- [X] Run `docker-compose -f docker-compose.php82.yml exec attendance.web composer update`
- [X] Run `docker-compose -f docker-compose.php82.yml exec attendance.web composer dump-autoload`

### laravelcollective/html Migration
- [X] Migrate all `Form::` calls to plain HTML across 32 blade files (257 usages)
- [X] Remove `Collective\Html\HtmlServiceProvider` from `config/app.php`
- [X] Remove `Form` and `Html` facade aliases from `config/app.php`
- [X] Remove `laravelcollective/html` from `composer.json`
- [X] Remove laravelcollective tests from `DependencySmokeTest`

### Rector
- [X] Update `rector.php`: `LARAVEL_100` → `LARAVEL_110`
- [X] Run rector dry-run — 11 files flagged (`ModelCastsPropertyToCastsMethodRector`)
- [X] Run rector process — 11 files changed (model `$casts` property → `casts()` method)

### Manual Changes
- [X] Update `bootstrap/app.php` — migrated to Laravel 11 slim skeleton
- [X] Migrate middleware registration from `Kernel.php` to `bootstrap/app.php` `->withMiddleware()`
- [X] Migrate exception handling from `Handler.php` to `bootstrap/app.php` `->withExceptions()`
- [X] Create `routes/console.php` (replaces Console/Kernel schedule)
- [X] Update `RouteServiceProvider` to L11 `boot()` + `$this->routes()` pattern (keeps namespace for string routes)
- [X] Remove `app/Http/Kernel.php`
- [X] Remove `app/Console/Kernel.php`
- [X] Remove `app/Exceptions/Handler.php`
- [X] `config/database.php`: `search_path` confirmed present ✅
- [X] `$dates` property → `casts()` method handled by Rector
- [X] Update `phpunit.xml` schema to PHPUnit 11, remove duplicate `All` suite
- [X] `Arr::isAssoc()` — not used in codebase ✅

### Test

**Run tests:**
```bash
# Preferred — uses artisan test runner with pretty output
docker-compose -f docker-compose.php82.yml exec attendance.web php artisan test

# Run a specific test suite
docker-compose -f docker-compose.php82.yml exec attendance.web php artisan test --testsuite=Feature
docker-compose -f docker-compose.php82.yml exec attendance.web php artisan test --testsuite=Unit
docker-compose -f docker-compose.php82.yml exec attendance.web php artisan test --testsuite=Smoke

# Run a specific test file
docker-compose -f docker-compose.php82.yml exec attendance.web php artisan test tests/Feature/BootstrapTest.php

# Raw PHPUnit (alternative)
docker-compose -f docker-compose.php82.yml exec attendance.web vendor/bin/phpunit
```

- [X] App boots (Laravel 11.48.0 / PHP 8.2.30 confirmed)
- [X] PHPUnit suite passes (73/73 ✅)
- [ ] Login works
- [ ] Agent CRUD
- [ ] Attendance recording
- [ ] Excel exports
- [ ] Bulk operations (Masivo)
- [ ] Image uploads

### Done
- [ ] Tag: `git tag laravel-11.0-upgrade`
- [ ] Update `CLAUDE.md` status

---

## Key Breaking Changes (Laravel 10 → 11)

| Change | Impact | Status |
|--------|--------|--------|
| PHP 8.2 minimum | Docker + composer.json | ✅ Done |
| Slim app skeleton (`bootstrap/app.php`) | Migrated Kernel + Handler | ✅ Done |
| `$dates` model property removed | Rector: `casts()` method | ✅ Done |
| `laravelcollective/html` incompatible | Removed — plain HTML migration | ✅ Done |
| `RouteServiceProvider::map()` removed | Updated to `boot()` + `routes()` | ✅ Done |
| `Arr::isAssoc()` renamed | Not used in codebase | ✅ N/A |

## Resources

- [Official Laravel 11 Upgrade Guide](https://laravel.com/docs/11.x/upgrade)
- Previous: `docs/LARAVEL_10_UPGRADE.md`
