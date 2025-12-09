# Sistema Presentismo CAT - Modernization Plan

## Overview

This document outlines the strategy to modernize the Sistema Presentismo CAT from:
- **Laravel 5.2 → Laravel 12**
- **PHP 5.6 → PHP 8.3**

## Strategy: Incremental Upgrades

We'll use an incremental approach to minimize risk and ensure stability at each step.

### Why Incremental?

- ✅ Test and validate at each step
- ✅ Easier to identify what breaks and when
- ✅ Less overwhelming than big bang approach
- ✅ Can deploy intermediate versions if needed
- ✅ Team can learn new features gradually

---

## Phase 1: PHP 5.6 → 7.4 (Keep Laravel 5.2)

**Duration Estimate**: 2-3 weeks

**Goal**: Upgrade PHP while keeping the same Laravel version to isolate PHP-specific issues.

### Pre-requisites

1. **Create a new branch**
   ```bash
   git checkout -b upgrade/php-7.4
   ```

2. **Backup everything**
   ```bash
   # Database backup
   pg_dump -U postgres sistema_presentismo > backup_before_upgrade.sql

   # Code backup (git should handle this, but tag it)
   git tag pre-upgrade-php-5.6
   git push origin pre-upgrade-php-5.6
   ```

3. **Install Rector**
   ```bash
   composer require rector/rector --dev
   ```

### Step 1.1: Update Docker Environment

**Good news!** The PHP 7.4 Sail configuration has already been created in `docker/php/7.4/`.

This includes:
- ✅ `Dockerfile` - PHP 7.4 with all required extensions
- ✅ `php.ini` - PHP configuration
- ✅ `supervisord.conf` - Supervisor configuration
- ✅ `start-container` - Container startup script

**Use the PHP 7.4 docker-compose file:**

A dedicated `docker-compose.php74.yml` file has been created. To use it:

```bash
# Stop current containers (if running)
docker-compose down

# Start with PHP 7.4 configuration
docker-compose -f docker-compose.php74.yml up -d

# Or create an alias in your shell profile (.bashrc, .zshrc)
alias sail74='docker-compose -f docker-compose.php74.yml'

# Then you can use:
sail74 up -d
sail74 down
sail74 exec web.cat bash
```

**Key features of the PHP 7.4 Sail setup:**
- Based on Ubuntu 20.04 (Focal)
- PHP 7.4 with all necessary extensions:
  - pgsql, sqlite3, gd, curl, mongodb
  - mysql, mbstring, xml, zip, bcmath, soap
  - intl, readline, ldap
  - redis, memcached, pcov, imagick, xdebug
- PostgreSQL 13 client
- Node.js 18 + npm, yarn
- Composer 2
- Supervisor for process management

**Environment variables to set:**

Create/update your `.env` file:
```env
# App
APP_PORT=80

# Database (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=db.cat
DB_PORT=5432
DB_DATABASE=sistema_presentismo
DB_USERNAME=sail
DB_PASSWORD=password

# Forward ports
FORWARD_DB_PORT=5432

# User (for file permissions)
WWWUSER=1000
WWWGROUP=1000

# Xdebug (optional)
SAIL_XDEBUG_MODE=off
```

### Step 1.2: Configure Rector for PHP 7.4

**Create `rector.php` in project root:**
```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

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

### Step 1.3: Run Rector

```bash
# Dry run first (see what will change)
vendor/bin/rector process --dry-run

