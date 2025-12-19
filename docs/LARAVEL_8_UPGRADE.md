# Laravel 8 Upgrade Guide

## Overview

**Status**: Ready to begin
**Estimated Time**: 15 minutes (plus testing)
**PHP Requirement**: 7.3.0+ (we have 7.4 ✅)

## Pre-Upgrade Checklist

- [x] Laravel 7 successfully running
- [x] Rector.php configured for Laravel 8
- [ ] Database backup created
- [ ] Git branch created: `upgrade/laravel-8.0`

## Step 1: Update Composer Dependencies

Update `composer.json` with the following changes:

### Framework & Core
```json
{
    "require": {
        "php": "^7.3",
        "laravel/framework": "^8.0",
        "guzzlehttp/guzzle": "^7.0.1",
        "facade/ignition": "^2.3.6"
    },
    "require-dev": {
        "phpunit/phpunit": "^9.0",
        "nunomaduro/collision": "^5.0"
    }
}
```

### First-Party Packages (if used)
- `laravel/ui`: `^3.0`
- `laravel/tinker`: `^2.0`

### Update Autoload Section
Add seeders namespace:
```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    }
}
```

Then run:
```bash
docker-compose -f docker-compose.php74.yml exec web.cat composer update
docker-compose -f docker-compose.php74.yml exec web.cat composer dump-autoload
```

## Step 2: Run Rector for Automated Changes

Rector will handle many of the mechanical changes:

```bash
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/rector process --dry-run
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/rector process
```

## Step 3: Critical Manual Changes

### 3.1 Update Seeders (High Priority)

**Rename directory:**
```bash
mv database/seeds database/seeders
```

**Add namespace to all seeder files:**
```php
<?php

namespace Database\Seeders;  // ADD THIS

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Existing code...
    }
}
```

**Update seeder calls:**
```php
// Old (Laravel 7)
$this->call(UsersTableSeeder::class);

// New (Laravel 8) - add namespace
$this->call(\Database\Seeders\UsersTableSeeder::class);
```

### 3.2 Keep Bootstrap Pagination (High Priority)

Add to `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Pagination\Paginator;

public function boot()
{
    Paginator::useBootstrap();  // ADD THIS to keep Bootstrap 3
}
```

### 3.3 Update Queue Method Names (If Using Queues)

Search for these in queued jobs, mailers, and notifications:

**Find:**
- `retryAfter` → Replace with `backoff`
- `timeoutAt` → Replace with `retryUntil`

**Search command:**
```bash
grep -r "retryAfter" app/
grep -r "timeoutAt" app/
```

### 3.4 Update Maintenance Mode Check in public/index.php

Add after `LARAVEL_START` constant:

```php
define('LARAVEL_START', microtime(true));

// ADD THIS BLOCK
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}
```

### 3.5 Model Factories (If Needed)

For now, use legacy factories to avoid rewriting:

```bash
composer require laravel/legacy-factories --dev
```

## Step 4: Update EventServiceProvider (If Custom)

If you have custom `EventServiceProvider::register()`:

```php
public function register()
{
    parent::register();  // MUST call parent

    // Your custom code...
}
```

## Step 5: Test Key Application Features

### Critical Test Paths
- [ ] Application boots successfully
- [ ] Login works
- [ ] Dashboard loads
- [ ] Agent CRUD operations
- [ ] Attendance recording (Presentismo)
- [ ] Payroll calculations (Haberes)
- [ ] Excel exports (Reportes)
- [ ] Bulk operations (Masivo)
- [ ] Image uploads
- [ ] Pagination displays correctly (Bootstrap)

### Test Commands
```bash
# Clear all caches
docker-compose -f docker-compose.php74.yml exec web.cat php artisan cache:clear
docker-compose -f docker-compose.php74.yml exec web.cat php artisan config:clear
docker-compose -f docker-compose.php74.yml exec web.cat php artisan view:clear
docker-compose -f docker-compose.php74.yml exec web.cat php artisan route:clear

# Run migrations (test database)
docker-compose -f docker-compose.php74.yml exec web.cat php artisan migrate:fresh --seed --env=testing

# Run tests
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/phpunit
```

