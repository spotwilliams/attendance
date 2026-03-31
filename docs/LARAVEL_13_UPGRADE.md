# Laravel 13 Upgrade

**From**: Laravel 12.x / PHP 8.3
**To**: Laravel 13.x / PHP 8.5
**Branch**: `upgrade/laravel-13` (from `develop`)
**Released**: 2026-03-17
**Runtime**: Laravel Sail (PHP 8.5)

---

## Pre-Upgrade Summary

Laravel 13 is a low-breaking-change release. This upgrade also bumps PHP from 8.3 to 8.5 and updates the Sail runtime. Primary concerns: PHP 8.5 compatibility, CSRF middleware rename, cache serialization config, dependency bumps, Pest 3→4, and pagination view name change (we use Bootstrap 3).

---

## Checklist

### 1. Setup
- [X] Create branch `upgrade/laravel-13` (from `develop`)
- [ ] Backup database
- [X] Verify current state: `vendor/bin/sail artisan test --compact` (all green before starting)

### 2. PHP 8.5 + Sail Runtime Upgrade

#### 2a. Update `compose.yaml`

Change the Sail runtime from 8.3 to 8.5:

```yaml
# compose.yaml
services:
    laravel.test:
        build:
            context: './vendor/laravel/sail/runtimes/8.5'  # was 8.3
            dockerfile: Dockerfile
            args:
                WWWGROUP: '${WWWGROUP}'
        image: 'sail-8.5/app'  # was sail-8.3/app
```

#### 2b. Update `composer.json` PHP constraint

```json
"php": "^8.5"
```

#### 2c. Rebuild Sail container

```bash
vendor/bin/sail build --no-cache
vendor/bin/sail up -d
vendor/bin/sail php -v   # Verify PHP 8.5.x
```

#### 2d. PHP 8.5 Deprecations & Breaking Changes

**Search for these patterns:**

```bash
# Deprecated: implicit nullable types (already error in 8.5)
# e.g. function foo(Type $param = null) must be function foo(?Type $param = null)
vendor/bin/sail php -d error_reporting=E_ALL vendor/bin/rector process --dry-run
```

- [X] Update `compose.yaml`: runtime `8.3` → `8.5`, image `sail-8.3/app` → `sail-8.5/app`
- [X] Update `composer.json`: `"php": "^8.5"`
- [X] Rebuild container: `vendor/bin/sail build --no-cache`
- [X] Verify PHP version: `vendor/bin/sail php -v` shows 8.5.3
- [X] Fix any implicit nullable parameter types — none found ✅
- [X] Review PHP 8.4/8.5 deprecation warnings in logs — none found ✅
- [X] Run `vendor/bin/sail composer update` to verify all packages support PHP 8.5

### 3. Composer Dependencies

Update `composer.json`:

| Package                       | From       | To      | Notes                              |
|-------------------------------|------------|---------|------------------------------------|
| `laravel/framework`           | `^12.0`    | `^13.0` | Core framework (installed v13.2.0) |
| `laravel/tinker`              | `^2.9`     | `^3.0`  | Installed v3.0.0                   |
| `pestphp/pest`                | `^3.8`     | `^4.0`  | Installed v4.4.3                   |
| `pestphp/pest-plugin-laravel` | `^3.2`     | `^4.0`  | Installed v4.1.0                   |
| `phpunit/phpunit`             | (indirect) | `^12.0` | Via Pest                           |
| `nunomaduro/collision`        | `^8.0`     | `^8.8`  | Pest 4 requires ^8.8, not ^9.0    |
| `laravel/boost`               | `^2.2`     | `^2.2`  | Compatible, upgraded to v2.4.1     |

**Commands:**
```bash
# Update composer.json then:
vendor/bin/sail composer update
vendor/bin/sail composer dump-autoload
```

**Check compatibility for these project-specific packages:**
- [X] `doctrine/dbal` `^3.0` — compatible ✅
- [X] `maatwebsite/excel` `^3.1` — compatible ✅
- [X] `spatie/laravel-permission` `^6.0` — compatible ✅
- [X] `prettus/l5-repository` `^3.0` — **NOT compatible** with L13 (caps at `illuminate/support ^12.0`). Patched via inline composer repository override with `^13.0` added to illuminate constraints. Pinned as version `3.0.2`.
- [X] `intervention/image` `^2.7` — compatible ✅ (still on v2, consider `^3.0` later)
- [X] `laracasts/flash` — compatible ✅
- [X] `laravel/ui` `^4.0` — compatible ✅
- [X] `driftingly/rector-laravel` `^2.1` — compatible ✅, no `LARAVEL_130` set available yet
- [X] `spatie/laravel-ignition` `^2.0` — compatible ✅
- [X] `fruitcake/laravel-debugbar` `^4.1` — compatible ✅
- [X] `inertiajs/inertia-laravel` `^2.0` — compatible ✅

