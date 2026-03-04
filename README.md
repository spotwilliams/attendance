# CAT - Sistema de Presentismo

Sistema de gestión de presentismo y haberes para agentes de tránsito.

## Descripción

Aplicación web para el registro diario de asistencia, gestión de contratos, cálculo de haberes y generación de reportes para los agentes de tránsito.

## Stack Tecnológico

- **PHP** 8.3
- **Laravel** 12
- **PostgreSQL** 13
- **Bootstrap 3** + AdminLTE
- **Laravel Sail** (Docker)
- **Pest** (testing)

## Requisitos

- Docker + Docker Compose
- [Laravel Sail](https://laravel.com/docs/sail)

## Instalación

```bash
# Clonar el repositorio
git clone <repo-url>
cd attendance

# Instalar dependencias
composer install

# Copiar variables de entorno
cp .env.example .env

# Levantar los contenedores
./vendor/bin/sail up -d

# Generar clave de aplicación
./vendor/bin/sail artisan key:generate

# Ejecutar migraciones y seeders
./vendor/bin/sail artisan migrate --seed
```

## Uso

```bash
# Levantar el entorno
./vendor/bin/sail up -d

# Detener
./vendor/bin/sail down

# Acceder al shell del contenedor
./vendor/bin/sail shell

# Ver logs
./vendor/bin/sail logs -f attendance.web
```

La aplicación queda disponible en http://localhost.

## Tests

```bash
./vendor/bin/sail artisan test --compact
```

## Estructura

```
app/
├── Models/              # 28 modelos Eloquent
├── Modules/             # Arquitectura modular
│   ├── Agentes/         # Gestión de agentes
│   ├── Configuracion/   # Configuración del sistema
│   ├── Haberes/         # Liquidación de haberes
│   ├── Masivo/          # Operaciones masivas
│   ├── Presentismo/     # Registro de asistencia
│   ├── Reportes/        # Reportes y exportaciones Excel
│   └── Security/        # Autenticación y autorización
├── Repositories/        # Patrón repositorio
├── Policies/            # Políticas de autorización
└── Rules/               # Validaciones personalizadas (CUIT, fechas)
```

## Conceptos Principales

- **Períodos**: Ciclos de facturación del 16 al 15 de cada mes
- **Agentes**: Personal con datos, contratos y asignaciones operativas
- **Presentismo**: Registro diario de asistencia (presente, ausente, justificado, médico, etc.)
- **Contratos**: Locación de servicios o Situación de revista
- **Haberes**: Liquidación calculada en base al presentismo y monto contractual

## Variables de Entorno Relevantes

```env
DB_HOST=attendance.db
DB_PORT=5432
DB_DATABASE=sistema_presentismo
DB_USERNAME=sail
DB_PASSWORD=password
```
