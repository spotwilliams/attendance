# CLAUDE.md - Daily Work Context

## Quick Project Overview

**Sistema de Presentismo CAT** is an attendance and payroll management system for traffic agents in Argentina. Built with PHP/Laravel, it handles daily attendance tracking, contract management, payroll calculations, and comprehensive reporting.

**Current Status**: Phase 1 of modernization from PHP 5.6 → 8.3, Laravel 5.2 → 12 (working on upgrade branches)

## Tech Stack

- **Backend**: PHP 7.4 (upgrading from 5.6) + Laravel 5.2 (legacy)
- **Database**: PostgreSQL 13
- **Frontend**: Bootstrap 3 + AdminLTE
- **Build Tools**: Gulp + Laravel Elixir
- **Deployment**: Docker (Nginx + PHP-FPM + PostgreSQL)

## Project Structure

```
attendance/
├── app/
│   ├── Models/              # 28 Eloquent models
│   ├── Modules/             # 7 main modules (modular architecture)
│   │   ├── Agentes/         # Agent management
│   │   ├── Configuracion/   # System configuration
│   │   ├── Haberes/         # Payroll management
│   │   ├── Masivo/          # Bulk operations
│   │   ├── Presentismo/     # Attendance tracking
│   │   ├── Reportes/        # Reporting & Excel exports
│   │   └── Security/        # Auth & authorization
│   ├── Repositories/        # Repository pattern for data access
│   ├── Policies/            # Authorization policies
│   └── Rules/               # Custom validation (CUIT, dates)
├── database/migrations/     # 70+ migrations
├── docker/                  # Docker configurations
│   └── php/7.4/            # Current PHP 7.4 setup
└── docs/                    # Project documentation
```

## Core Business Concepts

### 1. Periods (Períodos)
- Billing cycles from 16th to 15th (30 days)
- Can be OPEN or CLOSED (closed prevents modifications)
- Configured in `config/cat.php`

### 2. Agents (Agentes)
- Traffic agents with personal data, contracts, operational assignments
- Key model: `app/Models/Agente.php`
- Relationships: contracts, attendance, payroll, addresses, invoices

### 3. Attendance (Presentismo)
- Daily attendance records
- Multiple types: present, absent, justified, medical, etc.
- Unique constraint per agent/date/period
- Key model: `app/Models/Presentismo.php`

### 4. Contracts (Contratos)
- Two types: Locación de servicios, Situación de revista
- Contract amount (monto): default 16002
- Historical tracking via `ContratoHistorico`

### 5. Payroll (Haberes)
- Calculated from attendance + contract amount
- Period-based billing
- Agent notifications

### 6. Operational Assignments (Operativos)
- Base: work location
- Turno: shift (includes weekend shifts FSD, FSN, FSI)
- Horario: schedule (split into 4 columns in Excel)

## Key Models & Relationships

**Primary Entities:**
- `Agente` → hasOne(contrato, operativo), hasMany(presentismos, haberes)
- `Presentismo` → belongsTo(agente, tipo_presentismo, periodo)
- `Periodo` → hasMany(presentismos, haberes)
- `Contrato` → belongsTo(agente)

**Configuration:**
- `TipoPresentismo`, `TipoContrato`, `EstadoContrato`, `EstadoPeriodo`
- `Base`, `Turno`, `Horario`, `Area`, `Gerencia`, `Funcion`, `Cargo`

## Branching Strategy

**Main Branches:**
- `develop` - Active development branch (target for all feature/upgrade merges)
- `main` - Production releases (deployment process TBD)

**Modernization Branches:**
- `upgrade/php-7.4` - Phase 1: PHP 5.6 → 7.4
- `upgrade/laravel-9.0` - Phase 2: Laravel 5.2 → 9.0
- `upgrade/*` - Additional phases as needed

**Workflow:**
1. Work on feature/upgrade branch (e.g., `upgrade/php-7.4`)
2. When phase complete → merge to `develop`
3. Test in `develop`
4. Eventually release `develop` → `main` (process TBD)

**CI/CD Triggers:**
- Runs on pushes to: `develop`, `main`
- Runs on PRs to: `develop`, `main`
- Upgrade branches tested via PRs before merging

## Docker Commands (Laravel Sail — PHP 8.3)