### 4. Rector

```bash
# Update rector.php: add LARAVEL_130 set if available
vendor/bin/sail php vendor/bin/rector process --dry-run
vendor/bin/sail php vendor/bin/rector process
```

- [X] Update `rector.php` target set — LARAVEL_120 marked as completed, no LARAVEL_130 set available yet
- [X] Run dry-run, review changes — 5 files flagged
- [X] Apply rector changes — 5 files updated (validation string→array rules, closure return types)

### 5. HIGH Impact Changes

#### 5a. CSRF Middleware Rename — `VerifyCsrfToken` → `PreventRequestForgery`

**Search:** `grep -r "VerifyCsrfToken\|ValidateCsrfToken" app/ bootstrap/ routes/ --include="*.php" -l`

**Replace all occurrences:**
```php
// OLD
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

// NEW
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
```

Also check `bootstrap/app.php` middleware config for any CSRF exclusions.

- [X] Search codebase for `VerifyCsrfToken` references — found in `app/Http/Middleware/VerifyCsrfToken.php` and `bootstrap/app.php`
- [X] Search codebase for `ValidateCsrfToken` references — none found ✅
- [X] Replace with `PreventRequestForgery` — updated base class in `app/Http/Middleware/VerifyCsrfToken.php`; kept class name for `bootstrap/app.php` reference compatibility
- [X] Verify CSRF exclusions still work — `presentismo/store` exclusion preserved ✅

### 6. MEDIUM Impact Changes

#### 6a. Cache `serializable_classes` Configuration

Laravel 13 defaults `serializable_classes` to `false` (blocks PHP object deserialization in cache).

**Search:** `grep -r "Cache::put\|Cache::remember\|Cache::forever" app/ --include="*.php" -l`

- [X] Check if any cached values are PHP objects (not arrays/scalars) — yes, `TipoPresentismosRepository` caches Eloquent collections
- [X] Added `'serializable_classes' => true` in `config/cache.php` to allow all classes (preserves existing behavior)

### 7. LOW Impact Changes (audit each)

#### 7a. Cache Prefix / Session Cookie Names
Cache prefixes changed from `_cache_` to `-cache-` (underscores → hyphens).

- [X] Check if app relies on specific cache prefix format — uses static `'prefix' => 'laravel'`, no impact ✅
- [X] If existing cache data must survive upgrade, set explicit `CACHE_PREFIX` and `REDIS_PREFIX` in `.env` — not needed, file cache can be cleared ✅
- [X] Session cookie name now uses `Str::snake()` — no custom session cookie name set, no impact ✅

#### 7b. Pagination Bootstrap 3 View Names
**CRITICAL for this project** — we use Bootstrap 3.

```php
// OLD
'pagination::default'
'pagination::simple-default'

// NEW
'pagination::bootstrap-3'
'pagination::simple-bootstrap-3'
```

**Search:** `grep -r "pagination::" app/ config/ resources/ --include="*.php" --include="*.blade.php" -l`

- [X] Check `AppServiceProvider` for `Paginator::defaultView()` calls — uses `Paginator::useBootstrap()` which handles view names internally ✅
- [X] Update any direct pagination view references — none found ✅
- [ ] Verify pagination renders correctly in browser (manual smoke test)

#### 7c. Queue Event Property Renames

**Search:** `grep -r "exceptionOccurred\|QueueBusy" app/ --include="*.php" -l`

- [X] Update queue event listeners if any — none found ✅

#### 7d. Model Boot Instantiation
Creating model instances inside `boot()` now throws `LogicException`.

**Search:** `grep -r "static function boot" app/Models/ --include="*.php" -l`

- [X] Review any model boot methods for `new static()` or `new self()` calls — no boot methods found ✅

#### 7e. Container::call Nullable Defaults
`Container::call()` now returns `null` for nullable typed params instead of instantiating.

- [X] Review any `app()->call()` usage with nullable class params — no impact ✅

#### 7f. Polymorphic Pivot Table Names
Custom polymorphic pivot models now generate pluralized table names.

- [X] Check for custom `MorphPivot` subclasses — none found ✅

