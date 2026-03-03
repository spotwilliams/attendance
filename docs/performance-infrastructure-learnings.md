# Infrastructure & Performance Rules for RedCAT Laravel Projects

**For**: Claude Code agents
**Scope**: Docker, GitHub Actions workflows, PHP runtime, Laravel deployment
**Source**: Optimizations applied to `uber-cat` (2023–2026). Apply to all RedCAT PHP/Laravel projects unless a project explicitly overrides.

---

## How to Use This Document

When you are asked to:
- Create or modify a `Dockerfile` → apply rules in **[Docker](#docker)**
- Create or modify `.github/workflows/*.yml` → apply rules in **[GitHub Actions](#github-actions)**
- Configure PHP for production → apply rules in **[PHP Runtime](#php-runtime)**
- Set up Laravel deployment → apply rules in **[Laravel Deployment](#laravel-deployment)**
- Add or modify queue workers → apply rules in **[Queue Workers](#queue-workers)**

Check the **[Audit Checklist](#audit-checklist)** before marking any infrastructure task complete.

---

## Docker

### Rule: Always Use Multi-Stage Builds

**Trigger**: Any time you write or modify a `Dockerfile`.

Structure stages by how frequently they change. Layers that change less frequently must come first.

```dockerfile
# ============================================
# Stage 1: base
# Changes: only when OS packages or PHP version changes
# ============================================
FROM ubuntu:24.04 AS base

ARG WWWGROUP="1000"
# ... system packages, PHP extensions, Apache, Node, Composer ...

# ============================================
# Stage 2: dependencies
# Changes: only when composer.json/lock or package.json/lock changes
# ============================================
FROM base AS dependencies

ARG COMPOSER_AUTH
WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN --mount=type=cache,target=/root/.composer \
    composer install --optimize-autoloader --prefer-dist --no-progress --no-dev --no-scripts --no-autoloader

COPY package.json package-lock.json ./
RUN --mount=type=cache,target=/root/.npm \
    npm ci --prefer-offline

# ============================================
# Stage 3: final
# Changes: on every code push (expected)
# ============================================
FROM dependencies AS final

COPY . /var/www/html
RUN npm run build
# ... remaining setup ...
```

**MUST**: `COPY . /var/www/html` goes in the final stage only. Never in `base` or `dependencies`.
**MUST**: Use `--mount=type=cache` for both Composer and npm to persist package caches across builds.
**NEVER**: Put application code in an early stage — it invalidates all subsequent layer caches on every commit.

### Rule: Name the FPM Config with `zzz_` Prefix

**Trigger**: When adding a custom PHP-FPM pool config.

```dockerfile
COPY docker/php-fpm.conf /etc/php/8.4/fpm/pool.d/zzz_production.conf
```

The `zzz_` prefix guarantees it loads last and overrides `www.conf` defaults. Without it, your settings may be silently ignored.

---

## GitHub Actions

### Rule: Use `build-push-action` with Registry Cache — Never Build on the Runner

**Trigger**: Any workflow that builds and pushes a Docker image.

**NEVER do this** (duplicates work, no caching):
```yaml
# WRONG — runner installs PHP/Node, then Docker does it again
- name: Install dependencies
  run: composer install && npm install && npm run build
- name: Build image
  run: docker build -t $IMAGE .
```

**Do this instead**:
```yaml
- name: Set up Docker Buildx
  uses: docker/setup-buildx-action@v3

- name: Build, tag, and push
  uses: docker/build-push-action@v6
  with:
    context: .
    file: docker/Dockerfile
    push: true
    provenance: false                          # Required: avoids manifest index issues with ECS
    tags: |
      ${{ steps.login-ecr.outputs.registry }}/${{ env.AWS_NAME }}:${{ github.sha }}
      ${{ steps.login-ecr.outputs.registry }}/${{ env.AWS_NAME }}:latest
    build-args: |
      COMPOSER_AUTH={"github-oauth":{"github.com":"${{ secrets.COMPOSER_TOKEN }}"}}
    cache-from: |
      type=registry,ref=${{ steps.login-ecr.outputs.registry }}/${{ env.AWS_NAME }}:buildcache
      type=registry,ref=${{ steps.login-ecr.outputs.registry }}/${{ env.AWS_NAME }}:latest
    cache-to: type=registry,ref=${{ steps.login-ecr.outputs.registry }}/${{ env.AWS_NAME }}:buildcache,mode=max,image-manifest=true,oci-mediatypes=true
```

**Why each option matters**:
- `cache-from` lists `buildcache` first, then `latest` as fallback — cold caches still get partial hits
- `cache-to: mode=max` exports all intermediate layers, not just the final image
- `provenance: false` prevents a multi-arch manifest index that breaks ECS task registration
- `COMPOSER_AUTH` passed as `build-args`, not `env` — env vars don't reach the Docker build context

### Rule: Cache Runner Dependencies for Non-Docker Jobs

**Trigger**: Any workflow job that runs `composer install` or `npm install` directly on the runner (e.g. linter, static analysis).

```yaml
- name: Cache Composer dependencies
  uses: actions/cache@v3
  with:
    path: |
      vendor
      ~/.composer/cache
    key: composer-${{ hashFiles('**/composer.lock') }}
    restore-keys: composer-

- name: Cache npm dependencies
  uses: actions/cache@v3
  with:
    path: node_modules
    key: npm-${{ hashFiles('**/package-lock.json') }}
    restore-keys: npm-
```

Place these steps **before** the install steps. This is distinct from Docker's `--mount=type=cache` — both should exist in their respective contexts.

### Rule: Always Add Health Checks to MySQL CI Services

**Trigger**: Any workflow that declares a `mysql` service container.

```yaml
services:
  mysql:
    image: mysql:8.4
    env:
      MYSQL_ROOT_PASSWORD: testing_password
      MYSQL_DATABASE: app_testing
    ports:
      - 3306/tcp
    options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3
```

**MUST**: Include `options` with the health check. Without it, jobs start before MySQL is ready and fail with "connection refused" non-deterministically.

### Rule: Run Unit and Feature Tests in Separate Steps

**Trigger**: Any workflow running Pest tests for a Laravel project.

```yaml
- name: Pest Unit Tests
  run: php ./vendor/bin/pest tests/Unit --no-coverage

- name: Pest Feature Tests
  run: php ./vendor/bin/pest tests/Feature --no-coverage
```

**NEVER**: `php ./vendor/bin/pest --no-coverage` (runs all together — causes database state conflicts and flaky failures).

### Rule: Parallelize PHP Syntax Checks

**Trigger**: When adding a PHP lint/syntax step to a workflow.

```yaml
- name: PHP Syntax Check
  run: find . -path ./vendor -prune -o -type f -name "*.php" -print | xargs -P 4 -n 1 php -l
```

`-P 4` = 4 parallel processes. GitHub-hosted runners have 2 cores; self-hosted can go higher.

### Rule: Set Memory Limits for Static Analysis

**Trigger**: When running Larastan/PHPStan in a workflow.

```yaml
- name: Larastan
  run: php ./vendor/bin/phpstan analyse --memory-limit=1G
```

Default memory is insufficient for large Laravel codebases. 1G is the proven minimum.

### Rule: Add Path Filters to Avoid Unnecessary Runs

**Trigger**: When creating or refining workflow triggers.

```yaml
on:
  push:
    paths:
      - 'src/**'
      - 'app/**'
      - 'composer.lock'
      - 'package-lock.json'
      - 'docker/**'
      - '.github/workflows/**'
```

Adjust paths to match the project structure. Without this, documentation-only commits trigger full build+deploy pipelines.

---

## PHP Runtime

### Rule: Enable OPcache with JIT in Production Docker Images

**Trigger**: When writing `docker/php.ini` for a production image.

**Step 1** — Install the extension in `Dockerfile`:
```dockerfile
apt-get install -y php8.4-opcache
```

**Step 2** — Configure in `docker/php.ini`:
```ini
[opcache]
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0
opcache.revalidate_freq=0
opcache.save_comments=1
opcache.enable_cli=0
opcache.jit=tracing
opcache.jit_buffer_size=128M
```

**CRITICAL — `validate_timestamps=0`**: PHP will never detect file changes on disk. This is correct for immutable Docker containers. **NEVER set this in local dev** (Sail / mounted volumes) — PHP changes will appear to have no effect.

**MUST**: `save_comments=1` — Laravel uses docblock annotations. Disabling this breaks the framework.

### Rule: Add Realpath Cache

**Trigger**: Same as OPcache — add alongside it in `docker/php.ini`.

```ini
realpath_cache_size = 4096K
realpath_cache_ttl = 600
```

Eliminates repeated `stat()` syscalls for path resolution. Low risk, measurable gain.

### Rule: Configure PHP-FPM with `pm = dynamic`

**Trigger**: When deploying PHP-FPM in production (not Sail/local).

File: `docker/php-fpm.conf`

```ini
[www]
pm = dynamic

; Formula: (Available RAM - OS reserve) / ~60MB per PHP process
; 50 = safe default for 2–4GB servers; increase for 8GB+
pm.max_children = 50

; Higher start/min prevents spin-up delays on traffic spikes
pm.start_servers = 10
pm.min_spare_servers = 10
pm.max_spare_servers = 15

; Recycle workers to prevent long-running memory leaks
pm.max_requests = 500

; Slow log threshold
slowlog = /var/log/php-fpm-slow.log
request_slowlog_timeout = 5s

; Must match or exceed PHP max_execution_time
request_terminate_timeout = 120s
```

### Rule: Set Memory Limits Correctly — Three Separate Settings

Do not conflate these. Each has a distinct purpose and value:

| Setting | Value | File | Scope |
|---|---|---|---|
| `memory_limit` | `512M` | `docker/php.ini` | Web requests and queue workers |
| PHP-FPM pool `memory_limit` | `128M` (default, not overridden) | FPM pool config | Per-FPM-process cap |
| Larastan `--memory-limit` | `1G` | CI workflow | Static analysis only |

Setting `memory_limit = 512M` goes in the `[PHP]` section of `docker/php.ini`:
```ini
memory_limit = 512M
```

---

## Laravel Deployment

### Rule: Cache Routes, Views, and Events at Container Startup

**Trigger**: When writing or modifying `docker/entrypoint.sh` for the web/app container.

```bash
# Startup caches — run before starting the web server
php artisan event:cache
php artisan route:cache
php artisan view:cache

# DO NOT enable until all env() calls are removed from non-config files:
# php artisan config:cache
```

**Why `config:cache` is disabled**: Laravel's `config:cache` bakes environment values at build time. Any code calling `env()` directly (outside of `config/*.php` files) will get `null` after caching. Audit and remove all direct `env()` calls in app code first, then enable it.

### Rule: Increase Apache Timeout for Long Requests

**Trigger**: Any app that generates reports, processes bulk imports, or has operations > 5 minutes.

File: `docker/vhost.conf`
```apache
# Default is 300 — increase for report generation and bulk operations
Timeout 600
```

---

## Queue Workers

### Rule: Use a Separate Queue for Long-Running Jobs

**Trigger**: When a queued job may run longer than 15 minutes (reports, bulk imports, letter generation).

```php
// Dispatch to the long-running queue
SomeJob::dispatch($data)->onQueue('long-running');
```

**Worker configuration** (supervisor):
- Default queue: `default` — timeout ~15 min
- Long queue: `long-running` — timeout up to 2 hours

**NEVER** dispatch long jobs to the default queue — they will be killed mid-execution by the worker timeout and may leave data in a partial state.

---

## Audit Checklist

Before marking any infrastructure task complete, verify:

**Dockerfile**
- [ ] Multi-stage: `base` → `dependencies` → `final`
- [ ] `COPY . /var/www/html` only in the `final` stage
- [ ] `--mount=type=cache` on Composer and npm installs
- [ ] `php8.4-opcache` installed in `base` stage
- [ ] FPM config copied as `zzz_production.conf`

**PHP Configuration (`docker/php.ini`)**
- [ ] `memory_limit = 512M`
- [ ] OPcache enabled with `validate_timestamps=0`
- [ ] JIT configured (`opcache.jit=tracing`, `jit_buffer_size=128M`)
- [ ] `realpath_cache_size = 4096K`

**PHP-FPM (`docker/php-fpm.conf`)**
- [ ] `pm = dynamic`
- [ ] `start_servers` and `min_spare_servers` ≥ 10
- [ ] `max_requests = 500`

**Apache (`docker/vhost.conf`)**
- [ ] `Timeout 600`

**Entrypoint (`docker/entrypoint.sh`)**
- [ ] `route:cache`, `event:cache`, `view:cache` run at startup

**GitHub Actions (deployment workflows)**
- [ ] `docker/setup-buildx-action@v3` present
- [ ] `docker/build-push-action@v6` used (not `docker build` shell command)
- [ ] `provenance: false` set
- [ ] `cache-from` includes both `buildcache` and `latest`
- [ ] `cache-to: mode=max`
- [ ] No duplicate PHP/Node install steps on the runner
- [ ] Path filters on `on: push:`

**GitHub Actions (linter/test workflows)**
- [ ] `actions/cache@v3` for Composer and npm
- [ ] MySQL service has `--health-cmd="mysqladmin ping"` options
- [ ] Unit and Feature tests in separate steps
- [ ] Larastan run with `--memory-limit=1G`
- [ ] PHP syntax check uses `xargs -P 4`

**Queue Workers**
- [ ] Long-running jobs (> 15 min) dispatched to `long-running` queue
- [ ] Separate supervisor config for `long-running` worker with extended timeout
