## AGENTS.md

### Purpose

This file is a **README for coding agents** working on the `Sistema de Presentismo CAT` project.

It describes:
- How to set up and run the environment.
- How to safely participate in the **modernization process**.
- What tests and checks must be run before finishing a task.

For background and human-focused context, see:
- `CLAUDE.md`
- `docs/modernize.md`
- `docs/UPGRADE_SETUP.md`
- `docs/project-summary.md`

Reference: `https://agents.md/`.

---

## Project & Modernization Overview

- **Domain**: Attendance and payroll management for traffic agents in Argentina.
- **Current legacy stack**: PHP 7.4 (Docker), Laravel 5.2.
- **Target**: Multi-phase upgrade to PHP 8.3 and Laravel 12.
- **Main modules**:
  - `app/Modules/Agentes`: agent data, contracts, operational assignments.
  - `app/Modules/Presentismo`: daily attendance.
  - `app/Modules/Reportes`: reporting and Excel exports.
  - `app/Modules/Security`: authentication and authorization.

**Key business concepts** (do not break without explicit instruction):
- Periods run from 16th → 15th, not calendar months.
- Closed periods cannot be modified.
- Unique attendance per agent/date/period.
- Contract types affect payroll calculations.
- Schedules are split into **4 columns** in Excel exports.

---

## Current Modernization Phase

> Keep this section updated as phases change.

- **Phase**: Phase 1 – PHP 5.6 → 7.4.
- **Typical branches**:
  - `upgrade/php-7.4` – main upgrade branch for this phase.
  - `develop` – integration branch.
  - `main` – production releases (no experiments here).

### In scope for this phase

- Upgrade code to be **PHP 7.4 compatible**.
- Run and fix automated refactors (Rector, etc.) that:
  - Modernize syntax (short arrays, type hints where safe, etc.).
  - Remove PHP 5.6-only constructs.
- Make minimal framework-compatible adjustments required for PHP 7.4.

### Out of scope for this phase

- Introducing **Laravel 6+ APIs** or features.
- Changing business rules (e.g. how periods close, how attendance types behave).
- Changing database schema beyond planned migrations.

If unsure whether something is in-scope, assume **it is out of scope** and leave a note instead of changing behavior.

---

## Environment & Canonical Commands

### Docker (PHP 7.4 environment)

From repo root:

```bash
# Start PHP 7.4 environment
docker-compose -f docker-compose.php74.yml up -d

# Access web container shell
docker-compose -f docker-compose.php74.yml exec web.cat bash

# Watch logs
docker-compose -f docker-compose.php74.yml logs -f web.cat

# Stop containers
docker-compose -f docker-compose.php74.yml down
```

If aliases like `sail74`, `sail74-bash` exist, prefer them but always keep the raw `docker-compose` commands working.

### Composer

Run inside the `web.cat` container:

```bash
# Install dependencies
composer install

# Update dependencies carefully (only when requested)
composer update
```

If you hit memory issues:

```bash
php -d memory_limit=-1 /usr/bin/composer update
```

### Laravel / Artisan

From inside the app container:

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan optimize

