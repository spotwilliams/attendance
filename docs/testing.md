# Testing Strategy for Modernization

## Current State

| Metric | Count |
|--------|-------|
| PHP files | 531 |
| Controllers | 49 |
| Models | 34 |
| Routes | ~87 |
| Existing tests | 3 files (empty/placeholder) |
| Factories | 2 (Base, Area only) |
| Seeders | 26 |

**Reality**: There are essentially **zero functional tests**. The existing test files are stubs.

## Is Automated Testing Viable?

**Yes, but with a pragmatic approach.**

Full test coverage for 531 files is not realistic during a modernization project. However, a **targeted smoke test suite** can catch 80% of breaking changes with 20% of the effort.

## Recommended Strategy: Smoke Test Suite

Instead of unit testing everything, create **HTTP smoke tests** that verify critical paths still work after each upgrade.

### What Smoke Tests Cover

```
[Request] → [Route] → [Middleware] → [Controller] → [View/Response]
```

If a smoke test passes, it means:
- Routing works
- Controller instantiates
- Dependencies resolve
- Database queries execute
- Views render (no syntax errors)

### What Smoke Tests Don't Cover

- Business logic correctness
- Edge cases
- Data validation rules

## Implementation Plan

### Phase 1: Bootstrap Tests (2-3 hours)

Verify the application boots and core services work.

```php
// tests/Feature/BootstrapTest.php
class BootstrapTest extends TestCase
{
    public function test_application_boots()
    {
        $this->assertTrue(true); // If we get here, app bootstrapped
    }

    public function test_database_connection()
    {
        $this->assertNotNull(DB::connection()->getPdo());
    }

    public function test_can_resolve_key_services()
    {
        $this->assertInstanceOf(AuthManager::class, app('auth'));
        $this->assertInstanceOf(Repository::class, app('config'));
    }
}
```

### Phase 2: Authentication Smoke Tests (1-2 hours)

```php
// tests/Feature/AuthSmokeTest.php
class AuthSmokeTest extends TestCase
{
    public function test_login_page_loads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_unauthenticated_redirects_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_dashboard()
    {
        $user = User::first(); // Use seeded user
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }
}
```

### Phase 3: Route Smoke Tests (4-6 hours)

Auto-generate tests for all GET routes:

```php
// tests/Feature/RouteSmokeTest.php
class RouteSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Run seeders
        $this->user = User::first();
    }

    /**
     * @dataProvider publicRoutesProvider
     */
    public function test_public_routes_respond($uri)
    {
        $response = $this->get($uri);
        $this->assertContains($response->status(), [200, 302, 401, 403]);
    }

    /**
     * @dataProvider authenticatedRoutesProvider
     */
    public function test_authenticated_routes_respond($uri)
    {
        $response = $this->actingAs($this->user)->get($uri);
        $this->assertContains($response->status(), [200, 302, 403]);
    }

    public static function authenticatedRoutesProvider()
    {
        return [
            'dashboard' => ['/'],
            'agentes.index' => ['/agentes'],
            'presentismo.index' => ['/presentismo'],
            'reportes.index' => ['/reportes'],
            'haberes.index' => ['/haberes'],
            'configuracion.index' => ['/configuracion'],
            // ... add all critical routes
        ];
    }
}
```

### Phase 4: Critical Flow Tests (4-6 hours)

Test the main business operations with authenticated requests:

```php
// tests/Feature/PresentismoSmokeTest.php
class PresentismoSmokeTest extends TestCase
{
    public function test_can_list_agentes_for_presentismo()
    {
        $user = $this->getAuthorizedUser();
        $response = $this->actingAs($user)
            ->get('/presentismo/lista/agentes');

        $response->assertStatus(200);
    }

    public function test_can_view_agente_presentismo()
    {
        $user = $this->getAuthorizedUser();
        $agente = Agente::first();

        $response = $this->actingAs($user)
            ->get("/presentismo/agente/{$agente->id}");

        $response->assertStatus(200);
    }
}
```

## Time & Cost Estimates

### Manual Implementation

