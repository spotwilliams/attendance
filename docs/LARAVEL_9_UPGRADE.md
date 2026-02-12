# Laravel 9 Upgrade Guide

## Overview

**Status**: Ready to begin
**PHP Requirement**: 8.0.2+ (we have 7.4 — **Docker upgrade needed**)
**From**: Laravel 8.x on PHP 7.4
**To**: Laravel 9.x on PHP 8.0/8.1
**Branch**: Will create `upgrade/laravel-9.0` from `upgrade/laravel-8.0`

## Pre-Upgrade Checklist

- [x] Laravel 8 successfully running
- [X] PHP 8.0/8.1 Docker configuration created
- [ ] Rector.php configured for Laravel 9
- [X] Database backup created
- [X] Git branch created: `upgrade/laravel-9.0`

## Critical Blocker: PHP 8.0+

Laravel 9 depends on Symfony 6.0, which requires **PHP 8.0.2 minimum**. The current Docker setup uses PHP 7.4. A new Docker configuration must be created before any Laravel 9 work can begin.

**Options:**
- Create `docker/php/8.1/Dockerfile` (recommended — PHP 8.1 gives more runway)
- Create `docker-compose.php81.yml`

---

## Step 1: Create PHP 8.1 Docker Environment

Create a new Dockerfile based on `docker/php/7.4/Dockerfile`, replacing all `php7.4-*` packages with `php8.1-*`:

```bash
cp -r docker/php/7.4 docker/php/8.1
# Edit docker/php/8.1/Dockerfile — replace php7.4 → php8.1
# Update setcap path for new PHP binary
# Create docker-compose.php81.yml
```

Test that the container builds and boots the application.

---

## Step 2: Update Composer Dependencies

### 2.1 Remove Packages

These packages are absorbed into Laravel 9 core or abandoned:

| Package            | Reason                                                                                               |
|--------------------|------------------------------------------------------------------------------------------------------|
| `fideloper/proxy`  | Absorbed into Laravel core (`Illuminate\Http\Middleware\TrustProxies`)                               |
| `facade/ignition`  | Replaced by `spatie/laravel-ignition`                                                                |
| `jlapp/swaggervel` | Abandoned since 2016, not compatible with Laravel 9. Remove or replace with `darkaonline/l5-swagger` |

### 2.2 Update `composer.json`

```json
{
    "require": {
        "php": "^8.0.2",
        "laravel/framework": "^9.0",
        "guzzlehttp/guzzle": "^7.2",
        "doctrine/dbal": "^3.0",
        "laravel/tinker": "^2.7",
        "laravel/ui": "^4.0",
        "laravel/helpers": "*",
        "laravelcollective/html": "^6.4",
        "spatie/laravel-permission": "^5.5",
        "maatwebsite/excel": "^3.1",
        "intervention/image": "^2.7",
        "prettus/l5-repository": "^3.0",
        "laracasts/flash": "*"
    },
    "require-dev": {
        "spatie/laravel-ignition": "^1.0",
        "nunomaduro/collision": "^6.1",
        "phpunit/phpunit": "^9.5.10",
        "symfony/css-selector": "^6.0",
        "symfony/dom-crawler": "^6.0",
        "fakerphp/faker": "^1.9.1",
        "mockery/mockery": "^1.4.4",
        "rector/rector": "*",
        "driftingly/rector-laravel": "^2.1"
    }
}
```

**Note:** If `maatwebsite/excel` has dependency conflicts, add `"psr/simple-cache": "^2.0"` to require.

### 2.3 Run Composer Update

```bash
docker-compose -f docker-compose.php81.yml exec web.cat composer update
docker-compose -f docker-compose.php81.yml exec web.cat composer dump-autoload
```

---

## Step 3: Run Rector for Automated Changes

Update `rector.php`:
- Comment out `LaravelSetList::LARAVEL_80`
- Add `LaravelSetList::LARAVEL_90`
- Consider adding PHP 8.0/8.1 set

```bash
docker-compose -f docker-compose.php81.yml exec web.cat vendor/bin/rector process --dry-run
docker-compose -f docker-compose.php81.yml exec web.cat vendor/bin/rector process
```

---

## Step 4: Critical Manual Changes

### 4.1 Fix Flysystem 3.x Breaking Changes (HIGH PRIORITY)

Laravel 9 upgrades Flysystem from 1.x to 3.x. The `getDriver()->getAdapter()->getPathPrefix()` chain is **completely removed**.

**4 files affected:**

| File                                                       | Line    |
|------------------------------------------------------------|---------|
| `app/Modules/Masivo/Services/Presentismos/Generator.php`   | 54      |
| `app/Modules/Masivo/Services/Common.php`                   | 44      |
| `app/Modules/Masivo/Controllers/Presentismos/Registro.php` | 125-128 |
| `app/Modules/Masivo/Controllers/Agentes/Registro.php`      | 89-92   |