```bash
# Start environment
./vendor/bin/sail up -d

# Stop containers
./vendor/bin/sail down

# Access shell
./vendor/bin/sail shell

# Watch logs
./vendor/bin/sail logs -f attendance.web

# Artisan
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan migrate --seed

# Run tests (Pest)
./vendor/bin/sail artisan test

# Composer
./vendor/bin/sail composer install
```

## Common Artisan Commands

```bash
# Cache management
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan optimize

# Database
php artisan migrate
php artisan db:seed

# Development
php artisan serve
```

## Asset Compilation

```bash
# Development (watch)
gulp watch

# Production build
gulp --production

# Alternative (npm)
npm run dev
npm run prod
```

## Testing

- Framework: Pest (PHPUnit under the hood)
- Config: `phpunit.xml`
- Run: `./vendor/bin/sail artisan test`

## Key Files to Know

**Configuration:**
- `config/cat.php` - System parameters (period dates, contract amounts)
- `.env` - Environment variables
- `composer.json` - Dependencies

**Entry Points:**
- `public/index.php` - Web entry
- `app/Http/routes.php` - Main routes
- Each module has its own `routes.php`

**Important Controllers:**
- `app/Http/Controllers/HomeController.php` - Dashboard
- `app/Modules/Presentismo/Controllers/Registro/RegistroController.php` - Attendance
- `app/Modules/Reportes/Controllers/Presentismos/Exportar.php` - Excel exports

## Modernization Progress

### Current Phase: Phase 1 (PHP 7.4)
**Status**: Docker build working, testing phase
**Branch**: `upgrade/php-7.4`

**Completed:**
- ✅ Created PHP 7.4 Docker Sail configuration
- ✅ Docker containers building successfully
- ✅ PostgreSQL 13 setup

**Next Steps:**
- [ ] Run Rector automated refactoring
- [ ] Update composer.json to require PHP 7.4
- [ ] Full application testing
- [ ] Commit and tag php-7.4-upgrade

### Modernization Roadmap

| Phase | Upgrade | Duration | Status |
|-------|---------|----------|--------|
| Phase 1 | PHP 5.6 → 7.4 | 2-3 weeks | 🟡 In Progress |
| Phase 2 | Laravel 5.2 → 6.0 | 3-4 weeks | ⚪ Pending |
| Phase 3 | PHP 7.4 → 8.1, Laravel 6 → 8 | 3-4 weeks | ⚪ Pending |
| Phase 4 | Laravel 8 → 10 | 2-3 weeks | ⚪ Pending |
| Phase 5 | PHP 8.1 → 8.3, Laravel 10 → 12 | 2-3 weeks | ⚪ Pending |

## Recent Changes (from git log)

- b235282: PHPxx extra files to be reviewed later
- 89ef884: PHP74. Docker build working ⭐ **Current**
- 74512e6: Removing backups
- dcd594c: Se divide el horario en 4 columnas en el excel de salida
- 56416e5: Remove AM/PM from horarios table

## Development Workflow

### Making Changes
1. Always read files before modifying
2. Use repository pattern for data access
3. Follow modular architecture (keep changes within modules)
4. Avoid over-engineering (keep it simple)
5. Test thoroughly before committing

### Testing Checklist
- [ ] Application boots successfully
- [ ] Login works
- [ ] Dashboard loads
- [ ] Agent CRUD operations
- [ ] Attendance recording
- [ ] Reports generation
- [ ] Excel exports
- [ ] Image uploads

### Git Workflow

**Working on Modernization:**
```bash
# Create/switch to upgrade branch
git checkout -b upgrade/php-7.4

# Making changes
git add .
git commit -m "Descriptive message"
git push origin upgrade/php-7.4

# When phase complete - merge to develop
git checkout develop
git pull origin develop
git merge upgrade/php-7.4
git push origin develop

# Tagging milestones
git tag php-7.4-complete
git push origin php-7.4-complete
```

**Merging to Production:**
```bash
# When ready for release (process TBD)
git checkout main
git merge develop
git tag v1.0.0
git push origin main --tags
```

## Database Backup

```bash
# Backup before major changes
./vendor/bin/sail exec attendance.db pg_dump -U sail sistema_presentismo > backup_$(date +%Y%m%d).sql

# Restore if needed
./vendor/bin/sail exec -T attendance.db psql -U sail sistema_presentismo < backup_YYYYMMDD.sql
```

## Important Business Rules

