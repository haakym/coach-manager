<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditInstructorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_the_edit_instructor_page()
    {
        $instructor = factory(Instructor::class)->states('coach')->create();

        $response = $this->get("instructors/{$instructor->id}/edit");

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_edit_a_volunteer()
    {
        $volunteer = factory(Instructor::class)->states('volunteer')->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $response = $this->put("instructors/{$volunteer->id}", [
            'name' => 'Sally Po',
            'email' => 'spo@examples.com',
            'type' => 'volunteer',
        ]);
        
        $response->assertRedirect("instructors/{$volunteer->id}")
            ->assertSessionHas('message', "Instructor updated.");

        $volunteer = instructor::first();
        
        $this->assertEquals('Sally Po', $volunteer->name);
        $this->assertEquals('spo@examples.com', $volunteer->email);
        $this->assertEquals('volunteer', $volunteer->type);
        $this->assertEquals(0, $volunteer->hourly_rate);
    }
}
