<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class AssignInstructorToCourseValidationTest extends TestCase
{
    use RefreshDatabase, InteractsWithExceptionHandling;

    /** @test */
    public function validation_fails_when_course_status_is_assigned()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $course = factory(Course::class)->create([
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 0,
            'status' => 'assigned'
        ]);
        
        $coach = factory(Instructor::class)->states('coach')->create();

        $response = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach->id,
            'type' => 'coach',
        ]);

        $response->assertSessionHasErrors(['instructor_id' => 'The course is already fully assigned.']);
    }

    /** @test */
    public function validation_fails_when_coach_requirement_is_already_met()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $coach1 = factory(Instructor::class)->states('coach')->create();
        $coach2 = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 0,
            // 'status' => 'assigned'
        ]);

        // coach1 assigned to course
        $course->instructors()->attach($coach1->id, [
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
        ]);

        // attempt to assign coach2 to course
        $response = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach2->id,
            'type' => 'coach',
        ]);

        $response->assertSessionHasErrors(['instructor_id' => 'There are already enough coaches assigned for these dates.']);
    }

    /** @test */
    public function validation_fails_when_coach_double_books()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $coach = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 2,
            'volunteers_required' => 0,
        ]);

        $course->instructors()->attach($coach->id, [
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
        ]);

        $response = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach->id,
            'type' => 'coach',
        ]);

        $response->assertSessionHasErrors(['instructor_id' => 'Coach already assigned within this date range.']);
    }

    /** @test */
    public function validation_fails_when_coach_is_assigned_to_a_fully_booked_day()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $coach1 = factory(Instructor::class)->states('coach')->create();
        $coach2 = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 0,
        ]);

        // coach1 assigned to first day
        $course->instructors()->attach($coach1->id, [
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateFrom->format('Y-m-d'),
        ]);

        // attempt to assign coach2 to first day
        $response = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateFrom->format('d-m-Y'),
            'instructor_id' => $coach2->id,
            'type' => 'coach',
        ]);

        $response->assertSessionHasErrors(['instructor_id' => 'There are already enough coaches assigned for these dates.']);
    }
}
