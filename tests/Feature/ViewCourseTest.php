<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCourseTest extends TestCase
{
    /** @test */
    public function user_can_view_a_course()
    {
        $course = factory(Course::class)->create([
            'name' => 'Beginner skills summer camp',
            'description' => 'Football training for beginners ages 11-13',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'date_from' => Carbon::parse('September 10, 2018'),
            'date_to' => Carbon::parse('September 12, 2018'),
        ]);

        $response = $this->get("/courses/{$concert->id}");

        $response->assertStatus(200);

        $response->assertSee('Beginner skills summer camp');
        $response->assertSee('Football training for beginners ages 11-13');
        $response->assertSee('SuperSkills Soccer UK Ltd Bridge Rd, Wembley HA9 9JP');
        $response->assertSee('September 10, 2018');
        $response->assertSee('September 12, 2018');
    }
}
