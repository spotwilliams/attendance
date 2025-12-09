# Modernization Setup - Quick Start Guide

## 📁 Files Created

The following files have been created to support your modernization process:

### 1. Documentation

- **`modernize.md`** - Complete 5-phase modernization plan (PHP 5.6 → 8.3, Laravel 5.2 → 12)
- **`project.md`** - Detailed project documentation
- **`project-summary.md`** - Quick project overview
- **`docker/README.md`** - Docker PHP versions quick reference
- **`UPGRADE_SETUP.md`** - This file

### 2. Docker Configuration for PHP 7.4

**Location:** `docker/php/7.4/`

Files created:
- `Dockerfile` - PHP 7.4 Sail-based configuration
- `php.ini` - PHP settings (100M uploads, pcov enabled)
- `supervisord.conf` - Process management
- `start-container` - Container startup script

### 3. Docker Compose

- **`docker-compose.php74.yml`** - Docker Compose configuration for PHP 7.4 + PostgreSQL 13

## 🚀 Quick Start - Phase 1 (PHP 7.4 Upgrade)

### Step 1: Create Branch

```bash
git checkout -b upgrade/php-7.4
```

### Step 2: Backup Database

```bash
# Backup current database
docker-compose exec db.cat pg_dump -U postgres sistema_presentismo > backup_$(date +%Y%m%d).sql

# Or if running locally
pg_dump -U postgres sistema_presentismo > backup_$(date +%Y%m%d).sql
```

### Step 3: Tag Current Version

```bash
git tag pre-upgrade-php-5.6
git push origin pre-upgrade-php-5.6
```

### Step 4: Start PHP 7.4 Environment

```bash
# Stop current containers
docker-compose down

# Start PHP 7.4
docker-compose -f docker-compose.php74.yml up -d

# Watch logs
docker-compose -f docker-compose.php74.yml logs -f web.cat
```

### Step 5: Install Dependencies

```bash
# Access container
docker-compose -f docker-compose.php74.yml exec web.cat bash

# Inside container
composer install
npm install

# Run migrations (if needed)
php artisan migrate

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Step 6: Install Rector

```bash
# Inside container or locally
composer require rector/rector --dev
```

### Step 7: Configure Rector

Create `rector.php` in project root:

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
    ]);

    $rectorConfig->skip([
        __DIR__ . '/app/Modules/*/Views',
        __DIR__ . '/vendor',
    ]);

    // PHP 7.4 upgrade rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
    ]);
};
```

### Step 8: Run Rector (Dry Run First)

```bash
# See what will change (dry run)
vendor/bin/rector process --dry-run

# Review the output carefully
# If acceptable, apply changes
vendor/bin/rector process
```

### Step 9: Update composer.json

Edit `composer.json`:

```json
{
    "require": {
        "php": "^7.4",
        "laravel/framework": "5.2.*"
    }
}
```

```bash
composer update
```

### Step 10: Test Application

```bash
# Run existing tests
vendor/bin/phpunit

# Or access in browser
open http://localhost
```

**Test Checklist:**
- [ ] Application boots successfully
- [ ] Login works
- [ ] Dashboard loads
- [ ] Agent CRUD operations
- [ ] Attendance recording
- [ ] Reports generation
- [ ] Excel exports
- [ ] Image uploads

### Step 11: Commit Changes

```bash
git add .
git commit -m "Phase 1: Upgrade to PHP 7.4

- Created PHP 7.4 Docker Sail configuration
- Applied Rector automated refactoring
- Updated composer.json to require PHP 7.4
- All tests passing
- Application fully functional on PHP 7.4"

git tag php-7.4-upgrade
git push origin upgrade/php-7.4
git push origin php-7.4-upgrade
```

## 🔧 Useful Aliases

Add to your `.bashrc` or `.zshrc`:

```bash
# Sail aliases
alias sail74='docker-compose -f docker-compose.php74.yml'
alias sail='docker-compose'

# Quick commands
alias sail-up='docker-compose up -d'
alias sail-down='docker-compose down'
alias sail-bash='docker-compose exec web.cat bash'
alias sail-art='docker-compose exec web.cat php artisan'
alias sail-composer='docker-compose exec web.cat composer'
alias sail-test='docker-compose exec web.cat php artisan test'

# For PHP 7.4 specifically
alias sail74-up='sail74 up -d'
alias sail74-down='sail74 down'
alias sail74-bash='sail74 exec web.cat bash'
```

