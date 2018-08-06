<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddInstructorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_a_volunteer()
    {
        $response = $this->post('instructors', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'type' => 'volunteer',
        ]);

        $instructor = Instructor::first();

        $response->assertRedirect("instructors/{$instructor->id}")
            ->assertSessionHas('message', "New {$instructor->type} {$instructor->name} added.");
        
        $this->assertEquals('Jane Doe', $instructor->name);
        $this->assertEquals('jane@example.com', $instructor->email);
        $this->assertEquals('volunteer', $instructor->type);
        $this->assertEquals(0, $instructor->hourly_rate);
    }
}