1. **Periods run 16th to 15th** - Not calendar months
2. **Closed periods cannot be modified** - Exception handling required
3. **Unique attendance per agent/date/period** - Database constraint
4. **Contract types affect payroll** - Different rules for each type
5. **Schedules now split into 4 columns** - Excel export requirement

## Custom Validation Rules

Located in `app/Rules/`:
- CUIT validation (Argentine tax ID format: XX-XXXXXXXX-X)
- Date validations (no future dates for attendance)
- Contract date validations

## Custom Exceptions

Located in `app/Exceptions/`:
- `AgenteSinTurno` - Agent without shift assigned
- `PeriodoCerrado` - Period is closed
- `FechaFutura` - Future date not allowed
- `BaseTurnoSinPeriodo` - Base/shift without period

## Troubleshooting

### Container won't start
```bash
./vendor/bin/sail logs attendance.web
./vendor/bin/sail down
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d
```

### Permission issues
```bash
sudo chown -R $USER:$USER .
# Or inside container
./vendor/bin/sail exec attendance.web chown -R sail:sail /var/www/html
```

### Database connection failed
Check `.env` has:
- `DB_HOST=attendance.db` (NOT localhost when using Docker)
- `DB_PORT=5432`
- `DB_USERNAME=sail`
- `DB_PASSWORD=password`

### Composer memory limit
```bash
./vendor/bin/sail exec attendance.web php -d memory_limit=-1 /usr/bin/composer update
```

## Security Notes

- Never commit `.env` files
- Avoid command injection, XSS, SQL injection (OWASP Top 10)
- Use repository pattern for database queries (prevents SQL injection)
- CSRF protection enabled via middleware
- Role-based access control (Spatie)

## Key Dependencies

- `yajra/laravel-datatables-oracle` - DataTables
- `maatwebsite/excel` - Excel exports (will be replaced in Phase 2)
- `spatie/laravel-permission` - Roles & permissions
- `intervention/image` - Image processing
- `laravelcollective/html` - Form helpers

## Resources

- **Full Modernization Plan**: `docs/modernize.md`
- **Quick Start Guide**: `docs/UPGRADE_SETUP.md`
- **Project Details**: `docs/project.md`
- **Quick Summary**: `docs/project-summary.md`
- **Docker Guide**: `docker/README.md`

## Quick Reference

**Main Branches**: `develop` (active), `main` (releases)
**Current Work**: Modernization on `upgrade/*` branches
**Database**: PostgreSQL 13 (sistema_presentismo)
**Current PHP**: 8.3
**Laravel Version**: 12
**Container name**: `attendance.web`
**DB container**: `attendance.db`
**Web ports**: 80, 443

## When Starting Work

1. Check current branch: `git status`
2. Pull latest from develop: `git pull origin develop`
3. Start Docker: `./vendor/bin/sail up -d`
4. Check logs: `./vendor/bin/sail logs -f attendance.web`
5. Access app: http://localhost

## Before Committing

1. Test all critical paths
2. Clear caches
3. Check for PHP errors in logs
4. Verify Docker builds cleanly
5. Update this file if architecture changes

---