Then reload:
```bash
source ~/.zshrc  # or ~/.bashrc
```

Usage:
```bash
sail74 up -d
sail74-bash
sail-art migrate
sail-composer install
```

## 📊 Modernization Phases Overview

| Phase | PHP | Laravel | Duration | Status |
|-------|-----|---------|----------|--------|
| **Phase 1** | 5.6 → 7.4 | 5.2 | 2-3 weeks | 🟡 Ready to start |
| **Phase 2** | 7.4 | 5.2 → 6.0 | 3-4 weeks | ⚪ Pending |
| **Phase 3** | 7.4 → 8.1 | 6 → 8 | 3-4 weeks | ⚪ Pending |
| **Phase 4** | 8.1 | 8 → 10 | 2-3 weeks | ⚪ Pending |
| **Phase 5** | 8.1 → 8.3 | 10 → 12 | 2-3 weeks | ⚪ Pending |
| **Total** | | | **12-17 weeks** | |

## 📝 Next Steps After Phase 1

Once Phase 1 is complete and stable:

1. **Merge to develop/main**
   ```bash
   git checkout develop
   git merge upgrade/php-7.4
   git push origin develop
   ```

2. **Deploy to staging** (if available)
   - Test thoroughly in staging environment
   - Monitor for errors
   - Performance testing

3. **Start Phase 2** (Laravel 5.2 → 6.0)
   ```bash
   git checkout -b upgrade/laravel-6.0
   ```
   - Follow instructions in `modernize.md`
   - Phase 2 includes major Excel package rewrite

## 🆘 Troubleshooting

### Container Won't Start

```bash
# Check logs
sail74 logs web.cat

# Rebuild
sail74 down
sail74 build --no-cache
sail74 up -d
```

### Permission Issues

```bash
# Fix permissions
sudo chown -R $USER:$USER .

# Or inside container
sail74 exec web.cat chown -R sail:sail /var/www/html
```

### Database Connection Failed

Check `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=db.cat        # Must be 'db.cat' not 'localhost'
DB_PORT=5432
DB_DATABASE=sistema_presentismo
DB_USERNAME=sail
DB_PASSWORD=password
```

### Composer Memory Limit

```bash
# Inside container with more memory
sail74 exec web.cat php -d memory_limit=-1 /usr/bin/composer update
```

## 📚 Resources

- **Main Plan**: See `modernize.md` for detailed phase-by-phase instructions
- **Docker Guide**: See `docker/README.md` for Docker commands and tips
- **Project Info**: See `project.md` or `project-summary.md` for project overview
- **Laravel Docs**: https://laravel.com/docs
- **Rector Docs**: https://getrector.com/documentation
- **Laravel Shift**: https://laravelshift.com/ (paid service, alternative to manual upgrade)

## ⚠️ Important Notes

1. **Never skip phases** - Each phase builds on the previous one
2. **Test thoroughly** at each phase before proceeding
3. **Keep backups** of database and code at each milestone
4. **Document issues** you encounter for future reference
5. **Budget time** for unexpected issues (add 20% buffer)
6. **Communicate** progress with team regularly

## 🎯 Success Criteria for Phase 1

- [ ] Application runs on PHP 7.4
- [ ] No PHP errors or warnings in logs
- [ ] All existing tests pass
- [ ] Manual testing checklist complete
- [ ] Performance is acceptable
- [ ] Database migrations work
- [ ] File uploads work
- [ ] Excel exports work
- [ ] Code is committed and tagged
- [ ] Documentation is updated

## 🚦 Ready to Start?

You're all set! Follow these steps:

1. ✅ Read through `modernize.md` Phase 1
2. ✅ Review this Quick Start guide
3. ✅ Create branch: `git checkout -b upgrade/php-7.4`
4. ✅ Backup database
5. ✅ Start Docker: `sail74 up -d`
6. ✅ Begin upgrade process

Good luck! 🚀
