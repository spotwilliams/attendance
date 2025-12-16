# Authorization Analysis: Policies vs Alternatives

## Current State

- **39 policy files** in `app/Policies/`
- **16 actual usages** of `$this->authorize()` or `Gate::` across 9 files
- Most policies are thin wrappers around permission checks

## Example of Current Pattern

```php
// app/Policies/DashboardPolicy.php
public function index(User $user)
{
    return $this->verifyOnlyControllerPermission($user, 'Datos estadisticos inicio');
}
```

This is just a permission check. The same could be achieved with middleware:

```php
Route::get('/dashboard', 'DashboardController@index')
    ->middleware('permission:Datos estadisticos inicio');
```

## When to Use Each Approach

| Approach | Best For | Current Usage |
|----------|----------|---------------|
| **Middleware** | Route-level access (can/can't access URL) | Most checks fit here |
| **Form Request** | Validating + authorizing input data | Good for store/update |
| **Gates** | Simple, reusable checks without a model | Permission checks |
| **Policies** | Model-specific logic ("can user X edit THIS record?") | Not really used |

## The Real Value of Policies

Policies are designed for authorization that depends on **the specific model instance**:

```php
// TRUE policy use case - checking ownership
public function update(User $user, Post $post)
{
    return $user->id === $post->author_id;
}

// Or checking related data
public function update(User $user, Presentismo $presentismo)
{
    return $user->bases->contains($presentismo->agente->operativo->base_id);
}
```

Current policies don't leverage this - they just check if a user has a permission string, which is what `spatie/laravel-permission` middleware already does.

## What IS Useful in Current Implementation

The `SecurityPolicy` base class has methods that approach real policy logic:

### `verifyCanWorkWithBase(User $user, array $baseIds)`
Checks if user's roles grant access to specific bases.

### `verifyCanWorkWithTurno(User $user, array $turnoIds)`
Checks if user's roles grant access to specific turnos.

These are legitimate policy use cases because they check access to **specific data**, not just generic permissions.

## Recommendation for Simplification

### Keep as Policies
- Complex checks involving base/turno scoping
- Any future checks that depend on the specific model instance

### Move to Middleware
Simple permission checks can use `spatie/laravel-permission` middleware directly:

```php
// routes.php
Route::group(['middleware' => ['permission:Cargar presentismo individual']], function () {
    Route::post('/presentismo', 'PresentismoController@store');
});

// Or in controller constructor
public function __construct()
{
    $this->middleware('permission:Modificar presentismo')->only(['update']);
}
```

### Use Form Requests
Combine authorization + validation:

```php
class StorePresentismoRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->hasPermissionTo('Cargar presentismo individual');
    }

    public function rules()
    {
        return [
            'agente_id' => 'required|exists:agentes,id',
            'fecha' => 'required|date',
            // ...
        ];
    }
}
```

## Potential Refactoring

The 39 policy files could be reduced to ~5-10 that handle actual business logic:

1. `BaseAccessPolicy` - Base/turno scoping logic
2. `AgentePolicy` - Agent-specific access rules
3. `PresentismoPolicy` - Attendance record access
4. `HaberesPolicy` - Payroll access rules
5. `ConfiguracionPolicy` - System configuration access

Everything else moves to route middleware.

## Migration Path

1. **Phase 1**: Identify policies with only simple permission checks
2. **Phase 2**: Move those checks to route middleware
3. **Phase 3**: Consolidate remaining policies
4. **Phase 4**: Remove unused policy files

This is a refactoring decision - not required for Laravel upgrades, but recommended for maintainability.

---

**Last Updated**: 2024-12-12
**Status**: Analysis complete, refactoring pending
