# Sistema de Presentismo CAT

## Overview

**Sistema de Presentismo CAT (Centro de Atención al Tránsito)** is an attendance and payroll management system built for traffic agents in Argentina. The system provides comprehensive functionality for tracking agent attendance (presentismo), managing employment contracts, calculating payments (haberes), and generating detailed reports.

## Technology Stack

### Backend
- **PHP 5.6** with **Laravel 5.2** framework
- **Composer** for dependency management
- **PostgreSQL** as primary database (MySQL support available)

### Frontend
- **Bootstrap 3** (bootstrap-sass)
- **AdminLTE** templates for admin interface
- **Gulp** + **Laravel Elixir** for asset compilation

### Key Dependencies
- `yajra/laravel-datatables-oracle` - DataTables integration
- `maatwebsite/excel` - Excel report generation
- `spatie/laravel-permission` - Role-based access control
- `intervention/image` - Image processing for avatars
- `laravelcollective/html` - Form & HTML helpers

### DevOps
- **Docker** with docker-compose
- **Nginx** web server
- **PostgreSQL** container

## Project Structure

```
sistema-presentismo-cat/
├── app/
│   ├── Console/              # Artisan commands
│   ├── Http/
│   │   ├── Controllers/      # Base controllers
│   │   ├── Helpers/          # Helper utilities
│   │   ├── Middleware/       # Custom middleware
│   │   └── routes.php        # Main routes
│   ├── Models/               # Eloquent models (28 models)
│   ├── Modules/              # Modular architecture
│   │   ├── Agentes/          # Agent management
│   │   ├── Configuracion/    # System configuration
│   │   ├── Haberes/          # Payroll management
│   │   ├── Masivo/           # Bulk operations
│   │   ├── Presentismo/      # Attendance tracking
│   │   ├── Reportes/         # Reporting system
│   │   └── Security/         # Auth & authorization
│   ├── Policies/             # Authorization policies
│   ├── Repositories/         # Repository pattern
│   └── Rules/                # Custom validation rules
├── config/                   # Configuration files
├── database/
│   ├── migrations/           # 70+ database migrations
│   ├── seeds/                # Database seeders
│   └── factories/            # Model factories
├── docker/                   # Docker configuration
├── public/                   # Public web root
├── resources/
│   ├── assets/               # Frontend assets
│   ├── lang/                 # Translations (es)
│   └── views/                # Blade templates
└── tests/                    # PHPUnit tests
```

## Core Features

### 1. Attendance Management (Presentismo)

**Location:** `app/Modules/Presentismo/`

- Daily attendance recording for traffic agents
- Multiple attendance types (present, absent, justified, medical leave, etc.)
- Period-based management (30-day cycles from 16th to 15th of each month)
- Individual and batch attendance entry
- Justification and comment system
- Attendance history tracking

**Key Files:**
- Controller: `app/Modules/Presentismo/Controllers/Registro/RegistroController.php`
- Model: `app/Models/Presentismo.php`

**Schema Highlights:**
- Unique constraint on (agent, date, period)
- Boolean for unjustified absences
- Foreign keys to agent, attendance type, and period

### 2. Agent Management (Agentes)

**Location:** `app/Modules/Agentes/`

- Complete agent profile management
- Personal data: name, DNI, CUIT, birth date, contact information
- Contract management and history
- Operational assignments (base, shift, schedule)
- Avatar/photo management
- Address and education records

**Key Model:** `app/Models/Agente.php`

**Relationships:**
- `hasOne`: contrato, operativo
- `hasMany`: presentismos, haberes, domicilios, facturas

### 3. Contract Management (Contratos)

**Contract Types:**
- Locación de servicios (Service agreement)
- Situación de revista/planta (Permanent staff)

**Features:**
- Contract state tracking
- Historical contract records
- Ingress dates and government service dates
- Contract amounts and modifications
- Contract type and state management

**Key Model:** `app/Models/Contrato.php`

### 4. Payroll Management (Haberes)

**Location:** `app/Modules/Haberes/`