**Last Updated**: 2026-03-04
**Current Focus**: Laravel 12 + PHP 8.3 upgrade complete, Sail + Pest migration done
**Next Milestone**: Merge `laravel-12.0-upgrade` to develop
**Branching**: develop (main) → main (releases), work on upgrade/* branches

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5
- inertiajs/inertia-laravel (INERTIA_LARAVEL) - v2
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v3
- phpunit/phpunit (PHPUNIT) - v11
- rector/rector (RECTOR) - v2
- @inertiajs/vue3 (INERTIA_VUE) - v2
- vue (VUE) - v3
- tailwindcss (TAILWINDCSS) - v4

## Skills Activation

This project has domain-specific skills available. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

- `laravel-best-practices` — Apply this skill whenever writing, reviewing, or refactoring Laravel PHP code. This includes creating or modifying controllers, models, migrations, form requests, policies, jobs, scheduled commands, service classes, and Eloquent queries. Triggers for N+1 and query performance issues, caching strategies, authorization and security patterns, validation, error handling, queue and job configuration, route definitions, and architectural decisions. Also use for Laravel code reviews and refactoring existing Laravel code to follow best practices. Covers any task involving Laravel backend PHP code patterns.
- `pest-testing` — Use this skill for Pest PHP testing in Laravel projects only. Trigger whenever any test is being written, edited, fixed, or refactored — including fixing tests that broke after a code change, adding assertions, converting PHPUnit to Pest, adding datasets, and TDD workflows. Always activate when the user asks how to write something in Pest, mentions test files or directories (tests/Feature, tests/Unit) or architecture tests. Covers: it()/expect() syntax, datasets, mocking, browser testing, arch(), Livewire component tests, RefreshDatabase, and all Pest 4 features. Do not use for editing factories, seeders, migrations, controllers, models, or non-test PHP code.
- `inertia-vue-development` — Develops Inertia.js v2 Vue client-side applications. Activates when creating Vue pages, forms, or navigation; using <Link>, <Form>, useForm, or router; working with deferred props, prefetching, or polling; or when user mentions Vue with Inertia, Vue pages, Vue forms, or Vue navigation.
- `tailwindcss-development` — Always invoke when the user's message includes 'tailwind' in any form. Also invoke for: building responsive grid layouts (multi-column card grids, product grids), flex/grid page structures (dashboards with sidebars, fixed topbars, mobile-toggle navs), styling UI components (cards, tables, navbars, pricing sections, forms, inputs, badges), adding dark mode variants, fixing spacing or typography, and Tailwind v3/v4 work. The core use case: writing or fixing Tailwind utility classes in HTML templates (Blade, JSX, Vue). Skip for backend PHP logic, database queries, API routes, JavaScript with no HTML/CSS component, CSS file audits, build tool configuration, and vanilla CSS.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `vendor/bin/sail npm run build`, `vendor/bin/sail npm run dev`, or `vendor/bin/sail composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `vendor/bin/sail artisan route:list`). Use `vendor/bin/sail artisan list` to discover available commands and `vendor/bin/sail artisan [command] --help` to check parameters.
- Inspect routes with `vendor/bin/sail artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `vendor/bin/sail artisan config:show app.name`, `vendor/bin/sail artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `vendor/bin/sail artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `vendor/bin/sail artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== sail rules ===

# Laravel Sail

- This project runs inside Laravel Sail's Docker containers. You MUST execute all commands through Sail.
- Start services using `vendor/bin/sail up -d` and stop them with `vendor/bin/sail stop`.
- Open the application in the browser by running `vendor/bin/sail open`.
- Always prefix PHP, Artisan, Composer, and Node commands with `vendor/bin/sail`. Examples:
    - Run Artisan Commands: `vendor/bin/sail artisan migrate`
    - Install Composer packages: `vendor/bin/sail composer install`
    - Execute Node commands: `vendor/bin/sail npm run dev`
    - Execute PHP scripts: `vendor/bin/sail php [script]`
- View all available Sail commands by running `vendor/bin/sail` without arguments.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `vendor/bin/sail artisan test --compact` with a specific filename or filter.

=== inertia-laravel/core rules ===

# Inertia

- Inertia creates fully client-side rendered SPAs without modern SPA complexity, leveraging existing server-side patterns.
- Components live in `resources/js/pages` (unless specified in `vite.config.js`). Use `Inertia::render()` for server-side routing instead of Blade views.
- ALWAYS use `search-docs` tool for version-specific Inertia documentation and updated code examples.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

# Inertia v2

- Use all Inertia features from v1 and v2. Check the documentation before making changes to ensure the correct approach.
- New features: deferred props, infinite scroll, merging props, polling, prefetching, once props, flash data.
- When using deferred props, add an empty state with a pulsing or animated skeleton.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `vendor/bin/sail artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `vendor/bin/sail artisan list` and check their parameters with `vendor/bin/sail artisan [command] --help`.
- If you're creating a generic PHP class, use `vendor/bin/sail artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `vendor/bin/sail artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `vendor/bin/sail artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `vendor/bin/sail npm run build` or ask the user to run `vendor/bin/sail npm run dev` or `vendor/bin/sail composer run dev`.

=== laravel/v12 rules ===

# Laravel 12

- CRITICAL: ALWAYS use `search-docs` tool for version-specific Laravel documentation and updated code examples.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

## Laravel 12 Structure

- In Laravel 12, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app/Console/Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

## Database

- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 12 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `vendor/bin/sail artisan make:test --pest {name}`.
- Run tests: `vendor/bin/sail artisan test --compact` or filter: `vendor/bin/sail artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

=== inertia-vue/core rules ===

# Inertia + Vue

Vue components must have a single root element.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

</laravel-boost-guidelines>