## Breaking Changes Reference

### High-Impact Changes (Must Address)

1. **Seeders Namespace** - All seeders need `Database\Seeders` namespace
2. **Pagination Defaults** - Changed to Tailwind (we need Bootstrap)
3. **Queue Methods** - `retryAfter` → `backoff`, `timeoutAt` → `retryUntil`
4. **Model Factories** - Completely rewritten (use legacy package)

### Medium-Impact Changes (Check if Used)

1. **PHP 7.3.0 Minimum** - We have 7.4 ✅
2. **Maintenance Mode** - Update `public/index.php`
3. **Collection `isset`** - Behavior changed for `null` keys
4. **Removed `php artisan down --message`** - Use pre-rendered views

### Low-Impact Changes (Likely Not Used)

1. Removed `elixir()` helper - We use Mix ✅
2. Removed `sendNow()` method - Use `send()` instead
3. Removed automatic controller namespace prefixing
4. `Manager::$app` → `Manager::$container`

## Project-Specific Considerations

### Modules Likely Affected

Based on project structure, check these modules:

1. **Haberes** (Payroll) - May use queued jobs
2. **Reportes** (Reports) - Uses pagination extensively
3. **Masivo** (Bulk Operations) - May use queued jobs
4. **Presentismo** (Attendance) - Uses pagination
5. **Security** - May need EventServiceProvider updates

### Files to Review

- `database/seeds/` → `database/seeders/`
- `app/Providers/EventServiceProvider.php`
- `app/Providers/AppServiceProvider.php` (add Paginator::useBootstrap())
- `public/index.php` (add maintenance mode check)
- Any queued jobs in `app/Jobs/`
- Any queued notifications in `app/Notifications/`

## Common Issues & Solutions

### Issue: "Class 'Database\Seeders\DatabaseSeeder' not found"
**Solution:** Run `composer dump-autoload`

### Issue: Pagination looks wrong (Tailwind styles)
**Solution:** Add `Paginator::useBootstrap()` to `AppServiceProvider::boot()`

### Issue: "Method retryAfter does not exist"
**Solution:** Rename to `backoff` in queued jobs

### Issue: Model factories failing
**Solution:** Install `composer require laravel/legacy-factories --dev`

## Rollback Plan

If upgrade fails:

```bash
# Restore from backup
git checkout upgrade/php-7.4  # Or previous working branch
docker-compose -f docker-compose.php74.yml down
docker-compose -f docker-compose.php74.yml up -d
docker-compose -f docker-compose.php74.yml exec web.cat composer install
docker-compose -f docker-compose.php74.yml exec web.cat php artisan cache:clear
```

## Success Criteria

- [ ] All composer dependencies updated successfully
- [ ] Rector runs without errors
- [ ] Application boots without errors
- [ ] All critical features working (login, attendance, reports, exports)
- [ ] Pagination displays with Bootstrap styles
- [ ] Seeders run successfully
- [ ] Tests pass (if applicable)
- [ ] No PHP errors in logs

## Post-Upgrade Tasks

1. Tag the successful upgrade:
   ```bash
   git tag laravel-8.0-upgrade
   git push origin laravel-8.0-upgrade
   ```

2. Update CLAUDE.md with new status

3. Prepare for next phase (Laravel 8 → 9)

## Resources

- [Official Laravel 8 Upgrade Guide](https://laravel.com/docs/8.x/upgrade)
- [Laravel 8 Release Notes](https://laravel.com/docs/8.x/releases)
- Project docs: `docs/modernize.md`

---

**Created**: 2025-12-18
**For**: Sistema de Presentismo CAT
**Current Branch**: upgrade/php-7.4 → Will create upgrade/laravel-8.0