php artisan migrate
php artisan db:seed
```

Do **not** run destructive commands (dropping data, resetting DB) unless explicitly requested.

---

## Testing & Verification

Whenever you make code changes, you should:

1. Ensure Docker is up and the app boots without fatal errors.
2. Run at least a **minimal test suite**:

```bash
# From the container, at repo root
vendor/bin/phpunit
```

If a narrower or module-specific test command is documented in a module-level `AGENTS.md` (for example under `app/Modules/Presentismo/AGENTS.md`), run that as well.

**Rules:**

- Do **not** ignore failing tests. Fix them, or revert the change and explain why.
- Do **not** leave the codebase in a state where it does not boot or tests cannot run.

---

## Code Style & Safety Rules

### Versions & APIs

- In `upgrade/php-7.4` and related upgrade branches:
  - Use features supported by **PHP 7.4**, but avoid PHP 8.x-only constructs (union types, attributes, etc.).
  - Keep using **Laravel 5.2 APIs** unless a specific upgrade step is documented.

### Style

- Follow existing coding patterns in the surrounding file.
- Prefer small, mechanical refactors over large rewrites.
- Do not introduce external dependencies unless explicitly requested.

### “Never do this” (unless explicitly requested)

- Do **not** commit `.env` or secrets of any kind.
- Do **not** change database schema directly outside migrations.
- Do **not** modify business rules in:
  - Period closing behavior.
  - Attendance uniqueness or validation.
  - Contract types and payroll rules.
- Do **not** bypass or disable security checks (auth, CSRF, permissions).

If you need to bend any of these, leave a clear explanation instead of silently changing behavior.

---

## Modernization Playbook for Agents

When asked to perform modernization work:

1. **Check branch**
   - Confirm you are on the correct upgrade branch (e.g. `upgrade/php-7.4`).
   - If not, switch or warn the user before proceeding.

2. **Start environment**
   - Bring up Docker using the canonical commands.
   - Confirm the app boots (no fatal errors, basic pages load).

3. **Understand scope**
   - Identify whether the task is:
     - Simple mechanical refactor (e.g. syntax change).
     - Framework-compatibility fix.
     - Potential business-logic change (high risk).
   - For high-risk changes, keep edits minimal and well-documented.

4. **Apply changes**
   - Use automated tools (e.g. Rector) where safe and targeted.
   - Work module-by-module rather than across the entire repo in a single pass.
   - Keep commits small and focused if you are asked to commit.

5. **Run checks**
   - Execute the testing commands in the **Testing & Verification** section.
   - If working in a specific module, also follow its module-level `AGENTS.md` guidance.

6. **Summarize**
   - Clearly list:
     - What was changed.
     - Which commands were run.
     - Any remaining warnings, skipped areas, or open risks.

---

## Git & PR Expectations

Apply these when you are asked to commit or open PRs.

- **Branches**
  - Use existing upgrade branches when possible: `upgrade/php-7.4`, etc.
  - For new work, follow the convention `upgrade/<tech>-<short-description>` where applicable.

- **Commits**
  - Keep them focused (e.g. “Upgrade array syntax in Presentismo module”).
  - Avoid mixing refactors with behavior changes in the same commit.

- **Pull Requests**
  - Title format suggestion: `[modernization] Short description`.
  - PR description should include:
    - Summary of changes.
    - Commands/tests run.
    - Known issues or risks.
  - Do **not** force push to shared branches unless explicitly requested and understood.

---

## Module-Level AGENTS

For complex or high-risk areas, **module-level `AGENTS.md` files** may exist. The closest `AGENTS.md` to the edited file **wins** and can add extra constraints.

Expected locations (examples):

- `app/Modules/Presentismo/AGENTS.md` – invariants around attendance:
  - One attendance per agent/date/period.
  - No future dates.
  - Closed periods cannot be modified.
- `app/Modules/Agentes/AGENTS.md` – rules around contracts, assignments, and status.
- `app/Modules/Reportes/AGENTS.md` – guidance for Excel exports and performance considerations.

When editing files in a module:

- Always read the nearest `AGENTS.md`.
- Apply its more specific rules in addition to this root file.

---

## Security & Data Handling

- Never log or expose sensitive personal or payroll data beyond what is already present in the application logs.
- Do not add debugging dumps (`var_dump`, `dd`, etc.) that may leak sensitive information in production.
- Respect existing authorization and permission checks when adding or altering controller actions and routes.

---

## Keeping This File Up To Date

- Treat `AGENTS.md` as **living documentation**.
- When a modernization phase changes (for example, starting the Laravel 6 upgrade):
  - Update the **Current Modernization Phase** section.
  - Adjust allowed APIs and test commands accordingly.
- When subtle bugs or “gotchas” are discovered during upgrades:
  - Add a short note and, if relevant, an extra test step here or in a module-level `AGENTS.md`.

This file should always reflect the **current expectations** for how agents and automation work safely on this repository.