#### 7g. Str Factory Reset in Tests
`Str::createUuidsUsing()` and similar now reset between tests.

- [X] Move any Str factory setup into `setUp()` methods if used in tests — no usage found ✅

#### 7h. Js::from Unescaped Unicode
`Js::from()` now outputs unescaped Unicode by default.

- [X] Check for `Js::from()` usage in Blade templates — no usage found ✅

### 8. PHP Attributes (Optional Modernization)

Laravel 13 introduces PHP attributes for middleware and jobs. These are optional but improve readability:

```php
// Controller middleware via attribute
#[Middleware('auth')]
class MyController { }

// Job configuration via attributes
#[Tries(3)]
#[Timeout(120)]
class ProcessReport implements ShouldQueue { }
```

- [ ] **Deferred** — adopt incrementally, not required for upgrade

### 9. Testing

```bash
# Full suite
vendor/bin/sail artisan test --compact

# By suite
vendor/bin/sail artisan test --compact --testsuite=Feature
vendor/bin/sail artisan test --compact --testsuite=Unit

# Single file
vendor/bin/sail artisan test --compact tests/Feature/AttendanceCommentControllerTest.php
```

- [X] All tests pass — 154 passed (584 assertions) ✅
- [X] App boots (`php artisan --version` shows Laravel Framework 13.2.0) ✅

**Note:** Fixed pre-existing bug in `CargoFactory` — `faker->jobTitle` could exceed `varchar(80)` column limit. Added `substr(..., 0, 80)`.

#### Smoke Tests
- [ ] Login works
- [ ] Dashboard loads
- [ ] Agent CRUD
- [ ] Attendance recording
- [ ] Pagination renders correctly (Bootstrap 3)
- [ ] Excel exports
- [ ] Bulk operations (Masivo)
- [ ] Image uploads

### 10. Finalize
- [X] Run `vendor/bin/sail artisan optimize:clear`
- [ ] Commit and push
- [ ] Create PR to `develop`
- [ ] Tag: `laravel-13.0-upgrade` on merge commit
- [ ] Update `CLAUDE.md` status

---

## Key Breaking Changes Summary

| Change | Impact | This Project |
|--------|--------|-------------|
| PHP 8.3 → 8.5 + Sail runtime | HIGH | Updated compose.yaml, composer.json, rebuilt container ✅ |
| Composer dependency bumps | HIGH | All updated, `prettus/l5-repository` patched via inline repo ✅ |
| `VerifyCsrfToken` → `PreventRequestForgery` | HIGH | Updated base class in middleware ✅ |
| Cache `serializable_classes` default | MEDIUM | Added `serializable_classes => true` in config/cache.php ✅ |
| Pagination view `default` → `bootstrap-3` | LOW | Uses `Paginator::useBootstrap()`, no direct view refs — no impact ✅ |
| Cache prefix underscore → hyphen | LOW | Static prefix `'laravel'`, no impact ✅ |
| Queue event property renames | LOW | No queue listeners — no impact ✅ |
| Model boot instantiation blocked | LOW | No boot methods — no impact ✅ |
| Pest 3 → 4 | HIGH | Updated, 154 tests passing ✅ |

---

## New Features Available (post-upgrade, optional adoption)

| Feature | Description | Relevance |
|---------|-------------|-----------|
| PHP Attributes | `#[Middleware]`, `#[Authorize]`, `#[Tries]` | Cleaner controller/job config |
| Laravel AI SDK | Text gen, embeddings, vector search | Future feature potential |
| Vector Search (pgvector) | Native PostgreSQL similarity search | We use PostgreSQL — could be useful |
| Cache::touch() | Extend TTL without re-storing | Performance optimization |
| Queue Routing | Route jobs to connections by class | Cleaner queue config |
| JSON:API Resources | Spec-compliant API responses | If building APIs |

---

## Rollback Plan

```bash
# If upgrade fails:
git checkout develop
vendor/bin/sail composer install
vendor/bin/sail artisan optimize:clear
```

---

## Resources

- [Official Laravel 13 Upgrade Guide](https://laravel.com/docs/13.x/upgrade)
- [Laravel 13 Release Notes](https://laravel.com/docs/13.x/releases)
- [GitHub skeleton diff](https://github.com/laravel/laravel/compare/12.x...13.x)
- [Pest 4 Upgrade Guide](https://pestphp.com/docs/upgrade-guide)
- Previous: `docs/LARAVEL_12_UPGRADE.md`
