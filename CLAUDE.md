# CLAUDE.md - Daily Work Context

## Quick Project Overview

**Sistema de Presentismo CAT** is an attendance and payroll management system for traffic agents in Argentina. Built with PHP/Laravel, it handles daily attendance tracking, contract management, payroll calculations, and comprehensive reporting.

**Current Status**: On branch `upgrade/php-7.4` - Phase 1 of modernization from PHP 5.6 → 8.3, Laravel 5.2 → 12

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

## Docker Commands (PHP 7.4)

```bash
# Start environment
docker-compose -f docker-compose.php74.yml up -d

# Access container
docker-compose -f docker-compose.php74.yml exec web.cat bash

# Watch logs
docker-compose -f docker-compose.php74.yml logs -f web.cat

# Stop containers
docker-compose -f docker-compose.php74.yml down
```

**Aliases** (if configured):
```bash
sail74 up -d          # Start
sail74-bash           # Access container
sail-art migrate      # Run artisan commands
sail-composer install # Composer
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

- Framework: PHPUnit (legacy), use Pest for new tests
- Config: `phpunit.xml`
- Run: `vendor/bin/phpunit`

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
```bash
# Current branch
git status                    # Clean

# Making changes
git add .
git commit -m "Descriptive message"
git push origin upgrade/php-7.4

# Tagging milestones
git tag php-7.4-upgrade
git push origin php-7.4-upgrade
```

## Database Backup

```bash
# Backup before major changes
docker-compose -f docker-compose.php74.yml exec db.cat pg_dump -U sail sistema_presentismo > backup_$(date +%Y%m%d).sql

# Restore if needed
docker-compose -f docker-compose.php74.yml exec -T db.cat psql -U sail sistema_presentismo < backup_YYYYMMDD.sql
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
docker-compose -f docker-compose.php74.yml logs web.cat
docker-compose -f docker-compose.php74.yml down
docker-compose -f docker-compose.php74.yml build --no-cache
docker-compose -f docker-compose.php74.yml up -d
```

### Permission issues
```bash
sudo chown -R $USER:$USER .
# Or inside container
docker-compose -f docker-compose.php74.yml exec web.cat chown -R sail:sail /var/www/html
```

### Database connection failed
Check `.env` has:
- `DB_HOST=db.cat` (NOT localhost when using Docker)
- `DB_PORT=5432`
- `DB_USERNAME=sail`
- `DB_PASSWORD=password`

### Composer memory limit
```bash
docker-compose -f docker-compose.php74.yml exec web.cat php -d memory_limit=-1 /usr/bin/composer update
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

**Main branch**: `upgrade/php-7.4`
**Database**: PostgreSQL 13 (sistema_presentismo)
**PHP Version**: 7.4 (upgrading from 5.6)
**Laravel Version**: 5.2 (legacy)
**Container name**: `web.cat`
**DB container**: `db.cat`
**Web ports**: 80, 443

## When Starting Work

1. Check current branch: `git status`
2. Pull latest: `git pull origin upgrade/php-7.4`
3. Start Docker: `docker-compose -f docker-compose.php74.yml up -d`
4. Check logs: `docker-compose -f docker-compose.php74.yml logs -f web.cat`
5. Access app: http://localhost

## Before Committing

1. Test all critical paths
2. Clear caches
3. Check for PHP errors in logs
4. Verify Docker builds cleanly
5. Update this file if architecture changes

---

**Last Updated**: 2025-12-09
**Current Focus**: PHP 7.4 upgrade testing and validation
**Next Milestone**: Complete Phase 1, tag php-7.4-upgrade
