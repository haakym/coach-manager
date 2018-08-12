# Coach Manager

## Installation

Clone repo

```bash
git clone https://github.com/haakym/coach-manager.git
```

Install composer dependencies

```bash
composer install
```

Set up `.env` file

```bash
cp .env.example .env
```

Generate app key

```bash
php artisan key:generate
```

### Database

The web app uses MySQL or MariaDB database so one of these databases should be created to run the app. The respective database config should be updated in the `.env` file.

Run migrations

```bash
php artisan migrate
```

Seed data can be optionally used which will create a few courses, coaches and volunteers

```bash
php artisan db:seed
```

## Technologies Used

Git used for version control and GitFlow for branch management

### Back-end

- PHP 7.1.7
- Laravel 5.6
- Laravel Datatables for Course and Instructors (Coach/Volunteer) index view https://github.com/yajra/laravel-datatables
- Laravel debugbar for deubgging purposes https://github.com/barryvdh/laravel-debugbar
- Database
  - MySQL for live app
  - SQLite for testing

### Front-end

- Bootstrap 4
- JQuery
- VueJS
- Fullcalendar.io for calendar functionality https://fullcalendar.io
- Date range picker for form date picker http://www.daterangepicker.com/

## Solution

### Workflow

My initial approach to writing the solution for this project began by identifying a list of features from the requirements, beginning with the most crucial that had the least number of functional dependencies.

Using GitFlow I would create a new feature branch, i.e. "user can create a course", then use a TDD approach to:
  
  1. Write a failing feature test
  2. Get test passing
  3. Refactor code
  4. Drive out unit tests for domain objects OR jump back to step 1

Upon finishing a feature I would merge the feature branch back into the develop branch.

### Features

User can view a course (assumes course(s) exists):
  - http://coach-manager.test/courses - shows all courses
  - http://coach-manager.test/courses/{id} - shows a single course

### Testing

Each test describes a specific feature or actions around that feature. The test suite mostly consists of feature based HTTP tests with some unit tests.

To run tests execute:

```bash
./vendor/bin/phpunit
```
