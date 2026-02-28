# Laravel 10 Upgrade

**From**: Laravel 9.x / PHP 8.1
**To**: Laravel 10.x / PHP 8.1+
**Branch**: `upgrade/laravel-10.0` (from `upgrade/laravel-9.0`)

---

## Checklist

### Setup
- [X] Create branch `upgrade/laravel-10.0`
- [X] Backup database

### Composer
- [X] `laravel/framework`: `^9.0` → `^10.0`
- [X] `spatie/laravel-ignition`: `^1.0` → `^2.0`
- [X] `nunomaduro/collision`: `^6.1` → `^7.0`
- [X] `phpunit/phpunit`: `^9.5` → `^10.0`
- [X] `spatie/laravel-permission`: `^5.5` → `^6.0`
- [X] Run `docker-compose -f docker-compose.php81.yml exec attendance.web composer update`
- [X] Run `docker-compose -f docker-compose.php81.yml exec attendance.web composer dump-autoload`

### Rector
- [X] Update `rector.php`: `LARAVEL_90` → `LARAVEL_100`
- [X] Run `docker-compose -f docker-compose.php81.yml exec attendance.web vendor/bin/rector process --dry-run`
- [X] Run `docker-compose -f docker-compose.php81.yml exec attendance.web vendor/bin/rector process`

### Manual Changes
- [X] Add native return types to any classes extending framework base classes (Rector handles most)
- [X] Replace deprecated `$dates` property with `$casts` in models (if any)
- [X] Replace `Bus::dispatchNow()` / `dispatch_now()` with `Bus::dispatchSync()` (if used)
- [X] Check `AuthServiceProvider` — `registerPolicies()` call no longer needed in `boot()`
- [X] Review `spatie/laravel-permission` v6 changelog for breaking changes
- [X] PHPUnit 10: update `phpunit.xml` (run `docker-compose -f docker-compose.php81.yml exec attendance.web vendor/bin/phpunit --migrate-configuration`)

### Test
- [X] App boots
- [X] Login works
- [X] Agent CRUD
- [X] Attendance recording
- [X] Excel exports
- [X] Bulk operations (Masivo)
- [X] Image uploads
- [X] Run `docker-compose -f docker-compose.php81.yml exec attendance.web vendor/bin/phpunit`

### Done
- [X] Tag: `git tag laravel-10.0-upgrade`
- [X] Update `CLAUDE.md` status

---

## Key Breaking Changes (Laravel 9 → 10)

| Change                                   | Impact                |
|------------------------------------------|-----------------------|
| PHP 8.1 minimum (already met ✅)          | None                  |
| Native return types on framework classes | Rector handles        |
| `Bus::dispatchNow()` removed             | Search codebase       |
| `$dates` model property deprecated       | Use `$casts`          |
| PHPUnit 10 config format changed         | Run migration command |
| `spatie/laravel-permission` v6           | Review changelog      |

## Resources

- [Official Laravel 10 Upgrade Guide](https://laravel.com/docs/10.x/upgrade)
- Previous: `docs/LARAVEL_9_UPGRADE.md`
