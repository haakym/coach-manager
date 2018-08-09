<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Course;
use App\Models\Instructor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class AssignInstructorToCourseTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function user_can_assign_a_coach_to_a_course()
    {
        $this->withoutExceptionHandling();
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $coach = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 0,
        ]);

        $response = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach->id,
            'type' => 'coach',
        ]);

        $instructor = Instructor::first();

        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', ucfirst($instructor->type) . ' assigned to course.');

        // Todo: complete assertions
        
        // assert $course->instructors
        // assert $course->coaches
        // assert $course->volunteers
    }
}
