# Comprehensive Project Analysis Report: NPSS (pss_main)

This report provides a detailed, in-depth analysis of the NPSS (National Pest Surveillance System) project, based on a comprehensive review of its source code.

## 1. Project Overview

The NPSS is a sophisticated web application built on the Laravel PHP framework. Its primary function is to serve as a data collection and analysis platform for agricultural pest surveillance, with a specific focus on rice cultivation in Sri Lanka.

The system facilitates data entry by field collectors, manages a complex hierarchy of geographical data (Provinces, Districts, ASCs, AI Ranges), tracks pest occurrences across different rice seasons, and provides powerful data visualization tools through charts and PDF reports. It includes a robust user management system with role-based access control (RBAC).

The architecture heavily relies on the Livewire framework to create a dynamic, single-page application experience with server-side rendering of components.

## 2. Technology Stack

- **Backend Framework:** Laravel (PHP)
- **Frontend Framework:** Livewire
- **Frontend Build Tool:** Vite
- **CSS Framework:** Tailwind CSS
- **Charting Library:** Larapex Charts
- **Data Export:** Maatwebsite/Excel for PDF and Excel generation.
- **Authentication:** Standard Laravel authentication with added Two-Factor Authentication (2FA) and an invitation-based user join system.
- **Database:** Relational SQL database (likely MySQL/PostgreSQL in production, with evidence of SQLite for development).

---

## 3. Database Schema, Models, and Migrations

The application's data structure is defined through a series of migrations and corresponding Eloquent models.

### `users` table
- **Migration:** `2024_09_12_000000_create_users_table.php`
- **Model:** `App\Models\User.php`
- **Key Columns:** `id (uuid)`, `name`, `slug`, `email`, `password`, `image`, `is_active`, `last_logged_in_at`, `two_fa_active`, `invite_token`.
- **Traits:** `HasUuid`, `HasRoles`, `SoftDeletes`, `HasApiTokens`.
- **Relationships:**
    - `invite()`: HasOne `User` (the user who invited this user).
    - `collector()`: HasOne `Collector`.
    - `commonDataCollect()`: HasMany `CommonDataCollect`.
    - `roleUsers()`: HasOne `RoleUser`.
    - `roles()`: BelongsToMany `Role`.

### `roles`, `permissions`, `role_user`, `permission_role` tables
- **Migration:** `2024_08_25_193651_create_roles_tables.php`
- **Models:** `App\Models\Roles\Role.php`, `App\Models\Roles\Permission.php`, etc.
- **Purpose:** Implements a comprehensive Role-Based Access Control (RBAC) system.
- **Structure:**
    - `roles`: Defines user roles (e.g., admin, collector).
    - `permissions`: Defines specific actions a user can perform (e.g., `view_users`, `edit_pests`).
    - `role_user`: Pivot table linking users to roles.
    - `permission_role`: Pivot table linking roles to permissions.

### `rice_seasons` table
- **Migration:** `2024_10_08_102139_create_rice_seasons_table.php`
- **Model:** `App\Models\RiceSeason.php`
- **Key Columns:** `id`, `name`, `start_date`, `end_date`.
- **Relationships:**
    - `collector()`: HasMany `Collector`.

### Geographic Data Tables (`provinces`, `districts`, `as_centers`, `ai_ranges`, `regions`)
- **Migrations:** `...create_provinces_table.php`, `...create_districts_table.php`, etc.
- **Models:** `App\Models\Province.php`, `App\Models\district.php`, etc.
- **Purpose:** Stores the hierarchical geographic data for Sri Lanka.
- **Structure & Relationships:**
    - `regions` (Provincial, Inter Provincial, Mahaweli).
    - `provinces` -> HasMany `district`.
    - `districts` -> BelongsTo `province`, HasMany `As_center`.
    - `as_centers` -> BelongsTo `district`, HasMany `AiRange`.
    - `ai_ranges` -> BelongsTo `As_center`.