# Review the changes carefully
# If acceptable, apply them
vendor/bin/rector process
```

### Step 1.4: Manual PHP 7.4 Compatibility Fixes

**Common Issues to Fix:**

1. **Array/String Access with Curly Braces**
   ```php
   // Old (deprecated in PHP 7.4)
   $char = $string{0};

   // New
   $char = $string[0];
   ```

2. **Compact() with Undefined Variables**
   ```php
   // Old (may fail)
   return view('view', compact('var1', 'var2'));

   // New (ensure variables exist)
   $var1 = $var1 ?? null;
   $var2 = $var2 ?? null;
   return view('view', compact('var1', 'var2'));
   ```

3. **Implode() Parameter Order**
   ```php
   // Old (deprecated)
   implode($array, ',');

   // New (correct)
   implode(',', $array);
   ```

### Step 1.5: Update Composer Dependencies

**Modify `composer.json`:**
```json
{
    "require": {
        "php": "^7.4",
        "laravel/framework": "5.2.*"
    }
}
```

```bash
# Update dependencies
composer update
```

### Step 1.6: Testing

**Create test checklist:**

- [ ] Application boots successfully
- [ ] Login works
- [ ] Dashboard loads
- [ ] Agent CRUD operations
- [ ] Attendance recording (individual and batch)
- [ ] Period management
- [ ] Contract management
- [ ] Payroll calculations
- [ ] Report generation
- [ ] Excel exports
- [ ] Image uploads
- [ ] User permissions

**Run existing tests:**
```bash
vendor/bin/phpunit
```

### Step 1.7: Commit and Tag

```bash
git add .
git commit -m "Upgrade to PHP 7.4"
git tag php-7.4-upgrade
git push origin upgrade/php-7.4
git push origin php-7.4-upgrade
```

---

## Phase 2: Laravel 5.2 → 6.0

**Duration Estimate**: 3-4 weeks

**Goal**: Upgrade Laravel framework with PHP 7.4 support.

### Why Laravel 6.0?

- Long-Term Support (LTS) version
- Better PHP 7.4 support
- Stable upgrade path from 5.x
- Must go through 5.5 first (officially)

### Pre-requisites

1. **Create new branch**
   ```bash
   git checkout -b upgrade/laravel-6.0
   ```

2. **Review Laravel upgrade guides**
   - Laravel 5.2 → 5.5: https://laravel.com/docs/5.5/upgrade
   - Laravel 5.5 → 6.0: https://laravel.com/docs/6.x/upgrade

### Step 2.1: Intermediate Upgrade to Laravel 5.5

**Why 5.5 first?**
- Laravel 5.5 is LTS
- Easier migration path
- Better package support
- Reduces breaking changes in one jump

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^7.4",
        "laravel/framework": "5.5.*",
        "yajra/laravel-datatables-oracle": "~8.0",
        "maatwebsite/excel": "~2.1",
        "spatie/laravel-permission": "^2.0",
        "intervention/image": "^2.4",
        "laravelcollective/html": "^5.5"
    }
}
```

```bash
composer update
```

### Step 2.2: Major Laravel 5.2 → 5.5 Changes

**1. Update Exception Handler**

`app/Exceptions/Handler.php`:
```php
<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    // Laravel 5.5 uses report() and render() methods
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
```

**2. Update Routes Structure**

Laravel 5.5 uses `routes/web.php` instead of `app/Http/routes.php`

```bash
# Move routes
mkdir -p routes
mv app/Http/routes.php routes/web.php
```

Update `RouteServiceProvider` to point to new location.

**3. Update Middleware**

Laravel 5.5 requires middleware priority. Update `app/Http/Kernel.php`:

```php
protected $middlewarePriority = [
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Auth\Middleware\Authenticate::class,
    \Illuminate\Session\Middleware\AuthenticateSession::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    \Illuminate\Auth\Middleware\Authorize::class,
];
```

**4. Blade Directive Changes**

```blade
{{-- Old Laravel 5.2 --}}
{!! $variable !!}

{{-- New Laravel 5.5+ (auto-escaped) --}}
{{ $variable }}

{{-- Raw output --}}
{!! $variable !!}
```

**5. Request Validation**

```php
// Old
$this->validate($request, [...]);

// New (preferred)
$request->validate([...]);
```

### Step 2.3: Upgrade to Laravel 6.0

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^7.4",
        "laravel/framework": "^6.0",
        "yajra/laravel-datatables-oracle": "^9.0",
        "maatwebsite/excel": "^3.1",
        "spatie/laravel-permission": "^3.0",
        "intervention/image": "^2.5",
        "laravelcollective/html": "^6.0"
    }
}
```

```bash
composer update
```

### Step 2.4: Laravel 6.0 Breaking Changes

**1. String and Array Helpers**

Laravel 6.0 removed global helpers. Install package or use facades:

```bash
composer require laravel/helpers
```

Or update code:
```php
// Old
array_get($array, 'key');
str_contains($haystack, $needle);

// New
Arr::get($array, 'key');
Str::contains($haystack, $needle);
```

**2. Carbon Update**

```php
// Old
Carbon::now()->toDateString();

// New (mostly compatible, but check custom formats)
now()->toDateString();
```

**3. Eloquent Changes**

```php
// Check for date casting
class Agente extends Model
{
    protected $casts = [
        'fecha_nacimiento' => 'date', // Now uses Carbon 2.0
    ];
}
```

### Step 2.5: Update Excel Package (maatwebsite/excel 3.x)

**Major rewrite from 2.x to 3.x**

**Old Export (2.x):**
```php
Excel::create('filename', function($excel) {
    $excel->sheet('Sheet1', function($sheet) {
        $sheet->fromArray($data);
    });
})->export('xlsx');
```

**New Export (3.x):**
```php
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresentismosExport;

