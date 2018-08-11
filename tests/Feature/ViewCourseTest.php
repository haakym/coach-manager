<?php

namespace Tests\Feature;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewCourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_a_course()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDay();

        $course = factory(Course::class)->create([
            'name' => 'Beginner skills summer camp',
            'description' => 'Football training for beginners ages 11-13',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
        ]);

        $response = $this->get("/courses/{$course->id}");

        $response->assertStatus(200);
        $response->assertSee('Beginner skills summer camp');
        $response->assertSee('Football training for beginners ages 11-13');
        $response->assertSee('SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP');
        $response->assertSee($dateFrom->format('d-m-Y') . ' to ' .$dateTo->format('d-m-Y'));
    }
}
