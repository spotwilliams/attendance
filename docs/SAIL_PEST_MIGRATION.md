# Sail + Pest Migration

**Branch**: `laravel-12.0-upgrade`
**Goal**: Replace versioned docker-compose files with a single Laravel Sail `compose.yaml`, and add Pest as the test runner.

---

## Status

### Done ✅

- **Laravel 12 + PHP 8.3** — `laravel/framework ^12.0`, `php ^8.3`, Rector applied, 106 tests passing
- **Pest installed** — `pestphp/pest ^3.8` + `pestphp/pest-plugin-laravel ^3.2`
  - `tests/Pest.php` created and stripped down to essentials
  - Scaffold example tests removed
- **Laravel Sail installed** — `laravel/sail ^1.53` added to dev dependencies
- **`compose.yaml` created** — Sail's canonical file at project root, configured for:
  - PHP 8.3 (`vendor/laravel/sail/runtimes/8.3`)
  - `postgres:13` (keeping our version, not Sail's default postgres:18)
  - Our custom `docker/postgres/init-databases.sh` (creates test DB)
  - Network named `sail`
- **`sail artisan migrate --seed` failing**

  
### Not Done Yet ⬜

- Confirm `sail artisan test` passes with new `compose.yaml`
- Delete the 4 old versioned files:
  - `docker-compose.php74.yml`
  - `docker-compose.php81.yml`
  - `docker-compose.php82.yml`
  - `docker-compose.php83.yml`
- Update `CLAUDE.md` — new Docker commands (see below)
- Commit everything

---

## New Commands (once working)

```bash
# Start
./vendor/bin/sail up -d
# or
docker-compose up -d

# Stop
./vendor/bin/sail down

# Access shell
./vendor/bin/sail shell

# Artisan
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan test

# Run tests (Pest)
./vendor/bin/sail artisan test
./vendor/bin/sail exec laravel.test ./vendor/bin/pest

# Composer
./vendor/bin/sail composer install
```

---

## Resuming

1. Check the migration error:
   ```bash
   docker-compose exec laravel.test php artisan migrate --seed 2>&1 | grep -v Xdebug | head -30
   ```
2. Once migrations pass, run tests:
   ```bash
   docker-compose exec laravel.test php artisan test
   ```
3. Delete old docker-compose files
4. Update `CLAUDE.md`
5. Commit