- Invoice/billing calculation based on attendance
- Agent notifications
- Bulk contract modifications
- Period-based calculations
- Amount (monto) management

**Configuration:** `config/cat.php`
```php
'monto_contrato' => 16002,  // Default contract amount
'periodo_comienzo' => 16,    // Period starts on 16th
'periodo_fin' => 15,         // Period ends on 15th
```

### 5. Reporting System (Reportes)

**Location:** `app/Modules/Reportes/`

**Report Types:**
1. General attendance reports by period
2. Individual agent reports
3. Agent master data reports (personal information)
4. Payroll reports (by agent, preview)
5. Excel exports with custom formatting

**Excel Features:**
- Schedules divided into 4 columns
- Comprehensive data exports
- Custom formatting and styling

**Key Controller:** `app/Modules/Reportes/Controllers/Presentismos/Exportar.php`

### 6. Operational Management

**Components:**
- **Bases**: Work locations/stations where agents are assigned
- **Turnos**: Work shifts (includes weekend shifts: FSD, FSN, FSI)
- **Horarios**: Work schedules with detailed time breakdowns
- **Gerencias**: Management units
- **Funciones**: Job functions
- **Cargos**: Positions/roles

### 7. Configuration Module

**Location:** `app/Modules/Configuracion/`

- Area management
- Base management
- Shift configuration
- Attendance type configuration
- Period closure dates
- System parameters

### 8. Security & Permissions

**Location:** `app/Modules/Security/`

- Role-based access control using Spatie Laravel Permission
- User management
- Permission system for granular access control
- Custom middleware for authentication

## Database Architecture

### Core Models (28 Total)

**Primary Entities:**
- `Agente` - Traffic agents
- `Presentismo` - Attendance records
- `Periodo` - Billing periods
- `Contrato` - Employment contracts
- `ContratoHistorico` - Contract history
- `Haber` - Payments/salaries

**Operational Entities:**
- `Operativo` - Agent operational assignments
- `Base` - Work locations
- `Turno` - Work shifts
- `TurnoHistorico` - Shift history
- `Horario` - Schedules

**Configuration Entities:**
- `TipoPresentismo` - Attendance types
- `TipoContrato` - Contract types
- `EstadoContrato` - Contract states
- `EstadoPeriodo` - Period states
- `Area` - Areas
- `Gerencia` - Management units
- `Funcion` - Functions
- `Cargo` - Positions

**Supporting Entities:**
- `DiaPermitido` - Allowed days off
- `Domicilio` - Addresses
- `Estudio` - Education records
- `Comentario` - Comments
- `Notificacion` - Notifications
- `FacturaFisica` - Physical invoices
- `Param` - System parameters

### Key Relationships

**Agente (Agent):**
```
hasOne: contrato, operativo
hasMany: presentismos, haberes, domicilios, facturas, estudios
```

**Presentismo (Attendance):**
```
belongsTo: agente, tipo_presentismo, periodo
```

**Periodo (Period):**
```
hasMany: presentismos, haberes
belongsTo: estado_periodo
```

## Application Architecture

### Modular Design

The application follows a modular architecture where each major feature is encapsulated in its own module under `app/Modules/`. Each module contains:

- **Controllers**: HTTP request handling
- **Models**: Data models (when module-specific)
- **Views**: Blade templates
- **Routes**: Module-specific routes
- **Services**: Business logic
- **Repositories**: Data access layer

### Repository Pattern

The application implements the Repository pattern for data access:
- Located in `app/Repositories/`
- Abstracts database queries from controllers
- Provides consistent interface for data operations

### Custom Validation

Custom validation rules in `app/Rules/`:
- CUIT validation (Argentine tax ID format)
- Date validations
- Contract date validations

### Exception Handling

Custom exceptions in `app/Exceptions/`:
- `AgenteSinTurno` - Agent without shift assigned
- `PeriodoCerrado` - Period is closed
- `FechaFutura` - Future date not allowed
- `BaseTurnoSinPeriodo` - Base/shift without period

## Key Entry Points

### Application Entry
- **Web Entry**: `public/index.php`
- **Main Routes**: `app/Http/routes.php`
- **Module Routes**: Each module has its own `routes.php`

