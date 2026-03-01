## Git tagging strategy for upgrades

This document describes how to create and maintain git tags for each major modernization phase of **Sistema Presentismo CAT**.

The goal is that every completed upgrade can be referenced quickly (for rollbacks, debugging, and deployments) by a clearly named tag that lives on the `develop` branch.

---

## Naming convention

- **Format**: `<area>-<version>-upgrade`
- **Examples**:
  - `php-7.4-upgrade`
  - `laravel-6.0-upgrade`
  - `laravel-7.0-upgrade`
  - `laravel-8.0-upgrade`
  - `laravel-9.0-upgrade`
  - `laravel-10.0-upgrade`
  - Future: `laravel-11.0-upgrade`, `php-8.3-laravel-12-upgrade`, etc.

This matches the examples already used in `docs/modernize.md` and the existing `laravel-8.0-upgrade` tag in the repo.

---

## General process per upgrade

For every major upgrade phase (PHP or Laravel), follow this flow:

1. **Work on a feature branch**
   - Branch naming convention (already in use):
     - `upgrade/php-7.4`
     - `upgrade/laravel-6.0`
     - `upgrade/laravel-7.0`
     - `upgrade/laravel-8.0`
     - `upgrade/laravel-9.0`
     - `upgrade/10x` (for Laravel 10)
   - Implement the upgrade, fix tests, run the manual test checklist.

2. **Merge into `develop` via PR**
   - Open a PR from the `upgrade/*` branch into `develop`.
   - Once code review, CI, and manual checks pass, merge the PR using a **merge commit** (current pattern in the repo).

3. **Create a tag on the merge commit in `develop`**
   - After the PR is merged and `develop` is up to date locally:
   - Find the merge commit for the upgrade (examples below).
   - Create an **annotated tag** pointing to that merge commit:
     ```bash
     # General pattern
     git checkout develop
     git pull origin develop

     # Create an annotated tag for this upgrade
     git tag -a <tag-name> -m "Mark <tag-name> completion"

     # Push tag to remote
     git push origin <tag-name>
     ```

4. **(Optional) Backfill tags for previous phases**
   - For past upgrades that are already merged, you can retroactively create tags on the corresponding merge commits (see next section).

---

## Recommended tags for existing upgrades

Based on the current git history (`git log --oneline --decorate --graph`), the following upgrades and merge commits exist on `develop`:

- PHP 7.4 upgrade:
  - Merge commit: `f5e3727 Merge pull request #1 from spotwilliams/upgrade/php-7.4`
  - Recommended tag: **`php-7.4-upgrade`**
- Laravel 6.0 upgrade:
  - Merge commit: `4b9ca55 Merge pull request #4 from spotwilliams/upgrade/laravel-6.0`
  - Recommended tag: **`laravel-6.0-upgrade`**
- Laravel 7.0 upgrade:
  - Merge commit: `95b2a86 Merge pull request #6 from spotwilliams/upgrade/laravel-7.0`
  - Recommended tag: **`laravel-7.0-upgrade`**
- Laravel 8.0 upgrade:
  - Merge commit: `99b9a4d Merge pull request #7 from spotwilliams/upgrade/laravel-8.0`
  - Tag **already exists**: **`laravel-8.0-upgrade`**
- Laravel 9.0 upgrade:
  - Merge commit: `b1dcd8e Merge pull request #10 from spotwilliams/upgrade/laravel-9.0`
  - Recommended tag: **`laravel-9.0-upgrade`**
- Laravel 10.x upgrade:
  - Branch name: `upgrade/10x` (contains commits such as `upgrade/10x: Upgrade to Laravel 10`)
  - Merge commit: part of `588e08d Merge pull request #12 from spotwilliams/upgrade/10x`
  - Recommended tag: **`laravel-10.0-upgrade`**

You can verify the commit hashes with:

```bash
git log --oneline --decorate --graph --max-count=40
```

---

## How to create the missing tags (retroactive)

From your local clone:

```bash
cd /path/to/attendance

# Make sure we are up to date
git checkout develop
git pull origin develop

# (Optional) inspect history and confirm commit IDs
git log --oneline --decorate --graph --max-count=40

# PHP 7.4 upgrade
git tag -a php-7.4-upgrade f5e3727 -m "Mark PHP 7.4 upgrade completion"

# Laravel 6.0 upgrade
git tag -a laravel-6.0-upgrade 4b9ca55 -m "Mark Laravel 6.0 upgrade completion"

# Laravel 7.0 upgrade
git tag -a laravel-7.0-upgrade 95b2a86 -m "Mark Laravel 7.0 upgrade completion"

# Laravel 9.0 upgrade
git tag -a laravel-9.0-upgrade b1dcd8e -m "Mark Laravel 9.0 upgrade completion"

# Laravel 10.0 upgrade (from upgrade/10x)
git tag -a laravel-10.0-upgrade 588e08d -m "Mark Laravel 10.0 upgrade completion"

# Push all newly created tags
git push origin php-7.4-upgrade laravel-6.0-upgrade laravel-7.0-upgrade laravel-9.0-upgrade laravel-10.0-upgrade
```

If you prefer, you can omit the explicit commit hash when you are checked out on the merge commit (for example, right after merging the PR), and simply run:

```bash
git tag -a php-7.4-upgrade -m "Mark PHP 7.4 upgrade completion"
git push origin php-7.4-upgrade
```

---

## How to tag future upgrades

When starting a new major upgrade (for example, `upgrade/laravel-11.0` or `upgrade/php-8.3-laravel-12`), follow this checklist:

1. **Create / use an `upgrade/*` branch**
   ```bash
   git checkout -b upgrade/laravel-11.0
   ```

2. **Implement and test the upgrade**
   - Run automated tests.
   - Use the checklists from `docs/modernize.md`.

3. **Merge into `develop` via PR**
   - Ensure the merge commit message clearly indicates the upgrade (e.g. “Merge pull request #NN from spotwilliams/upgrade/laravel-11.0”).

4. **Create and push the tag immediately after the merge**
   ```bash
   git checkout develop
   git pull origin develop

   # Example for Laravel 11
   git tag -a laravel-11.0-upgrade -m "Mark Laravel 11.0 upgrade completion"
   git push origin laravel-11.0-upgrade
   ```

5. **Document the tag in the modernization docs**
   - Optionally append a short note in `docs/modernize.md` under the corresponding phase, referencing the new tag name.

---

## Using tags for rollbacks and debugging

- **List all upgrade tags**:
  ```bash
  git tag -l "*upgrade"
  ```

- **Check out a previous upgrade state (detached HEAD)**:
  ```bash
  git checkout laravel-8.0-upgrade
  ```

- **Create a hotfix branch from a tag**:
  ```bash
  git checkout -b hotfix/from-laravel-8 laravel-8.0-upgrade
  ```

Having a consistent, documented tagging strategy ensures that each modernization step is auditable, reproducible, and easy to debug or roll back if needed.

