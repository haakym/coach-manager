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
- Date range picker for form date picker http://www.daterangepicker.com

## Solution

### Workflow

My initial approach to writing the solution for this project began by identifying a list of features from the requirements, beginning with the most crucial that had the least number of functional dependencies.

Using GitFlow I would create a new feature branch, i.e. "user can create a course", then use a TDD approach to:
  
  1. Write a failing feature test
  2. Get test passing
  3. Refactor code
  4. Drive out unit tests for domain objects OR jump back to step 1

Upon finishing a feature I would merge the feature branch back into the develop branch.

### Implementation and Features

#### Course

Attributes:

- name
- description
- address
- date_from
- date_to
- status
  - Set to "pending" by default, set to "assigned" when instructor requirements have been met
- coaches_required
- volunteers_required
  - As instructor requirements for courses were limited to two types (coaches and volunteers) I stored this information directly on the course entity, had there been more I would consider extracting the requirement into its own entity per type

##### Code

Migration: https://github.com/haakym/coach-manager/blob/master/database/migrations/2018_08_04_123957_create_courses_table.php

Model: https://github.com/haakym/coach-manager/blob/master/app/Models/Course.php

Controller: https://github.com/haakym/coach-manager/blob/master/app/Http/Controllers/CourseController.php

##### URLs

View: http://coach-manager.test/courses/1

Add:  http://coach-manager.test/courses/create

Edit:  http://coach-manager.test/courses/1/edit

Resource index: http://coach-manager.test/resources/courses

#### Instructor (Coach/Volunteer)

As the requirements dictated a Coach and Volunteer concept to be implemented with only one major difference, the hourly rate, and to a lesser degree the certificates required of them, I decided to join them into one with the concept of an "Instructor" whereby the type attribute would indicate if they were a coach or volunteer.

Attributes:

- name
- email
- type
  - coach or volunteer
- hourly_rate
  - stored as a whole number (integer) where 100 = £1.00
  - set to 0 for volunteers

##### Code

Migration: https://github.com/haakym/coach-manager/blob/master/database/migrations/2018_08_05_094225_create_instructors_table.php

Model: https://github.com/haakym/coach-manager/blob/master/app/Models/Instructor.php

Controller: https://github.com/haakym/coach-manager/blob/master/app/Http/Controllers/InstructorController.php

##### URLs

View: http://coach-manager.test/instructors/1

Add:  http://coach-manager.test/instructors/create

Edit:  http://coach-manager.test/instructors/1/edit

Resource index: http://coach-manager.test/resources/instructors


### Testing

Each test describes a specific feature or actions around that feature. The test suite mostly consists of feature based HTTP tests with some unit tests. Tests typically focus on the "happy path", some edge cases and the related validation.

To run tests execute:

```bash
./vendor/bin/phpunit
```