return Excel::download(new PresentismosExport($data), 'filename.xlsx');
```

**Create Export Classes:**
```php
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PresentismosExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return ['Agente', 'Fecha', 'Tipo', 'Estado'];
    }
}
```

**Update all Excel exports in:**
- `app/Modules/Reportes/Controllers/Presentismos/Exportar.php`
- Any other export controllers

### Step 2.6: Update Spatie Permissions

**Changes from v1 to v3:**

```php
// Old (v1.x)
$user->hasPermissionTo('edit articles');

// New (v3.x) - mostly compatible
$user->hasPermissionTo('edit articles');

// But check role/permission assignment
$user->assignRole('admin');
$user->givePermissionTo('edit articles');
```

### Step 2.7: Configure Rector for Laravel 6

**Update `rector.php`:**
```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Laravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
    ]);

    $rectorConfig->sets([
        LaravelSetList::LARAVEL_60,
    ]);
};
```

```bash
vendor/bin/rector process
```

### Step 2.8: Testing Phase 2

**Extended test checklist:**

- [ ] All Phase 1 tests pass
- [ ] Excel exports work with new format
- [ ] Routes load correctly (web.php)
- [ ] Middleware functions properly
- [ ] Validation rules work
- [ ] Permission checks work
- [ ] String/Array helpers work
- [ ] Date handling is correct
- [ ] File uploads work

### Step 2.9: Commit

```bash
git add .
git commit -m "Upgrade to Laravel 6.0"
git tag laravel-6.0-upgrade
git push origin upgrade/laravel-6.0
```

---

## Phase 3: PHP 7.4 → 8.1 + Laravel 6 → 8

**Duration Estimate**: 3-4 weeks

**Goal**: Jump to PHP 8.1 and Laravel 8 (LTS).

### Pre-requisites

```bash
git checkout -b upgrade/php-8.1-laravel-8
```

### Step 3.1: Upgrade to Laravel 7 First

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^7.4",
        "laravel/framework": "^7.0"
    }
}
```

```bash
composer update
```

**Key Laravel 7 Changes:**

1. **Route Caching Requires Closures Removal**
   ```php
   // Old (won't cache)
   Route::get('/test', function() { return 'test'; });

   // New (cacheable)
   Route::get('/test', 'TestController@index');
   ```

2. **Blade Component Tags**
   ```blade
   {{-- New feature in Laravel 7 --}}
   <x-alert type="error" :message="$message"/>
   ```

3. **Fluent String Operations**
   ```php
   // New in Laravel 7
   use Illuminate\Support\Str;

   $result = Str::of('  Laravel  ')
       ->trim()
       ->replace('Laravel', 'Framework');
   ```

### Step 3.2: Upgrade to Laravel 8

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^7.4|^8.0",
        "laravel/framework": "^8.0",
        "yajra/laravel-datatables-oracle": "^9.18",
        "maatwebsite/excel": "^3.1",
        "spatie/laravel-permission": "^4.0",
        "intervention/image": "^2.5",
        "laravelcollective/html": "^6.2"
    }
}
```

```bash
composer update
```

**Key Laravel 8 Changes:**

1. **Model Factories Redesign**

**Old factory (`database/factories/ModelFactory.php`):**
```php
$factory->define(App\Models\Agente::class, function (Faker $faker) {
    return [
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
    ];
});
```

**New factory (`database/factories/AgenteFactory.php`):**
```php
<?php

namespace Database\Factories;

use App\Models\Agente;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgenteFactory extends Factory
{
    protected $model = Agente::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
        ];
    }
}
```

**Update Model:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    use HasFactory;

    // ... rest of model
}
```

2. **Route Namespace Removal**

**Update `RouteServiceProvider`:**
```php
class RouteServiceProvider extends ServiceProvider
{
    // Remove this property
    // protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
```

**Update routes to use full namespaces:**
```php
// Old
Route::get('/agentes', 'Agentes\AgentesController@index');

// New
use App\Modules\Agentes\Controllers\AgentesController;
Route::get('/agentes', [AgentesController::class, 'index']);
```

3. **Pagination Views**

```bash
# Publish new pagination views
php artisan vendor:publish --tag=laravel-pagination
```

4. **Maintenance Mode Secret**

```bash
# New feature: bypass maintenance mode
php artisan down --secret="custom-secret"
```

