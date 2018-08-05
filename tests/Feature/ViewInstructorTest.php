<?php

namespace Tests\Feature;

use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewInstructorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_a_volunteer_instructor()
    {
        $instructor = factory(Instructor::class)->states('volunteer')->create();

        $response = $this->get("/instructors/{$instructor->id}");

        $response->assertStatus(200);
        $response->assertSee($instructor->name);
        $response->assertSee($instructor->email);
        $response->assertSee('Volunteer');
        $response->assertDontSee('Hourly rate: £0.00');
    }

    /** @test */
    public function user_can_view_a_coach_instructor()
    {
        $instructor = factory(Instructor::class)->states('coach')->create([
            'hourly_rate' => 1500
        ]);

        $response = $this->get("/instructors/{$instructor->id}");

        $response->assertStatus(200);
        $response->assertSee($instructor->name);
        $response->assertSee($instructor->email);
        $response->assertSee('Coach');
        $response->assertSee('Hourly rate: £15.00');
    }
}
