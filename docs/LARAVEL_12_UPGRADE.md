# Laravel 12 Upgrade

**From**: Laravel 11.x / PHP 8.2
**To**: Laravel 12.x / PHP 8.3
**Branch**: `laravel-12.0-upgrade` (from `develop`)

---

## Checklist

### Setup
- [X] Create branch `laravel-12.0-upgrade` (from `develop`)
- [X] `docker/php/8.3/` Docker environment already existed — verified correct
- [X] Create `docker-compose.php83.yml`
- [X] Build and start PHP 8.3 container (PHP 8.3.30 confirmed)
- [ ] Backup database

### Composer
- [X] `php`: `^8.2` → `^8.3`
- [X] `laravel/framework`: `^11.0` → `^12.0` (installed v12.53.0)
- [X] `nunomaduro/collision`: `^8.0` — no change needed, compatible ✅
- [X] `phpunit/phpunit`: `^11.0` — no change needed ✅
- [X] `spatie/laravel-ignition`: `^2.0` — compatible ✅
- [X] `maatwebsite/excel`: `^3.1` — compatible ✅
- [ ] `intervention/image`: `^2.7` — still on 2.7, consider upgrading to `^3.0`
- [X] `yajra/laravel-datatables-oracle` — compatible ✅
- [X] Run `docker-compose -f docker-compose.php83.yml exec attendance.web composer update`
- [X] Run `docker-compose -f docker-compose.php83.yml exec attendance.web composer dump-autoload`

### Rector
- [X] Update `rector.php`: `LARAVEL_110` → `LARAVEL_120` (`driftingly/rector-laravel` v2.1 includes it)
- [X] Run rector dry-run — 1 file flagged (`RenameClassRector`: `\Log::` → `\Illuminate\Support\Facades\Log::`)
- [X] Run rector process — 1 file changed (`PersonalesController.php`)
- [X] Re-run rector dry-run with `LARAVEL_120` — 0 changes (codebase already compliant ✅)

### Manual Changes

#### Carbon 3
Laravel 12 bumps Carbon to v3. Review any direct Carbon usage:
- [ ] `Carbon::parse()` / `Carbon::now()` — mostly compatible
- [ ] Check `diffInXxx()` methods — some return types changed to floats
- [ ] Check `isoFormat()` calls — locale handling changed
- [ ] Check `CarbonInterval` usage in schedules or payroll calculations
- [ ] Search codebase: `grep -r "Carbon" app/ --include="*.php" -l`

#### Database / Eloquent
- [ ] `Model::getPdo()` / `Model::getReadPdo()` removed — replace with `DB::getRawPdo()` / `DB::getRawReadPdo()` (search codebase)
- [ ] `castAndFillable` removal — verify no custom casts rely on this behaviour
- [ ] Review any `Model::unguard()` / `Model::reguard()` usage — still supported but audit

#### Routing
- [ ] Laravel 12 no longer includes `APP_URL` as a fallback for `url()` in console — check any artisan commands that generate URLs
- [ ] Verify all named routes still resolve correctly

#### Validation
- [ ] `Rule::unique()` and `Rule::exists()` — minor signature changes in L12; audit `LaboralesRequest`, `LaboralesRequestUpdate`, and other FormRequests
- [ ] Check `Validator::make()` usage in controllers for deprecated rule formats

#### Testing
- [ ] `assertDatabaseHas()` / `assertDatabaseMissing()` — behaviour unchanged, but Carbon 3 date comparisons in factories need review
- [ ] Run full test suite after upgrade

### PHP 8.3 Features / Deprecations
- [ ] `json_validate()` — new built-in; consider replacing any manual JSON validation
- [ ] `array_sum()` / `array_product()` — stricter on mixed types (throws on non-numeric); audit any dynamic array operations in payroll/report calculations
- [ ] Typed class constants — optional modernization (e.g. `EstadoContrato`, `TipoContrato` constants)
- [ ] Dynamic class constant fetch — already works in 8.2, now fully stable
- [ ] Readonly properties in promoted constructor params — no breaking changes

### Test

**Run tests:**
```bash
docker-compose -f docker-compose.php83.yml exec attendance.web php artisan test

# By suite
docker-compose -f docker-compose.php83.yml exec attendance.web php artisan test --testsuite=Feature
docker-compose -f docker-compose.php83.yml exec attendance.web php artisan test --testsuite=Unit
docker-compose -f docker-compose.php83.yml exec attendance.web php artisan test --testsuite=Smoke

# Single file
docker-compose -f docker-compose.php83.yml exec attendance.web php artisan test tests/Feature/AgenteCrudTest.php
```

- [X] App boots (Laravel 12.53.0 / PHP 8.3.30 confirmed)
- [X] PHPUnit suite passes (106/106 ✅)
- [ ] Login works
- [ ] Agent CRUD
- [ ] Attendance recording
- [ ] Excel exports
- [ ] Bulk operations (Masivo)
- [ ] Image uploads

### Done
- [ ] Tag: `laravel-12.0-upgrade` on the merge commit in `develop` (see `docs/UPGRADE_TAGGING.md`)
- [ ] Update `CLAUDE.md` status

---

## Key Breaking Changes (Laravel 11 → 12)

| Change | Impact | Action |
|--------|--------|--------|
| PHP 8.3 minimum | Docker + composer.json | Create `docker/php/8.3/` |
| Carbon v3 dependency | Date arithmetic return types, locale | Audit Carbon usage in app/ |
| `getPdo()` / `getReadPdo()` removed | Any direct PDO calls | Replace with `DB::getRawPdo()` |
| `assertJson()` strict mode changes | Tests using JSON assertions | Review test assertions |
| `Stringable` interface stricter | Any magic `__toString()` | Run tests to surface issues |
| Route `prefix()` trailing slash | URL generation edge cases | Test all named routes |

> **Note**: Laravel 12 is a relatively conservative release compared to L10→L11.
> The biggest pain point is Carbon 3 — audit date handling thoroughly.

---

## Docker Setup (PHP 8.3)

Copy and adapt from the PHP 8.2 setup:

```bash
# Create the PHP 8.3 Docker config directory
cp -r docker/php/8.2/ docker/php/8.3/

# In docker/php/8.3/Dockerfile, change the base image:
# FROM sail-8.2/app  →  FROM sail-8.3/app
# (or FROM php:8.3-fpm depending on the base used)

# Copy docker-compose file
cp docker-compose.php82.yml docker-compose.php83.yml

# In docker-compose.php83.yml, update:
# - image reference: 8.2 → 8.3
# - service/container names: attendance.web → attendance.web83 (or similar)
```

---

## Useful Commands

```bash
# Check PHP version inside container
docker-compose -f docker-compose.php83.yml exec attendance.web php -v

# Check Laravel version
docker-compose -f docker-compose.php83.yml exec attendance.web php artisan --version

# Verify Carbon version
docker-compose -f docker-compose.php83.yml exec attendance.web composer show nesbot/carbon | grep versions

# Run Rector dry-run
docker-compose -f docker-compose.php83.yml exec attendance.web vendor/bin/rector process --dry-run

# Run Rector
docker-compose -f docker-compose.php83.yml exec attendance.web vendor/bin/rector process

# Clear all caches after upgrade
docker-compose -f docker-compose.php83.yml exec attendance.web php artisan optimize:clear
```

---

## Resources

- [Official Laravel 12 Upgrade Guide](https://laravel.com/docs/12.x/upgrade)
- [Carbon 3 Migration Guide](https://carbon.nesbot.com/docs/#api-introduction)
- Previous: `docs/LARAVEL_11_UPGRADE.md`