### Step 3.3: Upgrade PHP to 8.1

**Update `Dockerfile`:**
```dockerfile
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip gd exif

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
```

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^8.1"
    }
}
```

### Step 3.4: Configure Rector for PHP 8.1

**Update `rector.php`:**
```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Laravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        LaravelSetList::LARAVEL_80,
    ]);
};
```

```bash
vendor/bin/rector process
```

### Step 3.5: PHP 8.0/8.1 Breaking Changes to Fix

**1. Named Arguments**
```php
// Now possible in PHP 8
array_fill(start_index: 0, count: 100, value: 50);
```

**2. Nullsafe Operator**
```php
// Old
$country = null;
if ($session !== null) {
    $user = $session->user;
    if ($user !== null) {
        $address = $user->getAddress();
        if ($address !== null) {
            $country = $address->country;
        }
    }
}

// New (PHP 8)
$country = $session?->user?->getAddress()?->country;
```

**3. Constructor Property Promotion**
```php
// Old
class Periodo {
    private int $id;
    private string $nombre;

    public function __construct(int $id, string $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }
}

// New (PHP 8)
class Periodo {
    public function __construct(
        private int $id,
        private string $nombre
    ) {}
}
```

**4. Match Expression**
```php
// Old
switch ($type) {
    case 'presente':
        $color = 'green';
        break;
    case 'ausente':
        $color = 'red';
        break;
    default:
        $color = 'gray';
}

// New (PHP 8)
$color = match($type) {
    'presente' => 'green',
    'ausente' => 'red',
    default => 'gray',
};
```

**5. Union Types**
```php
// PHP 8
public function setMonto(int|float $monto): void
{
    $this->monto = $monto;
}
```

### Step 3.6: Testing Phase 3

**Critical tests:**

- [ ] All previous tests pass
- [ ] Route syntax updates work
- [ ] Factories work (if using them)
- [ ] No PHP 8.1 deprecation warnings
- [ ] Nullsafe operators work correctly
- [ ] Type hints don't break existing code

### Step 3.7: Commit

```bash
git add .
git commit -m "Upgrade to PHP 8.1 and Laravel 8"
git tag php-8.1-laravel-8-upgrade
git push origin upgrade/php-8.1-laravel-8
```

---

## Phase 4: Laravel 8 → 10

**Duration Estimate**: 2-3 weeks

**Goal**: Upgrade to Laravel 10 (LTS).

### Pre-requisites

```bash
git checkout -b upgrade/laravel-10
```

### Step 4.1: Intermediate Laravel 9 Upgrade

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^8.1",
        "laravel/framework": "^9.0",
        "yajra/laravel-datatables-oracle": "^10.0",
        "maatwebsite/excel": "^3.1",
        "spatie/laravel-permission": "^5.0",
        "intervention/image": "^2.7"
    }
}
```

```bash
composer update
```

**Key Laravel 9 Changes:**

1. **Flysystem 3.x**

Storage paths may change behavior. Test thoroughly:
```php
Storage::disk('local')->put('file.txt', 'contents');
```

2. **Anonymous Migration Classes**

```php
// Old
class CreateAgentesTable extends Migration
{
    public function up() { }
}

// New (Laravel 9)
return new class extends Migration
{
    public function up() { }
};
```

3. **Implicit Route Bindings**

```php
// Now works automatically
Route::get('/agentes/{agente}/contratos/{contrato}', function (Agente $agente, Contrato $contrato) {
    return $contrato->agente->is($agente);
});
```

### Step 4.2: Upgrade to Laravel 10

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^8.1",
        "laravel/framework": "^10.0",
        "yajra/laravel-datatables-oracle": "^10.0",
        "maatwebsite/excel": "^3.1",
        "spatie/laravel-permission": "^5.0",
        "intervention/image": "^2.7"
    }
}
```

```bash
composer update
```

**Key Laravel 10 Changes:**

1. **Native Type Declarations**

Laravel 10 encourages native PHP type declarations:
```php
public function store(Request $request): RedirectResponse
{
    // ...
    return redirect()->route('agentes.index');
}
```

2. **Invokable Validation Rules**

```php
// New style
use Illuminate\Contracts\Validation\ValidationRule;

class CuitValidationRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->isValidCuit($value)) {
            $fail('El CUIT no es válido.');
        }
    }
}
```

3. **Process Improvements**

```php
use Illuminate\Support\Facades\Process;

