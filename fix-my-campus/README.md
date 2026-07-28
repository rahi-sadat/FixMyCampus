# FixMyCampus

FixMyCampus is a Laravel-based campus complaint and maintenance management system. Students can submit issues with locations, categories, priorities, and images; campus authority users can review, assign, and monitor complaints; maintenance staff can follow assigned work and add progress updates.

## Features

- Student registration, login, dashboard, complaint submission, image attachments, and complaint tracking.
- Admin dashboard for complaint review, filtering, staff assignment, student/staff account visibility, and reporting data.
- Role-based access for admin, student, and maintenance staff users.
- Complaint lifecycle tracking with priorities, statuses, assignment history, status logs, progress notes, feedback, and notifications data models.
- Seeded demo data for local development.

## Tech Stack

- PHP 8.2+
- Laravel 12
- SQLite by default, configurable through Laravel environment variables
- Vite 7
- Tailwind CSS 4
- PHPUnit 11

## Project Structure

```text
.
+-- app/
+-- database/
+-- public/
+-- resources/
+-- routes/
+-- tests/
+-- composer.json
+-- package.json
`-- README.md
```

## Getting Started

Run these commands from this `fix-my-campus/` directory.

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Install frontend dependencies:

   ```bash
   npm install
   ```

3. Create the local environment file and application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Create the SQLite database file if you are using the default `.env.example` settings:

   ```powershell
   New-Item -ItemType File -Path database/database.sqlite -Force
   ```

5. Run migrations and seed demo data:

   ```bash
   php artisan migrate --seed
   ```

6. Start the development servers:

   ```bash
   composer run dev
   ```

The app will be available from the Laravel development server, usually at `http://127.0.0.1:8000`.

## Demo Accounts

After running the database seeder, these accounts are available:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@gmail.com` | `password` |
| Student | `student@fixmycampus.test` | `password` |
| Staff | `staff@fixmycampus.test` | `password` |

## Common Routes

| Area | Path |
| --- | --- |
| Landing page | `/` |
| Login | `/login` |
| Register | `/register` |
| Student dashboard | `/student/dashboard` |
| Submit complaint | `/complaints/create` |
| Track complaints | `/complaints` |
| Admin dashboard | `/admin/dashboard` |
| Admin complaint review | `/admin/complaints` |
| Admin assignments | `/admin/assignments` |

## Testing

Run the test suite from this directory:

```bash
php artisan test
```

You can also run the Composer test script:

```bash
composer test
```

## Development Notes

- Uploaded complaint images are stored on the public filesystem disk under `complaint-images/`.
- The default environment uses SQLite, database-backed sessions, database cache, and database queues.
- Feature routes are split under `routes/features/` and loaded from `routes/web.php`.
- Seed data creates roles, demo users, complaint categories, locations, and sample complaints.
