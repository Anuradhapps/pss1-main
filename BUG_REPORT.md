# Pest Surveillance System - Bug Report

Generated: 2026-04-02

## Scope

This report is based on static code inspection and editor diagnostics in the current workspace.

- Editor diagnostics: no active VS Code problems were reported.
- Runtime checks (tests/lint in terminal): skipped in this session, so runtime-only failures may still exist.

## Confirmed Bugs

### 1) Assignment used instead of comparison in condition
- Severity: High
- File: `app/Http/Controllers/CollectorController.php:321`
- Code: `if ($seasonId = null)`
- Why this is a bug:
  - This assigns `null` to `$seasonId` instead of comparing it.
  - The condition is always false, so the first branch never executes as intended.

### 2) Missing return values in `getCollectorCount`
- Severity: High
- File: `app/Http/Controllers/CollectorController.php:324`
- File: `app/Http/Controllers/CollectorController.php:326`
- File: `app/Http/Controllers/CollectorController.php:328`
- File: `app/Http/Controllers/CollectorController.php:330`
- Why this is a bug:
  - In these branches, `$collectorCount` is computed but not returned.
  - Function can return `null` unexpectedly, causing incorrect counts and downstream logic issues.

### 3) `dd()` hard-stop in production flow (`CollectorController`)
- Severity: High
- File: `app/Http/Controllers/CollectorController.php:333`
- Code: `dd('No Collector data found');`
- Why this is a bug:
  - `dd()` terminates request execution and exposes debug behavior to users.
  - Should be replaced with controlled error handling (exception, redirect with error, or safe fallback).

### 4) `dd()` hard-stop in Livewire user deletion
- Severity: High
- File: `app/Http/Livewire/Admin/Users/Users.php:98`
- Code: `dd('Delete operation failed');`
- Why this is a bug:
  - Failing deletion crashes UI request instead of returning a user-friendly error.
  - Breaks normal admin workflow and can expose debug internals.

### 5) Invalid Blade switch/case usage in pest create form
- Severity: Medium
- File: `resources/views/pestData/create.blade.php:124`
- File: `resources/views/pestData/create.blade.php:128`
- File: `resources/views/pestData/create.blade.php:132`
- File: `resources/views/pestData/create.blade.php:136`
- File: `resources/views/pestData/create.blade.php:140`
- Why this is a bug:
  - `@switch($pest->name)` is used with boolean `@case($pest->name == '...')` expressions.
  - `@case` should receive matching values (for example `@case('Gall Midge')`), not boolean expressions.
  - Current form can render wrong labels or skip intended branches.

### 6) Mismatched Blade component closing tag in create form
- Severity: Medium
- File: `resources/views/pestData/create.blade.php:166`
- Code opens `<x-form.textarea ...>` but closes `</x-form.input>`
- Why this is a bug:
  - Invalid component structure may break rendering or component parsing.

### 7) Mismatched Blade component closing tag in edit form
- Severity: Medium
- File: `resources/views/pestData/edit.blade.php:91`
- Code opens `<x-form.textarea ...>` but closes `</x-form.input>`
- Why this is a bug:
  - Same markup mismatch issue as create form.

### 8) Non-thrips edit branch incorrectly filters only Thrips data
- Severity: Medium
- File: `resources/views/pestData/edit.blade.php:77`
- Why this is a bug:
  - In the non-thrips branch, condition still checks `@if ($pestData->pest_name == 'Thrips')`.
  - This likely displays wrong existing values for other pests and causes incorrect edits.

## Recommended Next Steps

1. Fix high-severity controller issues first (`CollectorController`, `Users` Livewire).
2. Correct Blade logic and component tags in pest create/edit forms.
3. Run full validation after fixes:
   - `php -l` on project PHP files
   - `php artisan test` or `vendor/bin/pest`
4. Add regression tests for `getCollectorCount` and pest form rendering.
