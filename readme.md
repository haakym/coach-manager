# Coach Manager

## Installation

1. Clone repo `git clone https://github.com/haakym/coach-manager.git`
2. Install composer dependencies `composer install`
3. Set up `.env` file `cp .env.example .env`
4. Generate app key `php artisan key:generate`

### Database

The web app uses MySQL or MariaDB database so one of these databases should be created to run the app. The respective database config should be updated in the `.env` file.

1. Run migrations `php artisan migrate`
2. Seed data can be optionally used which will create a few courses, coaches and volunteers `php artisan db:seed`

## Technologies Used

Git used for version control and GitFlow for branch management.

### Back-end

- PHP 7.1.7
- Apache 2.4
- Laravel 5.6
- Laravel Datatables for Course and Instructors (Coach/Volunteer) index view https://github.com/yajra/laravel-datatables
- Laravel debugbar for deubgging purposes https://github.com/barryvdh/laravel-debugbar
- Database
  - MySQL 5.7, for local testing
  - SQLite (in memory) for phpunit test suite

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

Overview of the implementation and features with comments on assumptions made in light of the requirements brief.

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

Tests:

- https://github.com/haakym/coach-manager/blob/master/tests/Feature/ViewCourseTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Feature/AddCourseTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Feature/AddCourseValidationTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Unit/Models/CourseTest.php

##### URLs

View: http://coach-manager.test/courses/1

When viewing a course all details of the course and related information is available including the number of instructors assigned to the course and the dates for which they are assigned. This page also provides the form to assign new instructors to the course provided the course is of status "pending".

Add:  http://coach-manager.test/courses/create

Beyond the basics, the add course form implements the following validation rules:

- course date_from must start after today
- coaches_required and volunteers_required can't both be 0

Edit:  http://coach-manager.test/courses/1/edit

When editing a course, if the attributes date_from, date_to, coaches_required or volunteers_required are modified the instructors assigned to the courses will be removed and the course status set to pending. This will only apply to courses which have not yet commenced.

A course cannot be edited if the start date has already passed.

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

Tests:

- https://github.com/haakym/coach-manager/blob/master/tests/Feature/ViewInstructorTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Feature/AddInstructorTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Unit/Models/InstructorTest.php

##### URLs

View: http://coach-manager.test/instructors/1

Add:  http://coach-manager.test/instructors/create

Edit:  http://coach-manager.test/instructors/1/edit

When editing an instructor if the instructor type is modified the instructor will be removed from any courses that they are assigned to that have not yet commenced and the course status will be set to pending.

Resource index: http://coach-manager.test/resources/instructors

#### Certificate

Attributes:

- name
- description
- type
  - of two types:
    1. qualification, e.g. "Certificate of Coaching"
    2. background-check, e.g. DBS
- expiry_date
  - optional field
- file
- instructor_id
  - the instructor the certificate belongs to

##### Code

Migration: https://github.com/haakym/coach-manager/blob/master/database/migrations/2018_08_05_113733_create_certificates_table.php

Model: https://github.com/haakym/coach-manager/blob/master/app/Models/Certificate.php

Controllers:

- https://github.com/haakym/coach-manager/blob/master/app/Http/Controllers/InstructorCertificateController.php
- https://github.com/haakym/coach-manager/blob/master/app/Http/Controllers/CertificateDownloadController.php

Tests:

- https://github.com/haakym/coach-manager/blob/master/tests/Feature/UploadCertificateTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Feature/DownloadCertificateTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Unit/Models/CertificateTest.php

##### URLs

View/Add: http://coach-manager.test/instructors/1

Certificates uploaded for instructors can be viewed and added when viewing an instructor. If an instructors certificate has expired (i.e. the expiry date is less than today's date) the date will be highlighted in red to indicate expiration to the user.

When uploading a certificate, upon selecting an expiry date I decided that the expiry date must be at a minimum of one months time from today's date as it seemed less useful that a user could upload a certificate that would soon expire.

#### CourseInstructor

This entity represents the relationship between courses and instructors, i.e. instructors assigned to courses and the dates they are assigned to the course for. As this is a many-to-many relationship I used the Laravel convention of naming the entity, i.e. joining both table names in alphabetical order.

Attributes:

- date_from
- date_to
  - dates the instructor is assigned to the course, this can, of course, be the same as the course dates if the instructor is covering the full course dates or within the range of the course dates if they are sharing with another instructor
- instructor_id
- course_id

##### Code

Migration: https://github.com/haakym/coach-manager/blob/master/database/migrations/2018_08_09_094406_create_course_instructor_table.php

Model: https://github.com/haakym/coach-manager/blob/master/app/Models/CourseInstructor.php

Controllers: https://github.com/haakym/coach-manager/blob/master/app/Http/Controllers/CourseInstructorController.php

Tests:

- https://github.com/haakym/coach-manager/blob/master/tests/Feature/AssignInstructorToCourseTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Feature/AssignInstructorToCourseValidationTest.php
- https://github.com/haakym/coach-manager/blob/master/tests/Feature/ReviewCourseStatusTest.php

Rules: https://github.com/haakym/coach-manager/blob/master/app/Rules/CourseInstructorAssignmentIsValid.php

When assigning an instructor to a course this rule checks for the following when assigning an instructor to a course:

- The course status is not assigned
- The instructor is not already assigned to another course on the dates of the assignment proposal
- The instructor requirement is not already met on the course overall or within the dates proposed

##### URLs

View/Assign: http://coach-manager.test/courses/1

When viewing a course, the existing instructors assigned the course and their dates can be viewed as well as the form to assign a new instructor.

Upon successfully assigning an instructor to a course I triggered an event and responding listener that would cause the Course entity to *review its status* - meaning that a check would be made for each day of the course and if the Course's coaches_requirement and volunteers_requirement were met the status would be set to "assigned". The code related to this can be found on the `reviewStatus()` on the Course model here:

https://github.com/haakym/coach-manager/blob/master/app/Models/Course.php#L51

#### Calendar

The calendar was implemented on the front-end using fullcalendar.io through which the data source was simply a database query returning JSON data. Course's are highlighted in different colours to indicate their status, green for assigned and grey for pending. Courses can be clicked on to view further course details.

##### Code

Controller: https://github.com/haakym/coach-manager/blob/master/app/Http/Controllers/CalendarController.php

Tests: https://github.com/haakym/coach-manager/blob/master/tests/Feature/CalendarDataSourceTest.php

This test is currently failing as the query is using a raw query to concat an attribute into an anchor tag. I have written the query to work with MySQL using the concat function whereas the testing suite is using SQLite which concats via "||".

### Testing

Each test describes a specific feature or actions around that feature. The test suite mostly consists of feature based HTTP tests with some unit tests. Tests typically focus on the "happy path", then edge cases and their related validation.

To run tests execute:

```bash
./vendor/bin/phpunit
```