### `collectors` table
- **Migration:** `2024_10_08_102148_create_collectors_table.php`
- **Model:** `App\Models\Collector.php`
- **Purpose:** Links a `User` to a specific geographic location (`ai_range`) for a given `rice_season`. This is the central model for field data collection.
- **Key Columns:** `id`, `rice_season_id`, `user_id`, `phone_no`, `region_id`, `province`, `district`, `asc`, `ai_range`, `date_establish`, `established_method`.
- **Relationships:**
    - `getDistrict()`, `getProvince()`, `getAsCenter()`, `getAiRange()`: BelongsTo relationships to the respective geographic models.
    - `user()`: BelongsTo `User`.
    - `riceSeason()`: BelongsTo `RiceSeason`.
    - `commonDataCollect()`: HasMany `CommonDataCollect`.

### `common_data_collects` table
- **Migration:** `2024_10_08_102149_create_common_data_collects_table.php`
- **Model:** `App\Models\CommonDataCollect.php`
- **Purpose:** Represents a single data collection event/visit for a `Collector`.
- **Key Columns:** `id`, `user_id`, `collector_id`, `c_date` (collection date), `temperature`, `growth_s_c`.
- **Relationships:**
    - `user()`: BelongsTo `User`.
    - `collector()`: BelongsTo `Collector`.
    - `pestDataCollect()`: HasMany `PestDataCollect`.

### `pest_data_collects` table
- **Migration:** `2024_10_08_102150_create_pest_data_collects_table.php`
- **Model:** `App\Models\PestDataCollect.php`
- **Purpose:** Stores the actual pest counts for each collection event.
- **Key Columns:** `common_data_collectors_id`, `pest_name`, `location_1`...`location_10`, `total`, `mean`, `code`.
- **Relationships:**
    - `commonDataCollect()`: BelongsTo `CommonDataCollect`.

### Other Tables
- **`audit_trails`**: Logs user actions throughout the application.
- **`sent_emails`**: Logs all outgoing emails from the system.
- **`settings`**: A key-value store for application settings (e.g., site name, logos).
- **`notifications`**: Stores user-specific notifications.
- **`conducted_programs`**: Tracks training programs or events.

---

## 4. Routing and Endpoints

Routes are defined in `routes/web.php` and `routes/api.php`.

### Web Routes (`routes/web.php`)
- **Guest Routes (`middleware: web, guest`):**
    - `/login`, `/register`, `/password/reset`, `/join/{token}`. Handles all user authentication and registration views and actions.
- **Authenticated Routes (`middleware: web, auth, ...`):**
    - **Admin Prefix (`/admin`):**
        - `middleware: role:admin`: All routes for administrators.
        - `/`: `Dashboard` Livewire component.
        - `/settings/...`: Routes for `Settings`, `AuditTrails`, `SentEmails`, and `Roles` management.
        - `/users/...`: Routes for `Users` CRUD operations.
        - `/collector/...`: Routes for admin management of `Collector` records.
        - `/pest/...`: `PestController` resource routes.
        - `/report/...`: `ReportController` resource routes and PDF export routes.
        - `/chart/...`: `ChartController` routes for displaying charts.
    - **Collector Prefix (`/collector`):**
        - `middleware: role:collector`: All routes for data collectors.
        - `/`: `CollectorController@index`.
        - `/create`, `/store`, `/edit/{id}`, `update/{id}`: CRUD for `Collector` records.
        - `/pestdata/...`: CRUD for `PestDataCollect` records.
- **Location Routes:**
    - `/get-districts/{provinceId}`, `/get-as-centers/{districtId}`, `/get-ai-ranges/{ascId}`: API-like routes used by Livewire components to dynamically populate location dropdowns.

### API Routes (`routes/api.php`)
- `middleware: auth:sanctum`:
    - `/user`: Returns the authenticated user.
    - `/updateLocation`: `CommonDataCollectController@updateLocation`.
    - `/store`: `DataController@store`.
- **Public API Routes:**
    - `/register`: `UserController@register`.
    - `/login`: `UserController@loginUser`.

---

## 5. Controllers

