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
        $course = factory(Course::class)->create([
            'name' => 'Football skills under 11s',
            'description' => 'Football training for kids',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
        ]);

        $response = $this->put("courses/{$course->id}", [
            'name' => 'Football skills under 13s',
            'description' => 'Football training for teens',
            'address' => 'Some Football Pitch, London, N4 XYZ',
        ]);
        
        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', "Course updated.");

        $course = Course::first();
        
        $this->assertEquals('Football skills under 13s', $course->name);
        $this->assertEquals('Football training for teens', $course->description);
        $this->assertEquals('Some Football Pitch, London, N4 XYZ', $course->address);
    }

    /** @test */
    public function user_cannot_edit_course_that_has_already_passed()
    {
        $dateFrom = Carbon::parse('-10 days');
        $dateTo = $dateFrom->copy()->subDays(5);

        $course = factory(Course::class)->create([
            'name' => 'Football skills under 11s',
            'description' => 'Football training for kids',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
        ]);

        $response = $this->put("courses/{$course->id}", [
            'name' => 'Football skills under 13s',
            'description' => 'Football training for teens',
            'address' => 'Some Football Pitch, London, N4 XYZ',
        ]);
        
        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', "You cannot edit a course that has already started or finished.");
    }
}