**Fix:**
```php
// Before (Flysystem 1.x):
Storage::disk($this->storageKey)->getDriver()->getAdapter()->getPathPrefix();

// After (Flysystem 3.x):
Storage::disk($this->storageKey)->path('');
```

**Also remove `FileExistsException`** in `Generator.php`:

```php
// Before:
use League\Flysystem\FileExistsException;
// ...
} catch (FileExistsException $e) {

// After: Flysystem 3.x overwrites by default. Remove the try/catch
// or catch a generic \Exception if still needed.
```

### 4.2 Replace `CheckForMaintenanceMode` (HIGH PRIORITY)

In `app/Http/Kernel.php` line 17:

```php
// Before:
\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,

// After:
\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
```

### 4.3 Update `config/database.php` (HIGH PRIORITY)

Rename `schema` to `search_path` in the PostgreSQL connection (line 78):

```php
// Before:
'schema' => 'public',

// After:
'search_path' => 'public',
```

### 4.4 Remove `fideloper/proxy` References (MEDIUM)

The project has `fideloper/proxy` in `composer.json` but no `TrustProxies` middleware is registered in the Kernel. Simply removing it from `composer.json` (Step 2) is sufficient.

If a `TrustProxies` middleware is added later, use the framework's built-in class:
```php
use Illuminate\Http\Middleware\TrustProxies as Middleware;
```

### 4.5 Update Doctrine DBAL Imports (MEDIUM)

Two files import Doctrine DBAL classes directly. Verify they work with DBAL 3.x:

| File                                                          | Import                               |
|---------------------------------------------------------------|--------------------------------------|
| `app/Modules/Haberes/Services/Data.php:13`                    | `Doctrine\DBAL\Query\QueryException` |
| `app/Modules/Reportes/Controllers/Presentismos/General.php:8` | `Doctrine\DBAL\Query\QueryBuilder`   |

**Action:** Check if these classes still exist in `doctrine/dbal ^3.0`. `QueryException` was moved — may need to use `Doctrine\DBAL\Exception` instead. `QueryBuilder` still exists in DBAL 3.x but verify the API.

### 4.6 Verify Mail (LOW)

Only one file uses mail: `app/Modules/Haberes/Services/Sender/Sender.php` (line 91) with `Mail::queue()`. No direct SwiftMailer references found. The Symfony Mailer replacement should be transparent, but verify mail sending still works.

### 4.7 Update `.env` Variables (LOW)

```bash
# If present, rename:
FILESYSTEM_DRIVER → FILESYSTEM_DISK
```

---

## Step 5: Optional Modernization (Can Be Deferred)

These are recommended but not strictly required:

### 5.1 Modernize Exception Handler

Add a `register()` method to `app/Exceptions/Handler.php` (Laravel 9 convention):

```php
public function register()
{
    $this->reportable(function (Throwable $e) {
        //
    });
}
```

The existing `report()` and `render()` methods still work.

### 5.2 Update RouteServiceProvider

The current `RouteServiceProvider` uses the legacy Laravel 5.2 pattern (`map(Router $router)` + `app/Http/routes.php`). This still works but could be modernized in a future phase.

### 5.3 PHP 8 Return Types

If any classes override Laravel interfaces (`Countable`, `ArrayAccess`, `JsonSerializable`, etc.), add PHP 8 return type declarations.

---

## Step 6: Test Key Application Features

### Critical Test Paths
- [ ] Application boots successfully
- [ ] Login works
- [ ] Dashboard loads
- [ ] Agent CRUD operations
- [ ] Attendance recording (Presentismo)
- [ ] Payroll calculations (Haberes)
- [ ] Excel exports (Reportes)
- [ ] **Bulk operations (Masivo)** — most affected by Flysystem changes
- [ ] Image uploads
- [ ] Pagination displays correctly (Bootstrap)
- [ ] **Mail sending** — Symfony Mailer transition
- [ ] File storage operations

### Test Commands
```bash
# Clear all caches
docker-compose -f docker-compose.php81.yml exec web.cat php artisan cache:clear
docker-compose -f docker-compose.php81.yml exec web.cat php artisan config:clear
docker-compose -f docker-compose.php81.yml exec web.cat php artisan view:clear
docker-compose -f docker-compose.php81.yml exec web.cat php artisan route:clear

# Run migrations
docker-compose -f docker-compose.php81.yml exec web.cat php artisan migrate:fresh --seed --env=testing

# Run tests
docker-compose -f docker-compose.php81.yml exec web.cat vendor/bin/phpunit
```

---

## Breaking Changes Summary

### High Impact (Must Fix)

