# Docker PHP Versions - Quick Reference

This project includes multiple PHP versions using Laravel Sail configurations.

## Available PHP Versions

- **PHP 7.4** - `docker/php/7.4/` - For initial Laravel 5.2 upgrade
- **PHP 8.0** - `docker/php/8.0/` - For Laravel 7-8 compatibility
- **PHP 8.1** - `docker/php/8.1/` - For Laravel 8-9 (LTS)
- **PHP 8.2** - `docker/php/8.2/` - For Laravel 10
- **PHP 8.3** - `docker/php/8.3/` - For Laravel 11
- **PHP 8.4** - `docker/php/8.4/` - For Laravel 12 (latest)

## Quick Start

### Using PHP 7.4 (Phase 1)

```bash
# Start containers
docker-compose -f docker-compose.php74.yml up -d

# Access container
docker-compose -f docker-compose.php74.yml exec web.cat bash

# Inside container
composer install
php artisan migrate
```

### Using PHP 8.3 (Current)

```bash
# Start containers
docker-compose up -d

# Access container
docker-compose exec web.cat bash
```

## Creating Aliases (Recommended)

Add to your `.bashrc` or `.zshrc`:

```bash
# Sail aliases for different PHP versions
alias sail74='docker-compose -f docker-compose.php74.yml'
alias sail80='docker-compose -f docker-compose.php80.yml'
alias sail81='docker-compose -f docker-compose.php81.yml'
alias sail83='docker-compose -f docker-compose.php83.yml'
alias sail='docker-compose'  # Current/default version

# Quick commands
alias sail-up='docker-compose up -d'
alias sail-down='docker-compose down'
alias sail-bash='docker-compose exec web.cat bash'
```

Then use:

```bash
sail74 up -d        # Start PHP 7.4
sail74 exec web.cat bash
sail74 down         # Stop PHP 7.4

sail up -d          # Start default (PHP 8.4)
```

## Switching Between Versions

```bash
# Stop current version
docker-compose down

# Start different version
docker-compose -f docker-compose.php74.yml up -d

# Or using aliases
sail down
sail74 up -d
```

## Running Commands

### With docker-compose

```bash
# Run artisan commands
docker-compose exec web.cat php artisan migrate

# Run composer
docker-compose exec web.cat composer install

# Run tests
docker-compose exec web.cat php artisan test

# Run npm
docker-compose exec web.cat npm install
docker-compose exec web.cat npm run dev
```

### With aliases

```bash
# Much cleaner!
sail74 exec web.cat php artisan migrate
sail74 exec web.cat composer install
```

## Common Tasks

### Install Dependencies

```bash
# Inside container
docker-compose exec web.cat bash
composer install
npm install
```

### Run Migrations

```bash
docker-compose exec web.cat php artisan migrate
```

### Clear Caches

```bash
docker-compose exec web.cat php artisan cache:clear
docker-compose exec web.cat php artisan config:clear
docker-compose exec web.cat php artisan view:clear
```

### Access Database

```bash
# PostgreSQL
docker-compose exec db.cat psql -U sail sistema_presentismo

# Or from host (if port forwarded)
psql -h localhost -U sail -d sistema_presentismo
```

## Troubleshooting

### Port Already in Use

```bash
# Check what's using the port
lsof -i :80

# Kill the process or change APP_PORT in .env
APP_PORT=8080
```

### Permission Issues

```bash
# Set correct permissions
sudo chown -R $USER:$USER .

# Or inside container
docker-compose exec web.cat chown -R sail:sail /var/www/html
```

### Container Won't Start

```bash
# View logs
docker-compose logs web.cat

# Rebuild container
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Database Connection Issues

```bash
# Check database is running
docker-compose ps

# Check connection from container
docker-compose exec web.cat ping db.cat

# Verify .env settings
DB_HOST=db.cat  # Not 'localhost' when using Docker
```

## File Structure

Each PHP version folder contains:

```
docker/php/X.X/
├── Dockerfile          # Container configuration
├── php.ini            # PHP settings
├── supervisord.conf   # Process manager config
└── start-container    # Startup script
```

## Customizing PHP Settings

Edit `docker/php/X.X/php.ini`:

```ini
[PHP]
post_max_size = 100M
upload_max_filesize = 100M
memory_limit = 256M
max_execution_time = 300
```

Then rebuild:

```bash
docker-compose build --no-cache
docker-compose up -d
```

## Environment Variables

Key variables in `.env`:

```env
# Port configuration
APP_PORT=80
FORWARD_DB_PORT=5432
VITE_PORT=5173

# User ID (for file permissions)
WWWUSER=1000
WWWGROUP=1000

# Database
DB_CONNECTION=pgsql
DB_HOST=db.cat
DB_PORT=5432
DB_DATABASE=sistema_presentismo
DB_USERNAME=sail
DB_PASSWORD=password

# Xdebug
SAIL_XDEBUG_MODE=off
```

## Best Practices

1. **Always backup** before switching PHP versions
2. **Stop containers** before switching versions
3. **Clear caches** after switching
4. **Test thoroughly** after version change
5. **Use version control** for docker-compose files
6. **Document changes** in commit messages

## Modernization Workflow

```bash
# Phase 1: PHP 7.4
sail74 up -d
sail74 exec web.cat bash
# ... test and develop ...
git commit -m "Phase 1: PHP 7.4 upgrade complete"
sail74 down

# Phase 2: Continue with Laravel upgrade
# ... follow modernize.md ...

# Phase 3: PHP 8.1
sail81 up -d
# ... test and develop ...

# And so on...
```

## Additional Resources

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Modernization Plan](../modernize.md)