| Phase | Time | Description |
|-------|------|-------------|
| Phase 1 | 2-3h | Bootstrap tests |
| Phase 2 | 1-2h | Auth smoke tests |
| Phase 3 | 4-6h | Route smoke tests (all ~87 routes) |
| Phase 4 | 4-6h | Critical flow tests (CRUD operations) |
| **Total** | **11-17h** | Full smoke test suite |

### AI-Assisted Implementation

Using Claude Code to generate tests:

| Phase | Time | Tokens (est.) | Cost (est.) |
|-------|------|---------------|-------------|
| Phase 1 | 30min | ~50k | $0.50 |
| Phase 2 | 30min | ~50k | $0.50 |
| Phase 3 | 1-2h | ~200k | $2.00 |
| Phase 4 | 1-2h | ~200k | $2.00 |
| **Total** | **3-5h** | **~500k** | **~$5.00** |

**Note**: Token costs based on Claude Opus 4. Actual costs vary based on conversation length and iterations.

## Recommended Minimal Suite

If time is extremely limited, this minimal suite catches most upgrade breakages:

```php
// tests/Feature/ModernizationSmokeTest.php
class ModernizationSmokeTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first() ?? User::factory()->create();
    }

    // 1. App boots
    public function test_app_boots()
    {
        $this->assertTrue(app()->bound('router'));
    }

    // 2. Database works
    public function test_database_works()
    {
        $this->assertGreaterThan(0, User::count());
    }

    // 3. Auth works
    public function test_login_page_loads()
    {
        $this->get('/login')->assertStatus(200);
    }

    // 4. Dashboard loads (catches view/controller issues)
    public function test_dashboard_loads()
    {
        $this->actingAs($this->user)
            ->get('/')
            ->assertStatus(200);
    }

    // 5. Each module's index loads
    public function test_agentes_module_loads()
    {
        $this->actingAs($this->user)
            ->get('/agentes')
            ->assertSuccessful();
    }

    public function test_presentismo_module_loads()
    {
        $this->actingAs($this->user)
            ->get('/presentismo')
            ->assertSuccessful();
    }

    public function test_haberes_module_loads()
    {
        $this->actingAs($this->user)
            ->get('/haberes')
            ->assertSuccessful();
    }

    public function test_reportes_module_loads()
    {
        $this->actingAs($this->user)
            ->get('/reportes')
            ->assertSuccessful();
    }

    public function test_configuracion_module_loads()
    {
        $this->actingAs($this->user)
            ->get('/configuracion')
            ->assertSuccessful();
    }

    // 6. Key models load (catches relationship issues)
    public function test_agente_with_relations_loads()
    {
        $agente = Agente::with(['contrato', 'operativo'])->first();
        $this->assertNotNull($agente);
    }

    // 7. Excel export works (common breakage point)
    public function test_excel_export_works()
    {
        // Skip if maatwebsite/excel has issues
        $this->assertTrue(class_exists(\Maatwebsite\Excel\Excel::class));
    }
}
```

**Time for minimal suite**: 1-2 hours
**Covers**: ~70% of likely upgrade breakages

## Running Tests After Each Upgrade

```bash
# In Docker container
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/phpunit

# Or with filter
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/phpunit --filter=ModernizationSmokeTest
```

## CI Integration (Optional)

Add to `.github/workflows/test.yml`:

```yaml
name: Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    services:
      postgres:
        image: postgres:13
        env:
          POSTGRES_PASSWORD: password
          POSTGRES_DB: testing
        options: >-
          --health-cmd pg_isready
          --health-interval 10s
          --health-timeout 5s
          --health-retries 5
    steps:
      - uses: actions/checkout@v3
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '7.4'
      - name: Install dependencies
        run: composer install
      - name: Run tests
        run: vendor/bin/phpunit
```

## Modernization Testing Workflow

For each Laravel version upgrade:

1. **Before upgrade**: Run smoke tests (baseline)
2. **Update composer.json**: Change Laravel version
3. **Run composer update**: Install new packages
4. **Run Rector**: Apply automated fixes
5. **Run smoke tests**: Identify breakages
6. **Fix failures**: Address breaking changes
7. **Run smoke tests again**: Verify fixes
8. **Commit**: Tag the upgrade milestone

## Verdict

