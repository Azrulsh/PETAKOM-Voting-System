# PETAKOM Voting System (PVS)

PETAKOM Voting System (PVS) is a Laravel-based web application for managing PETAKOM candidate evaluations and election results. Instead of a conventional single-choice ballot, the system uses a **multi-criteria decision-making (MCDM)** approach: voters evaluate candidates against defined criteria, and the application processes those ratings to produce results.

## Features

### Administrator
- Manage candidates (create, view, update and delete).
- Manage evaluation criteria (create, view, update and delete).
- View evaluation results and candidate rankings.
- Access reports and report generation.

### Voter
- Sign in to the voter dashboard.
- Browse available positions and their candidates.
- Rate candidates according to the evaluation criteria.
- View results where permitted by the application.

### Account management
- User registration and sign-in.
- Profile and password management.
- Password reset and supported two-factor authentication settings.
- Role-specific Admin and Voter routes.

## Voting methodology

PVS uses **criteria-based candidate evaluation**, not traditional single-choice voting. Ratings are collected for the configured criteria and used by the application's existing MCDM calculation logic to generate results and rankings.

The original MCDM methodology is a core requirement of PVS and must be preserved during maintenance or framework upgrades. Refer to the application's rating and result implementation for the precise scoring rules and calculations.

## Technology stack

| Component | Technology |
| --- | --- |
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Tailwind CSS, Blade and JavaScript |
| Database | MySQL |
| Authentication | Laravel Fortify / Jetstream |
| Additional packages | Livewire 3, Filament 3, Laravel Sanctum |
| Tests | PHPUnit / Laravel testing tools |
| Package managers | Composer, npm |

The versions installed at the completion of the Laravel 12 upgrade included Laravel **12.71.0**, Filament **3.3.57** and Livewire **3.8.11**. Refer to `composer.lock` for the authoritative installed PHP package versions.

## Requirements

- PHP 8.2 or higher, with the PHP extensions required by Composer dependencies
- Composer
- MySQL
- Node.js and npm

## Local installation

1. Clone the repository and enter its directory:

   ```bash
   git clone <repository-url>
   cd PETAKOM-Voting-System
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create the local environment file from the template:

   **Windows PowerShell**
   ```powershell
   Copy-Item .env.example .env
   ```

   **macOS / Linux**
   ```bash
   cp .env.example .env
   ```

4. Generate an application key:

   ```bash
   php artisan key:generate
   ```

5. Create a MySQL database (for example, `pvs`) and update the relevant entries in `.env`:

   ```dotenv
   APP_ENV=local
   APP_DEBUG=true
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pvs
   DB_USERNAME=your_local_db_user
   DB_PASSWORD=your_local_db_password
   ```

6. Apply the database migrations:

   ```bash
   php artisan migrate
   ```

   Database seeders, if available and required, should be run separately according to the project's data requirements.

7. Install and compile frontend assets:

   ```bash
   npm install
   npm run dev
   ```

   Keep the Vite development process running while developing. Use `npm run build` when compiling production assets.

8. Start Laravel in a separate terminal:

   ```bash
   php artisan serve
   ```

   Open `http://127.0.0.1:8000` in a browser.

> **Note:** Do not commit `.env`, `.env.testing`, passwords, API keys or other secret credentials. Local accounts and evaluation data may need to be created before testing application workflows.

## Automated testing — use a separate database

**Important:** The project's tests use Laravel's `RefreshDatabase` trait. Running tests against the development database can remove existing data. **Never run `php artisan test` against the development database (`pvs`).**

1. Create a **separate, empty MySQL database**, for example `pvs_testing`.
2. Create `.env.testing` locally (based on `.env`) and set its database values:

   ```dotenv
   APP_ENV=testing
   DB_CONNECTION=mysql
   DB_DATABASE=pvs_testing
   ```

   Include the required local database credentials and app configuration; keep this file out of Git.
3. Ensure `phpunit.xml` does not override the testing connection back to `pvs`. If it contains explicit `DB_CONNECTION` / `DB_DATABASE` settings, they must point to the dedicated testing database.
4. **Verify the testing database name before running tests**:

   ```bash
   php artisan config:show database.connections.mysql.database --env=testing
   ```

   The output must show `pvs_testing`, **not `pvs`**.
5. Only after confirming isolation, run:

   ```bash
   php artisan test
   ```

During the Laravel 12 upgrade validation, the existing suite completed with **25 passed, 7 skipped and 0 failed tests (48 assertions)**. Some tests were skipped because the associated optional features were not enabled. These results describe the recorded upgrade check; they are not a guarantee of future test results.

## Manual regression checklist

After changing dependencies, authentication, voting logic or the framework, verify:

- [ ] Administrator and voter login/logout
- [ ] Registration, profile updates and password management
- [ ] Candidate CRUD and criteria CRUD
- [ ] Access controls between Administrator and Voter roles
- [ ] Position and candidate selection for rating
- [ ] Submission and persistence of criteria-based candidate ratings
- [ ] MCDM result calculation and candidate rankings against known expected results
- [ ] Result and report pages
- [ ] Tailwind UI, JavaScript behavior and browser console
- [ ] Laravel application logs for new errors

The existing evaluation and scoring methodology should not be replaced by conventional single-choice voting during regression fixes or enhancements.

## Laravel upgrade history

The project was upgraded incrementally:

```text
Laravel 10 → Laravel 11 → Laravel 12
```

At the Laravel 12 validation checkpoint:
- Laravel CLI and Composer platform checks completed successfully.
- The existing routes and database migrations were listed successfully.
- `composer audit` reported no known security vulnerability advisories at the time of the check.
- The automated suite passed, and the application's major workflows were manually checked.

Continue checking dependencies and security advisories before deployments; audit results can change as new issues are disclosed.

## Useful commands

```bash
php artisan --version
php artisan route:list
php artisan migrate:status
php artisan optimize:clear
composer validate
composer check-platform-reqs
composer audit
```

## Development notes

- Keep PVS separate from **PETAKOM Management System (PMS)**.
- Preserve the criteria-based MCDM voting methodology and existing functional behavior.
- Validate any new framework or dependency upgrade with both automated and manual regression tests.
- Do not modify production or development databases using destructive test commands.

## License

No license is specified in this README. Refer to the repository's license file, if one exists, for usage and distribution terms.
