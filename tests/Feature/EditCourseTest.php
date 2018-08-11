<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditCourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_the_edit_course_page()
    {
        $course = factory(Course::class)->create();

        $response = $this->get("courses/{$course->id}/edit");

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_edit_a_course()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $course = factory(Course::class)->create([
            'name' => 'Football skills under 11s',
            'description' => 'Football training for kids',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => '3',
            'volunteers_required' => '2',
        ]);

        $response = $this->post("courses/{$course->id}/edit", [
            'name' => 'Football skills under 13s',
            'description' => 'Football training for teens',
            'address' => 'Some Football Pitch, London, N4 XYZ',
        ]);
        
        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', "Course updated.");

        $course = Course::first();
        
        $this->assertEquals('Football skills under 11s', $course->name);
        $this->assertEquals('Football training for kids', $course->description);
        $this->assertEquals('SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP', $course->address);
        $this->assertEquals('pending', $course->status);
        $this->assertEquals('1', $course->coaches_required);
        $this->assertEquals('1', $course->volunteers_required);
    }
}
