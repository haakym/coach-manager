<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ReviewCourseStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function course_status_is_set_to_assigned_when_instructors_requirement_is_met()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(4);

        $coach = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'coaches_required' => 1,
            'volunteers_required' => 0,
            'status' => 'pending',
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
        ]);

        $response = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach->id,
            'type' => 'coach',
        ]);

        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', ucfirst($coach->type) . ' assigned to course.');
        
        $this->assertEquals('assigned', $course->fresh()->status);
    }

    /** @test */
    public function course_assigned_when_instructors_requirement_is_met_using_two_instructors()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(1);

        $coach1 = factory(Instructor::class)->states('coach')->create();
        $coach2 = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'coaches_required' => 1,
            'volunteers_required' => 0,
            'status' => 'pending',
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
        ]);

        \Log::info('response1');
        $response1 = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->copy()->addDays(1)->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach1->id,
            'type' => 'coach',
        ]);
        
        $this->assertEquals('pending', $course->fresh()->status);

        \Log::info('response2');
        $response2 = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->copy()->subDays(1)->format('d-m-Y'),
            'instructor_id' => $coach2->id,
            'type' => 'coach',
        ]);

        $this->assertEquals('assigned', $course->fresh()->status);
    }
}