### Main Controllers
- **HomeController**: `app/Http/Controllers/HomeController.php` - Dashboard and overview
- **Module Controllers**: Located in respective module directories

### Middleware
From `app/Http/Kernel.php`:
- `EncryptCookies`
- `VerifyCsrfToken`
- `NotificationMiddleware`
- `InputTrim` (custom)
- `Authenticate`

## Deployment

### Docker-based Setup

**Services:**
1. `app_cat` - PHP 5.6-FPM application container
2. `webserver_cat` - Nginx web server (ports 80, 443)
3. `db_cat` - PostgreSQL database

**Build Process:**
```bash
# Start Docker containers
docker-compose up -d

# Install dependencies
composer install

# Compile assets
gulp --production  # or npm run prod

# Run migrations
php artisan migrate

# Optimize application
php artisan optimize
```

### Environment Configuration

Multiple environment configurations available:
- `.env-local` - Local development
- `.env-mysql` - MySQL configuration
- `.env-postgre-local` - PostgreSQL local
- `.env-pre-docker` - Pre-Docker setup

### Asset Pipeline

**Gulpfile**: `gulpfile.js`
- Gulp + Laravel Elixir
- Bootstrap Sass compilation
- Asset versioning for cache busting

## Business Logic

### Period Management

The system operates on **30-day billing periods**:
- Periods run from the 16th of one month to the 15th of the next
- Configurable in `config/cat.php`
- Periods can be in different states (open, closed)
- Closed periods prevent further attendance modifications

### Attendance Types

Different attendance types handle various scenarios:
- Regular presence
- Absences (justified/unjustified)
- Medical leave
- Vacation days
- Special permissions
- Different rules apply based on contract type (LOCACION vs SITUACION_REVISTA)

### Payroll Calculation

Payroll (haberes) is calculated based on:
- Attendance records for the period
- Contract amount (monto)
- Contract type
- Attendance type impacts on pay
- Justified vs unjustified absences

### Operational Assignments

Each agent can have:
- One active contract
- One operational assignment (operativo)
- Assignment includes: base, shift (turno), schedule (horario)
- Historical tracking of changes

## Recent Improvements

Based on recent commit history:
- Division of schedules into 4 columns in Excel output
- Removal of AM/PM indicators from schedules table
- Fix for duplicate entry times in reports
- Enhancements to personal data reporting

## Testing

- **Framework**: PHPUnit
- **Configuration**: `phpunit.xml`
- **Test Location**: `tests/`
- **Coverage**: Limited test coverage currently implemented

**Note**: User instructions specify using **Pest** for new tests.

## Technical Notes

### Legacy Technology

The application uses **Laravel 5.2** and **PHP 5.6**, which are legacy versions. Considerations:
- Security updates no longer available for these versions
- Modern Laravel features not available
- Upgrade path would be complex due to significant framework changes

### Performance Considerations

- DataTables for efficient large dataset display
- Repository pattern for query optimization
- Asset versioning for browser caching
- Database indexing on foreign keys and unique constraints

### Localization

- Spanish language support in `resources/lang/es/`
- Date formatting for Argentine standards
- CUIT validation for Argentine tax IDs

## Development Workflow

### Common Commands

```bash
# Run development server
php artisan serve

# Run migrations
php artisan migrate

# Compile assets (development)
gulp watch

# Compile assets (production)
gulp --production

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Database Seeding

Seeders available in `database/seeds/` for:
- Initial system configuration
- Test data generation
- User roles and permissions

## Summary

This is a mature, production-ready Laravel application built with a clean modular architecture. It serves a specific business domain (traffic agent attendance and payroll management) with comprehensive features for:

- Daily attendance tracking
- Contract and employment management
- Automated payroll calculations
- Flexible reporting and data export
- Role-based access control
- Operational assignment management

The system is containerized with Docker for easy deployment and uses PostgreSQL for robust data persistence. While built on legacy technology stack, it demonstrates solid software engineering practices including repository pattern, modular design, and comprehensive data modeling.