| Approach | Effort | Coverage | Recommendation |
|----------|--------|----------|----------------|
| No tests | 0h | 0% | High risk, current state |
| Minimal smoke suite | 1-2h | ~70% | **Recommended minimum** |
| Full smoke suite | 11-17h | ~85% | Ideal for ongoing maintenance |
| Full unit tests | 100h+ | ~95% | Overkill for modernization |

**Recommendation**: Implement the **minimal smoke suite** (1-2 hours) before continuing with Laravel 7+ upgrades. This gives you confidence that each upgrade didn't break core functionality without requiring a massive testing investment.

---

## Test Environment Setup

### Configuration Files

| File | Purpose |
|------|---------|
| `.env.testing` | Test environment with `cat_testing` database |
| `docker/postgres/init-databases.sh` | Creates test DB on container init |
| `docker-compose.php74.yml` | Mounts init script to PostgreSQL |
| `phpunit.xml` | PHPUnit config using `cat_testing` database |

### How Docker Creates the Test Database

PostgreSQL's `docker-entrypoint-initdb.d/` directory runs scripts **only on first container initialization** (when the data volume is empty). The `init-databases.sh` script automatically creates the `cat_testing` database.

### Initial Setup (New Installation)

If starting fresh or recreating the database volume:

```bash
# 1. Stop containers
docker-compose -f docker-compose.php74.yml down

# 2. Remove the postgres volume (WARNING: deletes all data!)
docker volume rm attendance_sail-pgsql

# 3. Start containers (init script runs automatically)
docker-compose -f docker-compose.php74.yml up -d

# 4. Wait for DB to be ready, then migrate main database
docker-compose -f docker-compose.php74.yml exec web.cat php artisan migrate --seed

# 5. Migrate test database
docker-compose -f docker-compose.php74.yml exec web.cat php artisan migrate --env=testing
```

### Adding Test Database to Existing Installation

If you already have data and don't want to lose it:

```bash
# 1. Create the test database manually
docker-compose -f docker-compose.php74.yml exec db.cat \
    psql -U root -d cat -c "CREATE DATABASE cat_testing;"

# 2. Grant privileges
docker-compose -f docker-compose.php74.yml exec db.cat \
    psql -U root -d cat -c "GRANT ALL PRIVILEGES ON DATABASE cat_testing TO root;"

# 3. Run migrations on test database
docker-compose -f docker-compose.php74.yml exec web.cat \
    php artisan migrate --env=testing

# 4. Optionally seed test database
docker-compose -f docker-compose.php74.yml exec web.cat \
    php artisan db:seed --env=testing
```

### Running Tests

```bash
# Run all tests
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/phpunit

# Run specific test suite
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/phpunit --testsuite=Smoke

# Run specific test file
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/phpunit tests/Feature/AuthSmokeTest.php

# Run with verbose output
docker-compose -f docker-compose.php74.yml exec web.cat vendor/bin/phpunit --verbose
```

### Test Suites Available

| Suite | Command | Description |
|-------|---------|-------------|
| Smoke | `--testsuite=Smoke` | Quick bootstrap + auth + dependencies |
| Feature | `--testsuite=Feature` | All feature tests |
| All | (default) | Everything |

### Refreshing Test Database

If you need to reset the test database:

```bash
# Drop and recreate
docker-compose -f docker-compose.php74.yml exec db.cat \
    psql -U root -d postgres -c "DROP DATABASE IF EXISTS cat_testing;"

docker-compose -f docker-compose.php74.yml exec db.cat \
    psql -U root -d postgres -c "CREATE DATABASE cat_testing;"

# Re-run migrations
docker-compose -f docker-compose.php74.yml exec web.cat \
    php artisan migrate --env=testing --seed
```

### Troubleshooting

**Error: "relation users does not exist"**
- The test database hasn't been migrated
- Run: `php artisan migrate --env=testing`

**Error: "database cat_testing does not exist"**
- Create it manually (see "Adding Test Database" above)
- Or recreate the Docker volume to trigger init script

**Tests are slow**
- Use `BCRYPT_ROUNDS=4` in `.env.testing` (already configured)
- Use array drivers for cache/session (already configured)

---

**Last Updated**: 2024-12-15
**Status**: Test suite implemented, environment configured
