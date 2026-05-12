# Pest Surveillance System (PSS)

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-9.4.1-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)
![Status](https://img.shields.io/badge/Status-Active-brightgreen?style=flat-square)

**A Modern, Role-Based Agricultural Pest Surveillance System**

[Overview](#overview) • [Features](#features) • [Tech Stack](#tech-stack) • [Installation](#installation) • [Usage](#usage) • [Architecture](#architecture)

</div>

---

## Overview

The **Pest Surveillance System (PSS)** is a comprehensive, production-ready web application developed for the **Department of Agriculture - National Plant Protection Service**. This data-driven platform digitalizes the entire agricultural pest surveillance workflow, replacing traditional paper-based systems with an efficient, role-based digital solution.

The PSS enables agricultural stakeholders to collect, validate, manage, and analyze pest-related data in real-time, providing actionable insights for effective pest management and strategic decision-making.

### Project Status
- ✅ **Production Deployed** - Live with the Department of Agriculture
- ✅ **Fully Functional** - All core features operational
- ⚠️ **Known Issues** - See [Known Issues](#known-issues) section for details

---

## Key Features

### 🔐 Role-Based Access Control (RBAC)
The system implements a granular role-based permission system with distinct interfaces for different stakeholder groups:

| Role | Responsibilities | Access Level |
|------|------------------|--------------|
| **Administrator** | User management, system settings, complete data oversight | Full system access |
| **Data Collectors** | Field pest data collection and submission | Limited to their entries |
| **Deputy Directors** | Regional oversight and reporting | Regional data access |
| **Extension & Training Directors** | Program management and training coordination | Program-level data |
| **Directors** | Strategic overview and high-level reporting | Complete data visibility |

### 📊 Data Management & Analysis
- **Data Collection**: User-friendly interface for submitting comprehensive pest-related data
- **Data Validation**: Robust validation rules ensure data accuracy and integrity
- **Data Reporting**: Generate PDF and Excel exports with customizable reports
- **Real-Time Dashboards**: Role-specific dashboards with interactive visualizations
- **Audit Trails**: Complete activity logging for accountability and compliance

### 📈 Advanced Visualization
- **Interactive Charts**: Dynamic charts using Larapex Charts library
- **Pest Trend Analysis**: Visual representation of pest distribution and severity
- **Performance Metrics**: Key indicators and KPIs for decision-making
- **Customizable Reports**: Generate reports tailored to specific user needs

### 🔒 Security Features
- **Two-Factor Authentication (2FA)**: Enhanced account security
- **Email Notifications**: Automated alerts for important system events
- **Session Management**: Secure user session handling
- **Data Encryption**: Sensitive data protection
- **Audit Logging**: Complete trail of user activities

### 📱 Modern User Experience
- **Responsive Design**: Works seamlessly on desktop and mobile devices
- **Dynamic UI**: Livewire-powered reactive interfaces with real-time updates
- **Intuitive Navigation**: Clean, organized interface for easy data entry
- **Fast Performance**: Optimized database queries and caching

---

## Tech Stack

### Backend
- **Framework**: Laravel 9.4.1 - Expressive PHP web framework
- **Language**: PHP 8.0+ - Latest PHP features and performance
- **Database**: MySQL - Reliable relational database
- **ORM**: Eloquent - Elegant database abstraction
- **Architecture**: MVC with modular design pattern

### Frontend
- **UI Framework**: Livewire 2.12 - Full-stack reactive components
- **Templating**: Blade - Laravel's powerful template engine
- **Styling**: Tailwind CSS 3.4 - Utility-first CSS framework
- **Visualization**: Larapex Charts - Interactive data visualization
- **JavaScript**: Alpine.js, Chart.js, GSAP - Modern JS libraries

### Key Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| `laravel/framework` | ^9.4.1 | Core framework |
| `livewire/livewire` | ^2.12 | Reactive components |
| `nwidart/laravel-modules` | ^9.0 | Modular application structure |
| `arielmejiadev/larapex-charts` | ^8.1 | Interactive charts |
| `maatwebsite/excel` | ^3.1 | Excel export functionality |
| `barryvdh/laravel-dompdf` | ^3.1 | PDF generation |
| `robthree/twofactorauth` | ^1.8 | Two-factor authentication |
| `google-gemini-php/laravel` | ^2.0 | AI integration |

### Development Tools
- **Pest**: Modern PHP testing framework
- **Pint**: Laravel code style fixer
- **Larastan**: Static analysis for Laravel
- **Sail**: Docker-based development environment

---

## Installation

### Prerequisites
- PHP 8.0 or higher
- Composer (latest version)
- MySQL 5.7 or higher
- Node.js 14+ and npm
- Git

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-org/pss1-main.git
cd pss1-main
```

### Step 2: Install Dependencies
```bash
# PHP dependencies
composer install

# Node.js dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Setup
```bash
# Run migrations
php artisan migrate

# Seed the database (optional - adds sample data)
php artisan db:seed
```

### Step 5: Build Frontend Assets
```bash
# Development build
npm run dev

# Production build
npm run build
```

### Step 6: Start Development Server
```bash
# Using PHP's built-in server
php artisan serve

# Or using Laravel Sail (Docker)
./vendor/bin/sail up
```

The application will be accessible at `http://localhost:8000`

### Step 7: Create Admin User (Optional)
```bash
php artisan tinker
# In the tinker shell:
# User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role_id' => 1]);
```

---

## Project Structure

### Directory Layout
```
pss1-main/
├── app/                          # Application code
│   ├── Http/
│   │   ├── Controllers/          # Route controllers
│   │   ├── Livewire/            # Livewire interactive components
│   │   └── Middleware/           # HTTP middleware
│   ├── Models/                   # Eloquent models
│   ├── Services/                 # Business logic services
│   ├── Exports/                  # Excel export classes
│   ├── Mail/                     # Email notification classes
│   └── Providers/                # Service providers
├── routes/                       # Application routes
│   ├── web.php                   # Web routes
│   └── api.php                   # API routes
├── resources/
│   ├── views/                    # Blade templates
│   ├── js/                       # JavaScript assets
│   └── sass/                     # SCSS stylesheets
├── database/
│   ├── migrations/               # Database migrations
│   ├── seeders/                  # Database seeders
│   └── SQL files/                # Database backups & scripts
├── config/                       # Application configuration
├── storage/                      # User files and logs
├── tests/                        # Test suite (Pest)
├── public/                       # Public assets
└── vendor/                       # Composer packages
```

### Key Directories Explained

**`app/Http/Controllers/`** - Contains all controller classes handling HTTP requests
- `CollectorController.php` - Manages pest data collection
- `UserController.php` - User management
- `ReportController.php` - Report generation
- `ChartController.php` - Chart data provision

**`app/Http/Livewire/`** - Real-time interactive components
- `Admin/*` - Admin dashboard and management components
- `Collector/*` - Data collector interface components
- `DeputyDirector/*` - Deputy director dashboard

**`app/Models/`** - Eloquent ORM models for database tables
- `User.php` - User model with roles
- `PestDataCollect.php` - Pest observation records
- `Collector.php` - Collector information
- `RiceSeason.php` - Season management

**`resources/views/`** - Blade template files
- Organized by feature/module
- Uses Livewire components for interactivity
- Responsive design using Tailwind CSS

---

## System Architecture

### Architecture Overview

```
┌─────────────────────────────────────────────────────┐
│                    Web Browser                       │
└──────────────────────┬──────────────────────────────┘
                       │ HTTP/HTTPS
┌──────────────────────▼──────────────────────────────┐
│            Laravel Application (PHP)                 │
│  ┌────────────────────────────────────────────────┐ │
│  │ Routes & Middleware                            │ │
│  └────────────────────┬───────────────────────────┘ │
│                       │                              │
│  ┌────────────────────▼───────────────────────────┐ │
│  │ Controllers & Livewire Components              │ │
│  │ - Request Handling                             │ │
│  │ - Business Logic Orchestration                 │ │
│  │ - View Rendering                               │ │
│  └────────────────────┬───────────────────────────┘ │
│                       │                              │
│  ┌────────────────────▼───────────────────────────┐ │
│  │ Service Layer                                   │ │
│  │ - PestInfoService                              │ │
│  │ - textCorrectionService                        │ │
│  │ - toPDFService                                 │ │
│  └────────────────────┬───────────────────────────┘ │
│                       │                              │
│  ┌────────────────────▼───────────────────────────┐ │
│  │ Eloquent ORM Layer                             │ │
│  │ - Model Relationships                          │ │
│  │ - Validation & Casting                         │ │
│  └────────────────────┬───────────────────────────┘ │
└──────────────────────┬──────────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────────┐
│            MySQL Database                            │
│  - User Accounts & Permissions                      │
│  - Pest Data Records                                │
│  - Audit Trails                                     │
│  - System Settings                                  │
└──────────────────────────────────────────────────────┘
```

### Design Patterns Used

1. **Model-View-Controller (MVC)** - Separation of concerns
2. **Service-Oriented Architecture (SOA)** - Encapsulated business logic
3. **Repository Pattern** - Data access abstraction
4. **Dependency Injection** - Loose coupling via IoC container
5. **Observer Pattern** - Event-driven notifications
6. **Strategy Pattern** - Multiple export/report strategies

---

## Database Schema Overview

### Core Tables

```sql
-- Users and Roles
users (id, name, email, password, role_id, 2fa_enabled, created_at)
roles (id, name, description)
permissions (id, name, action)
role_has_permissions

-- Pest Data
pest_data_collects (id, collector_id, pest_name, severity, location_id, season_id, notes, created_at)
pests (id, name, description, type)
rice_seasons (id, year, start_date, end_date)

-- Locations & Geography
regions (id, name)
districts (id, name, region_id)
provinces (id, name)
ai_ranges (id, name, district_id)

-- System Data
collectors (id, user_id, ai_center_id, name, contact)
audit_trails (id, user_id, action, model_type, model_id, changes, ip_address, created_at)
sent_emails (id, recipient, subject, body, sent_at)
settings (id, key, value)

-- Additional Features
notifications (id, user_id, title, message, read_at)
common_data_collects (id, type, data)
conducted_programs (id, title, description, conducted_at)
```

### Key Relationships
- Users → Roles (Many-to-One)
- PestDataCollect → Collector (Many-to-One)
- PestDataCollect → RiceSeason (Many-to-One)
- Collector → AiCenter (Many-to-One)
- AiCenter → District (Many-to-One)
- District → Region (Many-to-One)

---

## Usage Guide

### For Data Collectors
1. Login with your credentials
2. Navigate to "New Entry" or "Data Collection"
3. Fill in pest details:
   - Pest type (Thrips, Gall Midge, etc.)
   - Location (Region → District → AI Center)
   - Severity level
   - Additional observations
4. Submit the form - data is validated and stored
5. View your submissions in "My Submissions"
6. Export your data as needed

### For Administrators
1. Access the Admin Dashboard
2. **User Management** - Create users, assign roles, enable 2FA
3. **Settings** - Configure system parameters and email templates
4. **Audit Trails** - Monitor all user activities
5. **Role Management** - Define permissions and roles
6. **Email Management** - Review sent notifications

### For Directors
1. Access Analytics Dashboard
2. View comprehensive pest surveillance reports
3. Generate custom reports by:
   - Date range
   - Region/District
   - Pest type
   - Severity level
4. Export reports (PDF/Excel) for presentations
5. Analyze trends and plan interventions

### For Deputy Directors
1. Regional oversight dashboard
2. Monitor data collection progress in assigned region
3. Approve or request data revisions
4. Generate regional reports
5. Communicate with field collectors

---

## API Routes

### Authentication Routes
```
POST   /login                    - User login
POST   /logout                   - User logout
GET    /register                 - Show registration form
POST   /register                 - Register new user
POST   /forgot-password          - Request password reset
POST   /reset-password           - Reset password
GET    /2fa-setup                - Setup two-factor authentication
```

### Pest Data Management Routes
```
GET    /pest-data                - List all pest data (paginated)
GET    /pest-data/create         - Show creation form
POST   /pest-data                - Store new pest data
GET    /pest-data/{id}           - View pest data details
GET    /pest-data/{id}/edit      - Show edit form
PUT    /pest-data/{id}           - Update pest data
DELETE /pest-data/{id}           - Delete pest data
```

### Reporting Routes
```
GET    /reports                  - Reports dashboard
GET    /reports/pest-summary     - Pest summary report
GET    /reports/export-pdf       - Export report as PDF
GET    /reports/export-excel     - Export report as Excel
```

### Admin Routes (Protected)
```
GET    /admin/dashboard          - Admin dashboard
GET    /admin/users              - User management
POST   /admin/users              - Create new user
GET    /admin/audit-trails       - View audit logs
GET    /admin/settings           - System settings
POST   /admin/settings           - Update settings
```

---

## Features in Detail

### 1. Role-Based Dashboard
Each user role has a customized dashboard displaying relevant information:
- **Admin**: User statistics, system health, pending approvals
- **Collectors**: Their data submissions, quick entry form
- **Directors**: High-level analytics, regional comparisons
- **Deputy Directors**: Regional performance metrics

### 2. Data Collection Form
- Multi-step form for comprehensive pest data
- Real-time validation feedback
- Support for multiple pest types
- Location hierarchy (Region → District → AI Center)
- Photo/evidence upload capability
- Notes and observations field

### 3. Reporting Engine
- **PDF Reports**: Professional, printable reports with charts
- **Excel Exports**: Data suitable for further analysis
- **Custom Filters**: Date range, region, pest type, severity
- **Scheduled Reports**: Automated report generation
- **Email Distribution**: Send reports to stakeholders

### 4. Data Visualization
- Line charts for trend analysis
- Bar charts for pest comparisons
- Pie charts for distribution analysis
- Interactive tooltips and legends
- Drill-down capabilities for detailed analysis

### 5. Audit & Compliance
- Complete audit trail of all user activities
- Track: Who, What, When, Where (IP address)
- Export audit logs for compliance reporting
- Data change history

### 6. Email Notifications
- User registration confirmations
- Data submission confirmations
- System alerts and warnings
- Scheduled digest emails
- Customizable email templates

### 7. Security Features
- Password hashing using bcrypt
- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- XSS prevention via Blade escaping
- Session management and timeout
- Rate limiting on API endpoints

---

## Development Guide

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/PestDataTest.php

# Run with coverage
php artisan test --coverage

# Run Pest tests
vendor/bin/pest
```

### Code Quality Tools
```bash
# Run static analysis
vendor/bin/larastan analyse

# Format code
vendor/bin/pint

# Check for unused imports
composer unused
```

### Database Migrations
```bash
# Create new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Refresh database
php artisan migrate:refresh
```

### Seeding Data
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=PestSeeder
```

---

## Known Issues

⚠️ **The following issues have been identified and should be addressed**:

### High Severity Issues
1. **Assignment vs Comparison in CollectorController:321**
   - File: `app/Http/Controllers/CollectorController.php`
   - Issue: `if ($seasonId = null)` should be `if ($seasonId == null)`
   - Impact: Condition always evaluates to false

2. **Missing Return Statements in getCollectorCount**
   - File: `app/Http/Controllers/CollectorController.php:324-330`
   - Issue: Several branches compute values but don't return them
   - Impact: Function may return null unexpectedly

3. **Production Debug Code (dd())**
   - Files: `CollectorController.php:333`, `Users.php:98`
   - Issue: Debug functions left in production code
   - Impact: Crashes requests and exposes debug information

### Medium Severity Issues
4. **Invalid Blade Switch/Case Logic**
   - File: `resources/views/pestData/create.blade.php:124-140`
   - Issue: Using boolean expressions in @case statements
   - Impact: Incorrect form rendering

5. **Mismatched Blade Component Tags**
   - Files: `pestData/create.blade.php:166`, `pestData/edit.blade.php:91`
   - Issue: Opens textarea, closes input
   - Impact: Potential rendering issues

6. **Incorrect Blade Conditional in Edit Form**
   - File: `resources/views/pestData/edit.blade.php:77`
   - Issue: Non-thrips branch still filters only Thrips data
   - Impact: Wrong data displayed for other pest types

### Recommended Fixes
1. Run `php -l` on all PHP files to validate syntax
2. Execute test suite: `vendor/bin/pest` or `php artisan test`
3. Review BUG_REPORT.md for detailed severity information
4. Add regression tests after fixes

---

## Deployment

### Production Deployment Checklist
- [ ] Environment variables configured (.env)
- [ ] Database migrated and seeded
- [ ] Assets compiled (`npm run build`)
- [ ] Cache cleared and optimized
- [ ] SSL certificate configured
- [ ] Email service configured
- [ ] Backup strategy implemented
- [ ] Monitoring and logging configured
- [ ] Admin account created with strong password
- [ ] 2FA enabled for admin accounts

### Docker Deployment
```bash
# Build Docker image
docker build -t pss-app .

# Run container
docker run -p 8000:80 pss-app

# Using Docker Compose
docker-compose up -d
```

### Performance Optimization
```bash
# Clear and optimize caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Queue workers (for email, background jobs)
php artisan queue:work
```

---

## Contributing

We welcome contributions to the Pest Surveillance System! Please follow these guidelines:

### Code Style
- Follow PSR-12 coding standards
- Use Laravel conventions
- Run `vendor/bin/pint` before committing
- Add type hints to new code

### Creating Features
1. Create a feature branch: `git checkout -b feature/your-feature`
2. Write tests for new functionality
3. Ensure all tests pass: `vendor/bin/pest`
4. Submit a pull request with description

### Reporting Bugs
- Check [Known Issues](#known-issues) first
- Provide detailed reproduction steps
- Include PHP version, OS, and browser info
- Attach relevant error logs

---

## Support & Documentation

### Getting Help
- 📖 [Laravel Documentation](https://laravel.com/docs)
- 🔗 [Livewire Documentation](https://livewire.laravel.com)
- 💬 [Laravel Community Forums](https://laracasts.com/discuss)
- 🐛 [Report Issues](./BUG_REPORT.md)

### Project Contact
**Developer**: G. B. Darsha Anuradha

- 📧 Email: [darsha.anuradha2020@gmail.com](mailto:darsha.anuradha2020@gmail.com)
- 💼 LinkedIn: [Darsha Anuradha](https://www.linkedin.com/in/darsha-anuradha)
- 🌐 Portfolio: [Portfolio Site](https://anuradha-s-portfolio.onrender.com)
- 📍 Location: No. 42/23, Railway Station Road, Katugastota
- 📱 Contact: +94 71 893 1240

### Documentation Files
- [Project Technical Report](./project_technical_report.txt) - Detailed technical documentation
- [Project Description](./project_description.txt) - Business overview
- [Bug Report](./BUG_REPORT.md) - Known issues and fixes
- [CHANGELOG](./CHANGELOG.md) - Version history (if exists)

---

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Acknowledgments

- Built with [Laravel Framework](https://laravel.com)
- UI powered by [Livewire](https://livewire.laravel.com) & [Tailwind CSS](https://tailwindcss.com)
- Charts by [Larapex Charts](https://larapex.com)
- Developed for the Department of Agriculture - National Plant Protection Service

---

<div align="center">

**Made with ❤️ for Agricultural Pest Surveillance**

Last Updated: May 2026 | Status: Production Active

</div>
