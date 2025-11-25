# Sistema de Presentismo CAT - Summary

## What It Is
An attendance and payroll management system for traffic agents (Centro de Atención al Tránsito) in Argentina.

## Tech Stack
- **Backend**: PHP 5.6 + Laravel 5.2 (legacy)
- **Database**: PostgreSQL
- **Frontend**: Bootstrap 3 + AdminLTE
- **Deployment**: Docker (Nginx + PHP-FPM + PostgreSQL)

## Core Functionality

### 1. Attendance Tracking (Presentismo)
- Daily attendance recording for agents
- Multiple attendance types (present, absent, justified, medical, etc.)
- 30-day periods (16th to 15th of each month)
- Individual and batch entry

### 2. Agent Management (Agentes)
- Personal profiles (DNI, CUIT, contact info)
- Contract management
- Operational assignments (base, shift, schedule)
- Photo/avatar management

### 3. Payroll (Haberes)
- Automatic calculation based on attendance
- Period-based billing
- Contract amount management
- Agent notifications

### 4. Reporting (Reportes)
- Attendance reports by period/agent
- Personal data exports
- Payroll reports
- Excel exports with custom formatting

### 5. Configuration
- Work locations (Bases)
- Shifts (Turnos)
- Schedules (Horarios)
- Attendance types
- System parameters

## Architecture
- **Modular design**: 7 main modules (Agentes, Presentismo, Haberes, Reportes, Configuracion, Security, Masivo)
- **Repository pattern** for data access
- **28 Eloquent models**
- **70+ database migrations**
- **Role-based permissions** (Spatie)

## Key Business Rules
- Periods run from 16th to 15th
- Closed periods cannot be modified
- Different attendance rules for contract types
- Payroll calculated from attendance + contract amount

## Deployment
```bash
docker-compose up -d    # Start containers
composer install        # Install dependencies
gulp --production       # Build assets
php artisan migrate     # Run migrations
```