$result = Process::run('ls -la');
```

### Step 4.3: Configure Rector for Laravel 10

**Update `rector.php`:**
```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Laravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
    ]);

    $rectorConfig->sets([
        LaravelSetList::LARAVEL_100,
    ]);
};
```

```bash
vendor/bin/rector process
```

### Step 4.4: Testing Phase 4

- [ ] All previous functionality works
- [ ] Storage operations work correctly
- [ ] Route bindings work
- [ ] Validation rules work
- [ ] Type declarations don't break code

### Step 4.5: Commit

```bash
git add .
git commit -m "Upgrade to Laravel 10"
git tag laravel-10-upgrade
git push origin upgrade/laravel-10
```

---

## Phase 5: Laravel 10 → 12 + PHP 8.1 → 8.3

**Duration Estimate**: 2-3 weeks

**Goal**: Reach the latest versions.

### Pre-requisites

```bash
git checkout -b upgrade/php-8.3-laravel-12
```

### Step 5.1: Upgrade PHP to 8.3

**Update `Dockerfile`:**
```dockerfile
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip gd exif

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
```

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^8.3"
    }
}
```

### Step 5.2: Upgrade to Laravel 11

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^8.3",
        "laravel/framework": "^11.0",
        "yajra/laravel-datatables-oracle": "^11.0",
        "maatwebsite/excel": "^3.1",
        "spatie/laravel-permission": "^6.0",
        "intervention/image": "^3.0"
    }
}
```

```bash
composer update
```

**Key Laravel 11 Changes:**

1. **Streamlined Application Structure**

Laravel 11 has a more streamlined structure. Some middleware moved to configuration.

2. **Per-Second Rate Limiting**

```php
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/agentes', [AgentesController::class, 'index']);
});
```

3. **Model Casts Method**

```php
class Agente extends Model
{
    // Old
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // New (alternative)
    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }
}
```

### Step 5.3: Upgrade to Laravel 12

**Update `composer.json`:**
```json
{
    "require": {
        "php": "^8.3",
        "laravel/framework": "^12.0",
        "yajra/laravel-datatables-oracle": "^11.0",
        "maatwebsite/excel": "^3.1",
        "spatie/laravel-permission": "^6.0",
        "intervention/image": "^3.0"
    }
}
```

```bash
composer update
```

**Key Laravel 12 Features/Changes:**

(Note: As of writing, Laravel 12 is not yet released. When it comes out, review the official upgrade guide)

1. **Review Official Upgrade Guide**
   ```
   https://laravel.com/docs/12.x/upgrade
   ```

2. **Check for Breaking Changes**

3. **Update Dependencies**

### Step 5.4: PHP 8.2/8.3 Features

**PHP 8.2 Features:**

1. **Readonly Classes**
```php
readonly class Periodo
{
    public function __construct(
        public int $id,
        public string $nombre,
        public string $fecha_inicio,
    ) {}
}
```

2. **Disjunctive Normal Form (DNF) Types**
```php
public function process((Agente&Contrato)|null $data): void
{
    // ...
}
```

**PHP 8.3 Features:**

1. **Typed Class Constants**
```php
class EstadoContrato
{
    public const string ACTIVO = 'activo';
    public const string INACTIVO = 'inactivo';
}
```

2. **Dynamic Class Constant Fetch**
```php
$constant = $object::CONSTANT_NAME;
```

### Step 5.5: Configure Rector for PHP 8.3

**Update `rector.php`:**
```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Laravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_83,
        LaravelSetList::LARAVEL_110, // Update when 120 available
    ]);
};
```

```bash
vendor/bin/rector process
```

### Step 5.6: Final Testing

**Comprehensive test suite:**

- [ ] All core functionality works
- [ ] Performance is acceptable (or improved)
- [ ] No deprecation warnings
- [ ] All tests pass
- [ ] Security checks pass
- [ ] Browser compatibility maintained

**Performance Testing:**
```bash
# Laravel Telescope for debugging
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate

# Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev
```

### Step 5.7: Final Commit

```bash
git add .
git commit -m "Upgrade to PHP 8.3 and Laravel 12"
git tag php-8.3-laravel-12-upgrade
git push origin upgrade/php-8.3-laravel-12
```

---

## Post-Upgrade Tasks

### 1. Code Quality Tools

**Install additional tools:**
```bash
# Static analysis
composer require phpstan/phpstan --dev
composer require larastan/larastan --dev

# Code style
composer require laravel/pint --dev