| Change                                                         | Files Affected                   | Effort            |
|----------------------------------------------------------------|----------------------------------|-------------------|
| PHP 7.4 → 8.0/8.1                                              | Docker config, composer.json     | Medium            |
| Flysystem 1.x → 3.x (`getPathPrefix()` removed)                | 4 files in Masivo module         | Medium            |
| `FileExistsException` removed                                  | Generator.php                    | Low               |
| `CheckForMaintenanceMode` → `PreventRequestsDuringMaintenance` | Kernel.php                       | Low               |
| `schema` → `search_path` in pgsql config                       | config/database.php              | Low               |
| `facade/ignition` → `spatie/laravel-ignition`                  | composer.json                    | Low               |
| `fideloper/proxy` removed                                      | composer.json                    | Low               |
| `doctrine/dbal` ~2.3 → ^3.0                                    | composer.json, 2 files to verify | Medium            |
| `jlapp/swaggervel` abandoned                                   | composer.json                    | Low (just remove) |

### Medium Impact (Verify)

| Change                                                       | Notes                                   |
|--------------------------------------------------------------|-----------------------------------------|
| SwiftMailer → Symfony Mailer                                 | Transparent for `Mail::queue()`, verify |
| `spatie/laravel-permission` ^4 → ^5.5                        | Review changelog for breaking changes   |
| `yajra/laravel-datatables-oracle` version bump               | Check if major version needed           |
| `laravel/ui` ^3.0 → ^4.0                                     | Minor API changes                       |
| Unvalidated array keys excluded from `$request->validated()` | Test forms                              |

### Low Impact (Unlikely to Affect)

| Change                                                    | Notes                      |
|-----------------------------------------------------------|----------------------------|
| `reduceWithKeys()` removed on collections                 | Use `reduce()`             |
| `assertDeleted()` renamed to `assertModelMissing()`       | Update tests               |
| `when()`/`unless()` closure behavior                      | Check query builders       |
| New `@checked`, `@disabled`, `@selected` Blade directives | Conflicts with Vue if used |

---

## Dependency Version Map

| Package                     | Current      | Laravel 9 Required                          |
|-----------------------------|--------------|---------------------------------------------|
| `php`                       | ^7.2.5\|^8.0 | **^8.0.2**                                  |
| `laravel/framework`         | ^8.0         | **^9.0**                                    |
| `doctrine/dbal`             | ~2.3         | **^3.0**                                    |
| `fideloper/proxy`           | ^4.4         | **REMOVE**                                  |
| `facade/ignition`           | ^2.3.6       | **REMOVE** → `spatie/laravel-ignition ^1.0` |
| `guzzlehttp/guzzle`         | ^7.0.1       | ^7.2                                        |
| `laravel/ui`                | ^3.0         | ^4.0                                        |
| `laravel/tinker`            | ^2.0         | ^2.7                                        |
| `laravelcollective/html`    | ^6.2         | ^6.4                                        |
| `spatie/laravel-permission` | ^4           | ^5.5                                        |
| `intervention/image`        | ^2.4         | ^2.7                                        |
| `maatwebsite/excel`         | ^3.1         | ^3.1 (same)                                 |
| `nunomaduro/collision`      | ^5.0         | **^6.1**                                    |
| `phpunit/phpunit`           | ^9.0         | ^9.5.10                                     |
| `symfony/css-selector`      | ^5.0         | **^6.0**                                    |
| `symfony/dom-crawler`       | ^5.0         | **^6.0**                                    |
| `jlapp/swaggervel`          | dev-master   | **REMOVE** (abandoned)                      |

---

## Rollback Plan

```bash
git checkout upgrade/laravel-8.0
docker-compose -f docker-compose.php74.yml down
docker-compose -f docker-compose.php74.yml up -d
docker-compose -f docker-compose.php74.yml exec web.cat composer install
docker-compose -f docker-compose.php74.yml exec web.cat php artisan cache:clear
```

---

## Success Criteria

- [ ] PHP 8.1 Docker environment working
- [ ] All composer dependencies updated successfully
- [ ] Rector runs without errors
- [ ] Flysystem calls updated (4 files)
- [ ] Application boots without errors
- [ ] All critical features working (login, attendance, reports, exports, bulk ops)
- [ ] Mail sending works
- [ ] Pagination displays with Bootstrap styles
- [ ] Seeders run successfully
- [ ] Tests pass
- [ ] No PHP errors in logs

---

## Post-Upgrade Tasks

1. Tag the successful upgrade:
   ```bash
   git tag laravel-9.0-upgrade
   git push origin laravel-9.0-upgrade
   ```

2. Update CLAUDE.md with new status

3. Prepare for next phase (Laravel 9 → 10)

---

## Resources

- [Official Laravel 9 Upgrade Guide](https://laravel.com/docs/9.x/upgrade)
- [Laravel 9 Release Notes](https://laravel.com/docs/9.x/releases)
- [Flysystem 1.x to 3.x Migration](https://flysystem.thephpleague.com/docs/upgrade-from-1.x/)
- Project docs: `docs/modernize.md`, `docs/LARAVEL_8_UPGRADE.md`

---

**Created**: 2026-02-12
**For**: Sistema de Presentismo CAT
**Branch**: `upgrade/laravel-8.0` → Will create `upgrade/laravel-9.0`
