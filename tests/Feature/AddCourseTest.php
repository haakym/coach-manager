<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_the_add_course_page()
    {
        $response = $this->get('courses/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_add_a_course()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $response = $this->post('courses', [
            'name' => 'Football skills under 11s',
            'description' => 'Football training for kids',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'coaches_required' => '1',
            'volunteers_required' => '1',
        ]);

        $course = Course::first();

        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', "New course {$course->name} added.");
        
        $this->assertEquals('Football skills under 11s', $course->name);
        $this->assertEquals('Football training for kids', $course->description);
        $this->assertEquals('SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP', $course->address);
        $this->assertEquals('pending', $course->status);
        $this->assertEquals('1', $course->coaches_required);
        $this->assertEquals('1', $course->volunteers_required);
    }
}