# Run Pint
./vendor/bin/pint
```

### 2. Update Tests to Pest

Per your requirements, convert tests to Pest:

```bash
composer require pestphp/pest --dev --with-all-dependencies
composer require pestphp/pest-plugin-laravel --dev
./vendor/bin/pest --init
```

**Example Pest Test:**
```php
<?php

use App\Models\Agente;

it('creates an agente', function () {
    $agente = Agente::factory()->create([
        'nombre' => 'Juan',
        'apellido' => 'Pérez',
    ]);

    expect($agente->nombre)->toBe('Juan')
        ->and($agente->apellido)->toBe('Pérez');
});

it('calculates attendance correctly', function () {
    $agente = Agente::factory()->create();

    // Create presentismos
    // ...

    expect($agente->presentismos)->toHaveCount(5);
});
```

### 3. Documentation

**Update documentation:**
- [ ] README.md with new requirements
- [ ] .env.example with new variables
- [ ] Deployment instructions
- [ ] API documentation (if exists)
- [ ] Developer setup guide

### 4. Security Audit

```bash
# Check for security vulnerabilities
composer audit

# Update all dependencies to latest secure versions
composer update
```

### 5. Performance Optimization

**Apply Laravel optimizations:**
```bash
# Config cache
php artisan config:cache

# Route cache
php artisan route:cache

# View cache
php artisan view:cache

# Event cache
php artisan event:cache
```

### 6. Monitoring Setup

**Consider adding:**
- Laravel Telescope (development)
- Laravel Horizon (if using queues)
- Sentry for error tracking
- New Relic or similar APM

---

## Rollback Strategy

For each phase, maintain rollback capability:

### Git-based Rollback
```bash
# List tags
git tag -l

# Rollback to specific version
git checkout php-7.4-upgrade
```

### Database Rollback
```bash
# Before each migration phase
php artisan migrate:status
php artisan migrate:rollback --step=1

# Restore from backup
psql -U postgres sistema_presentismo < backup_before_upgrade.sql
```

### Docker Rollback
```bash
# Keep old Dockerfiles
mv Dockerfile Dockerfile.php8.3
mv Dockerfile.php7.4 Dockerfile

# Rebuild
docker-compose down
docker-compose build
docker-compose up -d
```

---

## Timeline Summary

| Phase | Duration | Milestone |
|-------|----------|-----------|
| Phase 1: PHP 5.6 → 7.4 | 2-3 weeks | PHP 7.4 + Laravel 5.2 |
| Phase 2: Laravel 5.2 → 6.0 | 3-4 weeks | PHP 7.4 + Laravel 6.0 |
| Phase 3: PHP 7.4 → 8.1 + Laravel 8 | 3-4 weeks | PHP 8.1 + Laravel 8 |
| Phase 4: Laravel 8 → 10 | 2-3 weeks | PHP 8.1 + Laravel 10 |
| Phase 5: PHP 8.3 + Laravel 12 | 2-3 weeks | PHP 8.3 + Laravel 12 |
| **Total** | **12-17 weeks** | **Modern Stack** |

---

## Risk Assessment

### High Risk Areas

1. **Excel Exports** - Major package rewrite (maatwebsite/excel 2.x → 3.x)
2. **Route Definitions** - Syntax changes across versions
3. **Model Factories** - Complete redesign in Laravel 8
4. **Custom Middleware** - May break with middleware priority changes
5. **Blade Templates** - Escaping behavior changes

### Mitigation Strategies

- ✅ Comprehensive testing at each phase
- ✅ Maintain parallel environments (old/new)
- ✅ Use feature flags for gradual rollout
- ✅ Keep detailed rollback procedures
- ✅ User acceptance testing after each phase

---

## Resources

### Official Documentation
- Laravel Upgrade Guides: https://laravel.com/docs
- PHP Migration Guides: https://www.php.net/manual/en/appendices.php
- Rector Documentation: https://getrector.com/documentation

### Useful Tools
- Laravel Shift: https://laravelshift.com/
- Rector: https://getrector.com/
- PHPStan: https://phpstan.org/
- Laravel Pint: https://laravel.com/docs/pint

### Community Resources
- Laravel News: https://laravel-news.com/
- Laracasts: https://laracasts.com/
- Laravel Daily: https://laraveldaily.com/

---

## Next Steps

1. **Review this plan** with your team
2. **Set up development environment** for Phase 1
3. **Write comprehensive tests** before starting
4. **Create backup procedures**
5. **Begin Phase 1: PHP 5.6 → 7.4**

Good luck with your modernization! Take it slow, test thoroughly, and don't skip phases.
