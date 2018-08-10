<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewCourseStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function course_status_is_set_to_assigned_when_instructors_requirement_is_met()
    {
        $coach = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'coaches_required' => 1,
            'volunteers_required' => 0,
        ]);

        $response = $this->post('/courses/1/instructors', [
            'date_from' => $course->date_from->format('d-m-Y'),
            'date_to' => $course->date_to->format('d-m-Y'),
            'instructor_id' => $coach->id,
            'type' => 'coach',
        ]);

        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', ucfirst($coach->type) . ' assigned to course.');
        
        // event is fired
        $this->assertEquals('assigned', $course->fresh()->status);
    }
}
