# Project Handover Document

## 1. Project Overview

Project Name: Pest Surveillance System (PSS)

Purpose:

- A web-based agricultural pest surveillance system for the Department of Agriculture.
- Replaces manual paper-based data collection with a digital workflow for monitoring, reporting, and analysis.
- Supports multiple user roles such as administrators, collectors, deputy directors, and directors.

Current Status:

- The project is a working Laravel application with role-based access control, reporting, export, dashboards, and audit-related features.
- The repository contains a mix of controller-based logic and Livewire components.
- There are existing static bug notes and editor diagnostics that should be reviewed before major changes.

## 2. Business Context

The system is used to:

- collect pest-related data from the field;
- validate and manage submissions;
- generate reports and exports;
- provide dashboards and trend views for decision-making.

Primary stakeholders include:

- Department of Agriculture users
- System administrators
- Data collectors
- Management and directors

## 3. Technical Stack

Backend:

- PHP 8+
- Laravel 9.4.1
- MySQL
- Eloquent ORM
- Laravel Sanctum

Frontend:

- Blade templates
- Livewire
- Tailwind CSS
- Alpine.js
- Vite
- Chart.js / Larapex Charts

Supporting libraries:

- maatwebsite/excel for Excel exports
- barryvdh/laravel-dompdf for PDF exports
- robthree/twofactorauth for 2FA
- google-gemini-php/laravel for AI-related features

## 4. Repository Structure

Key folders:

- app/ – application logic
    - Http/Controllers/ – request handlers
    - Http/Livewire/ – Livewire components
    - Models/ – Eloquent models
    - Services/ – business logic services
    - Exports/ – export classes
    - Mail/ – mail classes
- resources/ – Blade views, JS, CSS, and assets
- routes/ – web and API routes
- database/ – migrations, seeders, and SQL dump files
- config/ – Laravel configuration files
- public/ – public assets and built frontend output
- tests/ – Pest test suite
- storage/ – logs, cache, uploaded files

Important files:

- [README.md](README.md)
- [project_description.txt](project_description.txt)
- [project_technical_report.txt](project_technical_report.txt)
- [ER_DIAGRAM.md](ER_DIAGRAM.md)
- [BUG_REPORT.md](BUG_REPORT.md)

## 5. Core Application Modules

### Authentication and Access

- Login, registration, password reset, and 2FA are handled under app/Http/Controllers/Auth/.
- Role-based access is enforced through middleware in app/Http/Middleware/Role.php.
- The app uses custom role checks via helper functions and middleware.

### Collector Module

- Main controller: app/Http/Controllers/CollectorController.php
- Handles collector registration, editing, management, and summary views.
- Includes location-based lookups such as district, AS center, and AI range.

### Pest Data Collection

- Main controller: app/Http/Controllers/PestDataCollectController.php
- Handles pest data entry, validation, viewing, editing, and deletion.
- Contains logic for calculating pest codes based on collected values.

### Reporting and Export

- Main controller: app/Http/Controllers/ReportController.php
- Used for report generation and export actions.
- Supports PDF export and other formatted report views.

### Dashboard / Charts / Analytics

- Main controller: app/Http/Controllers/ChartController.php
- Used to serve chart data and dashboard views.
- Livewire components under app/Http/Livewire/Graph/ and related folders are part of the dashboard UI.

### Admin and System Settings

- Admin management screens are implemented through Livewire components in app/Http/Livewire/Admin/.
- Settings and audit-related views are present in the admin routes.

## 6. Routes Overview

Main web routes are defined in routes/web.php.

Key route groups:

- /login and /register – authentication flow
- /admin – administrator dashboard and management tools
- /collector – collector workflows
- /deputy – deputy director dashboard
- /pda – PDA dashboard
- /extensionAndTrainingDirector – extension and training director dashboard

Key route middleware:

- auth
- activeUser
- IpCheckMiddleware
- role:admin / role:collector / role:deputyDirector / etc.

## 7. Main Models

Notable models:

- User – authentication, roles, and account information
- Collector – collector profile and related records
- PestDataCollect – pest observation entries
- Pest – pest master data
- RiceSeason – seasonal information
- CommonDataCollect – shared/aggregate collected data
- AuditTrail – audit log tracking
- Setting – general system settings

## 8. Authentication and Authorization Flow

