# Workfolk

Workfolk is a small educational job portal built with Laravel. It is inspired
by job boards such as Indeed, but deliberately keeps the feature set small so
the code is easy to understand and use as a reference project.

The project demonstrates a complete, simple workflow:

```text
Employer creates a company
        ↓
Employer publishes a job
        ↓
Jobseeker searches for the job
        ↓
Jobseeker submits an application
        ↓
Employer reviews the application and updates its status
```

## Project goals

This project is intended for learning Laravel application structure, especially
if you are coming from Django or another framework with a more centralized
architecture.

The code favors:

- Conventional Laravel structure
- Small controllers
- Eloquent relationships
- Form request validation
- Database constraints
- Blade templates
- Tailwind CSS
- Feature tests
- Readable implementation over premature abstraction

## Features

### Public job search

- Browse published jobs
- Search by job title or description
- Filter by location
- Filter by category
- Paginate results
- View a detailed job posting

### Jobseeker accounts

- Register as a jobseeker
- Log in and log out
- Apply to published jobs
- Add a cover letter
- Optionally upload a PDF, DOC, or DOCX resume
- Prevent duplicate applications to the same job

### Employer accounts

- Register as an employer
- Create one company profile
- Publish job postings
- View the number of applications for each job
- Review submitted applications
- Update an application status

### Application statuses

Applications currently support these statuses:

```text
submitted
reviewing
interview
accepted
rejected
```

## Deliberate scope decisions

This is an MVP and intentionally does not include:

- Multiple users managing one company
- Employee or employment-history records
- In-app chat
- Recommendations
- Resume parsing
- Saved searches
- Advanced recruitment pipelines
- Payments
- Social login

Communication is currently represented by application status changes. Email
notifications can be added later without changing the core application model.

## Technology

- PHP 8.3
- Laravel 13
- SQLite for local development
- Blade
- Tailwind CSS 4
- Vite
- PHPUnit
- Laravel Pint

The interface uses:

- Primary color: `#8f0b01`
- Secondary color: `#f4b942`

## Application structure

Laravel separates the application into focused responsibilities:

```text
database/migrations/    Database structure
app/Models/             Data and relationships
app/Http/Requests/      Validation and request authorization
app/Http/Controllers/   HTTP coordination
routes/web.php          URL-to-controller mapping
resources/views/        Blade presentation
database/factories/     Reusable fake-data recipes
database/seeders/       Development data setup
tests/Feature/          End-to-end application behavior
```


## Database model

The application uses five models:

```text
User
 ├── has one Company when role = employer
 └── has many Applications when role = jobseeker

Company
 └── has many JobPostings

Category
 └── has many JobPostings

JobPosting
 ├── belongs to Company
 ├── optionally belongs to Category
 └── has many Applications

Application
 ├── belongs to User
 └── belongs to JobPosting
```

### Users

The `users` table stores both account types:

```text
role = jobseeker
role = employer
```

There are intentionally no separate `Employer` and `Jobseeker` models. Both
are users with different permissions and workflows.

### Companies

An employer can manage exactly one company. This is enforced by a unique
constraint on `companies.user_id`.

### Job postings

A job posting belongs to one company and can optionally belong to a category.
Only postings with `status = published` appear in the public job search.

### Applications

An application connects a jobseeker to a job posting. The database has a
composite unique constraint on:

```text
user_id + job_posting_id
```

This prevents a jobseeker from applying to the same job more than once.

## Local installation

### Requirements

Install the following before starting:

- PHP 8.3 or newer
- Composer
- Node.js 20 or newer
- npm
- SQLite

Node.js 20 or newer is recommended because the current Vite toolchain uses
modern Node APIs.

### Clone the project

```bash
git clone https://github.com/Muhammad-989/jobappLaravel.git
cd jobappLaravel
```

### Install PHP dependencies

```bash
composer install
```

### Configure the environment

Copy the example environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, use:

```powershell
Copy-Item .env.example .env
```

Generate the application encryption key:

```bash
php artisan key:generate
```

### Configure SQLite

Create the SQLite database file if it does not already exist:

```bash
touch database/database.sqlite
```

