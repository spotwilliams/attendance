# Laravel 8 Upgrade Guide

## Overview

**Status**: In progress (Steps 1-4 completed, testing pending)
**Estimated Time**: 15 minutes (plus testing)
**PHP Requirement**: 7.3.0+ (we have 7.4 ✅)
**Branch**: `upgrade/laravel-8.0`

## Pre-Upgrade Checklist

- [x] Laravel 7 successfully running
- [x] Rector.php configured for Laravel 8 (updated to `LaravelSetList::LARAVEL_80`)
- [ ] Database backup created
- [x] Git branch created: `upgrade/laravel-8.0`

## Step 1: Update Composer Dependencies ✅ DONE

> Completed in commit `8710b94`

Changes applied to `composer.json`:

### Framework & Core ✅
- `laravel/framework`: `^7.0` → `^8.0`
- `guzzlehttp/guzzle`: moved to require, `^7.0.1`
- `facade/ignition`: moved to require, `^2.3.6`
- `phpunit/phpunit`: `^8.5` → `^9.0`
- `nunomaduro/collision`: `^4.1` → `^5.0`

### First-Party Packages ✅
- `laravel/ui`: `^2.0` → `^3.0`
- `laravel/tinker`: `^2.0` (unchanged)

### Autoload Section ✅
Added PSR-4 namespaces:
```json
"psr-4": {
    "Cat\\": "app/",
    "Database\\Factories\\": "database/Factories/",
    "Database\\Seeders\\": "database/seeders/"
}
```

Note: classmap also updated from `database/seeds` → `database/seeders` and `database/factories` → `database/Factories`.

## Step 2: Run Rector for Automated Changes ✅ DONE

Rector configured with `LaravelSetList::LARAVEL_80` and executed.

## Step 3: Critical Manual Changes

### 3.1 Update Seeders (High Priority) ✅ DONE

> Completed in commit `fc75e35`

- [x] Renamed `database/seeds/` → `database/seeders/`
- [x] Added `namespace Database\Seeders` to all 26 seeder files
- [x] Updated seeder calls in `DatabaseSeeder.php` with fully qualified namespaces

### 3.2 Keep Bootstrap Pagination (High Priority) ✅ DONE

Added `Paginator::useBootstrap()` to `AppServiceProvider::boot()`.

### 3.3 Update Queue Method Names ✅ NOT NEEDED

Searched the codebase: no `retryAfter` or `timeoutAt` usage found. No queued jobs use these methods.

### 3.4 Update Maintenance Mode Check in public/index.php ✅ DONE

> Completed in commit `8710b94`

`public/index.php` was fully rewritten to Laravel 8 format, including:
- Maintenance mode check
- Updated autoloader path (`vendor/autoload.php` instead of `bootstrap/autoload.php`)
- Modern Kernel/Request imports

### 3.5 Model Factories ✅ DONE

> Completed in commit `8710b94`

Instead of using legacy factories, new Laravel 8-style class-based factories were created:
- Deleted old `database/Factories/ModelFactory.php`
- Created 11 individual factory classes in `database/Factories/`:
  `AgenteFactory`, `AreaFactory`, `BaseFactory`, `ContratoFactory`, `EstadoContratoFactory`,
  `PeriodoFactory`, `PresentismoFactory`, `TipoContratoFactory`, `TipoPresentismoFactory`,
  `TurnoFactory`, `UserFactory`
- Added `HasFactory` trait to 10 models + `User.php`
- Updated all 3 test files to use new factories

## Step 4: Update EventServiceProvider ✅ DONE

Reviewed and updated `EventServiceProvider` as needed.

## Step 5: Test Key Application Features

### Critical Test Paths
- [x] Application boots successfully
- [X] Login works
- [X] Dashboard loads
- [x] Agent CRUD operations
- [X] Attendance recording (Presentismo)
- [X] Payroll calculations (Haberes)
- [X] Excel exports (Reportes)
- [X] Bulk operations (Masivo)
- [X] Image uploads
- [X] Pagination displays correctly (Bootstrap)

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

- ~~`database/seeds/` → `database/seeders/`~~ ✅ Done
- ~~`app/Providers/EventServiceProvider.php`~~ ✅ Done
- ~~`app/Providers/AppServiceProvider.php` (add Paginator::useBootstrap())~~ ✅ Done
- ~~`public/index.php` (add maintenance mode check)~~ ✅ Done
- ~~Any queued jobs in `app/Jobs/`~~ ✅ No queue methods to update
- ~~Any queued notifications in `app/Notifications/`~~ ✅ No queue methods to update

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

- [x] All composer dependencies updated successfully
- [x] Rector runs without errors
- [ ] Application boots without errors
- [ ] All critical features working (login, attendance, reports, exports)
- [x] Pagination displays with Bootstrap styles
- [x] Seeders migrated to `database/seeders/` with namespaces
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

## Commits Log

| Commit | Date | Description |
|--------|------|-------------|
| `fc75e35` | 2025-12-18 | Migrations updated, seeders moved to `database/seeders/` with namespaces |
| `8710b94` | 2025-12-19 | Composer deps updated, new factories, public/index.php, rector config, tests updated |

## Remaining Work

1. ~~**Run Rector** with `LaravelSetList::LARAVEL_80` (Step 2)~~ ✅
2. ~~**Add `Paginator::useBootstrap()`** to AppServiceProvider (Step 3.2)~~ ✅
3. ~~**Review EventServiceProvider** for `parent::register()` (Step 4)~~ ✅
4. **Test the application** - boot, login, critical features (Step 5)

---

**Created**: 2025-12-18
**Updated**: 2026-02-12
**For**: Sistema de Presentismo CAT
**Branch**: `upgrade/laravel-8.0` (created from `upgrade/php-7.4`)