### Auth Controllers (`app/Http/Controllers/Auth`)
- `LoginController`, `RegisterController`, `ForgotPasswordController`, `ResetPasswordController`, `JoinController`, `TwoFaController`: Handle all aspects of user authentication, registration, password resets, and 2FA setup.

### Core Application Controllers
- **`CollectorController.php`**: Manages the CRUD operations for `Collector` records, including creating new records for a season and handling dynamic location dropdowns.
- **`PestDataCollectController.php`**: Manages the CRUD for pest data collection events. Contains the core business logic for calculating pest `mean` and `code` values based on tiller and pest counts.
- **`PestController.php`**: Simple CRUD for managing the list of `Pests`.
- **`ChartController.php`**: The central controller for handling chart generation requests. It gathers data from various collectors based on user filters (province, district, season) and passes it to the appropriate Chart class for rendering. Contains the `avarageCalculate` method to aggregate pest data.
- **`ReportController.php`**: Handles the generation of PDF reports, such as the bi-weekly pest memo (`last2weeksDataexportToPDF`) and lists of collectors.
- **`RiceSeasonController.php`**: Contains the `getSeasson` method, a crucial helper that determines the current rice season (Yala/Maha) based on the current date.
- **`UserController.php`**: Handles API-based user creation and login, and exporting user data.

---

## 6. Livewire Components (`app/Http/Livewire`)

Livewire is used extensively for the UI. Key components include:

- **`Admin/Dashboard.php`**: The main admin dashboard.
- **`Admin/Users/Users.php`**: Displays a sortable, filterable table of all users. Handles user deletion and re-sending invitations.
- **`Admin/Users/EditUser.php`**: A wrapper component that houses the various user editing tabs.
- **`Admin/Users/Edit/`**: Contains components for editing a user's `Profile`, `Password`, `Roles`, and `AdminSettings`.
- **`Admin/Roles/Roles.php`**: Manages CRUD for user roles and permissions.
- **`Admin/Collector/CollectorLivewire.php`**: Provides a dynamic, searchable table of all collector records for administrators.
- **`Collector/CollectorLivewire.php`**: (Likely a typo in the provided file list, but logically represents the collector's view of their records).
- **`LocationSelect.php`**: A reusable component that provides dependent dropdowns for Province -> District -> ASC -> AI Range, used in forms.
- **`SeasonSelect.php`**: A similar component for selecting a season and then filtering locations based on available data for that season.

---

## 7. Data Seeding (`database/seeders`)

- **`DatabaseSeeder.php`**: The main seeder that calls all other necessary seeders.
- **`ProvinceDistrictAscAiRangeSeeder.php`**: Crucial seeder that populates the geographic tables from the `database/dbai.csv` file. This is the foundation of the application's location data.
- **`PestSeeder.php`**: Populates the `pests` table with the standard list of pests.
- **`RiceSeasonSeeder.php`**: Populates the `rice_seasons` table with historical and current season data.
- **`RolesDatabaseSeeder.php` & `UserDatabaseSeeder.php`**: Sets up the necessary roles, permissions, and creates the initial admin user.
- **`DummySeeder.php`**: A powerful seeder for generating a large volume of realistic test data. It creates users, assigns them the 'collector' role, and generates `Collector`, `CommonDataCollect`, and `PestDataCollect` records across multiple seasons and locations.

---

## 8. Charting System (`app/Charts`)

The application uses the `LarapexCharts` library, with dedicated classes for building specific charts.
- **`ChartAi.php`**: Generates a bar chart of pest infestation levels for a single AI Range over multiple collection dates.
- **`ChartProvince.php`, `ChartDistrict.php`, `ChartASC.php`, `ChartSeason.php`**: These classes generate aggregate bar charts showing the average pest codes for a selected region (Province, District, etc.) within a specific season.
- **`AllSeasonChart.php`**: Creates a bar chart comparing pest data for a specific location across all available seasons.

Each chart class has a `build()` method that takes the processed pest data and configures the chart's title, axes, and data series before returning the chart object to the view.