On Windows PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File
```

Make sure `.env` contains:

```dotenv
DB_CONNECTION=sqlite
```

### Run migrations and seed demo data

```bash
php artisan migrate --seed
```

This creates:

- Four job categories
- One sample employer
- One sample company
- Six sample job postings
- One test jobseeker

To completely rebuild the local database:

```bash
php artisan migrate:fresh --seed
```

> `migrate:fresh` deletes all tables and data. Use it only for local
> development and testing, never against a production database.

### Install frontend dependencies

```bash
npm install
```

Start the frontend asset watcher:

```bash
npm run dev
```

In another terminal, start Laravel:

```bash
php artisan serve
```

Visit:

```text
http://localhost:8000/jobs
```

For a production-style frontend build:

```bash
npm run build
```

## Demo account

The seeder creates this jobseeker account:

```text
Email:    test@example.com
Password: password
```

You can create an employer account through the registration page by selecting
**Employer** as the account type.

## Main routes

| Method | URL | Purpose |
| --- | --- | --- |
| `GET` | `/jobs` | Browse and search published jobs |
| `GET` | `/jobs/{job}` | View a job posting |
| `GET` | `/register` | Registration form |
| `POST` | `/register` | Create an account |
| `GET` | `/login` | Login form |
| `POST` | `/login` | Authenticate a user |
| `POST` | `/logout` | Log out |
| `GET` | `/jobs/{job}/apply` | Application form |
| `POST` | `/jobs/{job}/apply` | Submit an application |
| `GET` | `/employer/dashboard` | Employer dashboard |
| `POST` | `/employer/company` | Create a company |
| `GET` | `/employer/jobs/create` | New job form |
| `POST` | `/employer/jobs` | Publish a job |
| `GET` | `/employer/jobs/{job}/applications` | Review applications |
| `PATCH` | `/employer/applications/{application}` | Update application status |

To inspect the routes locally:

```bash
php artisan route:list
```

## Factories and seeders

Factories are reusable recipes for creating model records:

```php
User::factory()->create();
JobPosting::factory(10)->create();
```

Seeders assemble useful application data:

```php
$company = Company::factory()->create();

JobPosting::factory(6)->create([
    'company_id' => $company->id,
]);
```

The main seeder is:

```text
database/seeders/DatabaseSeeder.php
```

The model factories are:

```text
database/factories/UserFactory.php
database/factories/CompanyFactory.php
database/factories/CategoryFactory.php
database/factories/JobPostingFactory.php
database/factories/ApplicationFactory.php
```

## Testing

Run the test suite:

```bash
php artisan test --compact
```

The tests cover:

- The public jobs page responds successfully
- Job search filters results
- Jobseekers can submit applications
- Duplicate applications are rejected

PHP formatting is handled by Laravel Pint:

```bash
vendor/bin/pint --dirty --format agent
```

## Common development commands

```bash
# Show all Artisan commands
php artisan list

# Show migration status
php artisan migrate:status

# Run pending migrations
php artisan migrate

# Rebuild and seed the local database
php artisan migrate:fresh --seed

# Clear cached configuration
php artisan config:clear

# List registered routes
php artisan route:list

# Run tests
php artisan test --compact

# Format changed PHP files
vendor/bin/pint --dirty --format agent

# Start the Laravel development server
php artisan serve

# Start Vite
npm run dev
```

## Important Laravel concepts demonstrated

### Migrations define database structure

Migrations create tables, columns, foreign keys, indexes, and constraints. For
example, the company migration uses a unique foreign key so one employer
cannot create multiple companies.

### Models define relationships

The `JobPosting` model contains relationships such as:

```php
public function company(): BelongsTo
{
    return $this->belongsTo(Company::class);
}

public function applications(): HasMany
{
    return $this->hasMany(Application::class);
}
```

### Form requests validate input

Requests such as `StoreApplicationRequest` keep validation out of the
controller and also authorize the type of user who can submit the request.

### Controllers coordinate HTTP behavior

Controllers receive validated input, call models, and return redirects or
views. They should not contain the entire business domain.

### Routes map URLs to behavior

Routes connect browser URLs to controller methods and apply middleware such as
authentication and employer authorization.

### Blade renders the interface

The application uses a shared layout in
`resources/views/layouts/app.blade.php`. Individual pages extend that layout
and provide their own content.

## Security notes

- `.env` is ignored and should never be committed.
- Passwords are hashed before being stored.
- State-changing forms include CSRF protection.
- Request input is validated before persistence.
- Uploaded resumes are stored through Laravel's storage system.
- Employer routes require authentication and employer authorization.
- Application ownership is checked before employers can view or update it.

This project is educational and should receive a further security review
before being used with real personal data or deployed publicly.

## Future improvements

Possible next steps include:

1. Email notifications when an application is submitted or updated.
2. Employer notification emails for new applications.
3. Jobseeker application history.
4. Company profile editing.
5. Job editing and closing.
6. Password reset and email verification.
7. Policies for more granular authorization.
8. Dedicated PHP enums for roles and application statuses.
9. More complete application and authorization tests.
10. Deployment configuration for a hosted environment.

## License

This project is intended as an educational Laravel project. The original
Laravel framework is open source under the MIT license.