Current behavior:

- Users authenticate through the Laravel auth system.
- The application uses middleware-based role checks for access control.
- Some flows also rely on custom helper functions and user state checks.

Important notes:

- Make sure any new feature respects the existing role-based route guards.
- Avoid bypassing middleware unless there is a clear and documented reason.

## 9. Local Environment Setup

Requirements:

- PHP 8.0+
- Composer
- Node.js and npm
- MySQL
- Git

Setup steps:

1. Clone the repository.
2. Copy .env.example to .env and configure database values.
3. Install PHP dependencies:
    - composer install
4. Install frontend dependencies:
    - npm install
5. Generate an app key:
    - php artisan key:generate
6. Create or import the database.
7. Run migrations:
    - php artisan migrate
8. Build frontend assets:
    - npm run dev
9. Start the app:
    - php artisan serve

Example commands:

- composer install
- npm install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate
- npm run dev
- php artisan serve

## 10. Database Notes

Database configuration is expected in .env.

Important files in the database folder:

- SQL dump files such as npss_2005_09_16.sql, npss250702.sql, and other backups.
- Migrations under database/migrations/.

Recommended approach:

- Prefer Laravel migrations for new schema changes.
- Use the SQL dump files only as backup/reference data if the project already has a legacy database state.
- Verify schema compatibility before importing any old SQL file into a new environment.

## 11. Common Development Commands

Clear Laravel cache:

- php artisan cache:clear
- php artisan route:clear
- php artisan config:clear
- php artisan view:clear

Run tests:

- php artisan test
- vendor/bin/pest

Code style:

- vendor/bin/pint

Frontend build:

- npm run build

## 12. Testing and Quality Notes

The project uses Pest for tests.

Current evidence from repository artifacts:

- [build_test_results.txt](build_test_results.txt) exists.
- [build_lint_results.txt](build_lint_results.txt) exists.
- [BUG_REPORT.md](BUG_REPORT.md) contains known issues found during static review.

Before making changes:

- review the relevant controller or view first;
- run relevant tests or at least php -l on edited PHP files;
- confirm routes and middleware behavior after any auth-related changes.

## 13. Known Issues / Important Risks

The current repository includes a bug report with several issues that should be checked before major development work.

High priority issues noted in [BUG_REPORT.md](BUG_REPORT.md):

- Assignment used instead of comparison in CollectorController.
- Missing return values in getCollectorCount.
- dd() debug stops in controller and Livewire delete flows.
- Blade markup issues in pest create/edit forms.

Recommended priority order:

1. Fix high-severity controller and Livewire issues.
2. Correct form rendering and Blade component mismatches.
3. Add regression tests for critical workflow areas.

## 14. Recommended Handover Checklist for the Next Developer

Before starting work, confirm:

- local environment is configured correctly;
- .env contains valid database settings;
- app key is generated;
- database is migrated and usable;
- admin login works;
- routes for collector and admin modules are accessible.

Suggested first tasks:

- review authentication and role handling;
- inspect collector and pest data workflows;
- verify export/report generation;
- run the existing test suite and review failures;
- clean up the known issues from the bug report.

## 15. Suggested Starting Points

If you are new to this project, begin here:

- [routes/web.php](routes/web.php)
- [app/Http/Controllers/CollectorController.php](app/Http/Controllers/CollectorController.php)
- [app/Http/Controllers/PestDataCollectController.php](app/Http/Controllers/PestDataCollectController.php)
- [app/Http/Controllers/ReportController.php](app/Http/Controllers/ReportController.php)
- [app/Http/Controllers/ChartController.php](app/Http/Controllers/ChartController.php)
- [app/Models/User.php](app/Models/User.php)
- [app/Http/Middleware/Role.php](app/Http/Middleware/Role.php)

## 16. Notes for Maintenance

- Keep role-based access consistent across controllers and Livewire components.
- Be careful when changing form logic because pest data entry appears to have sensitive validation and calculation rules.
- When changing exports or reports, verify output formats and filenames.
- Always validate database changes with migrations rather than manual database edits.

## 17. Final Note

This project is a functional Laravel-based agricultural surveillance system with solid business value, but it needs careful review of existing logic, especially in controllers and form rendering. The next developer should treat it as a production application and make changes with full validation and regression awareness.
