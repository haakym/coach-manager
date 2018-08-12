<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;
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
    public function user_can_update_a_volunteer()
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

    /** @test */
    public function user_can_update_a_coach()
    {
        $coach = factory(Instructor::class)->states('coach')->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'hourly_rate' => '1200',
        ]);

        $response = $this->put("instructors/{$coach->id}", [
            'name' => 'Sally Po',
            'email' => 'spo@examples.com',
            'type' => 'coach',
            'hourly_rate' => '13.00',
        ]);
        
        $response->assertRedirect("instructors/{$coach->id}")
            ->assertSessionHas('message', "Instructor updated.");

        $coach = instructor::first();
        
        $this->assertEquals('Sally Po', $coach->name);
        $this->assertEquals('spo@examples.com', $coach->email);
        $this->assertEquals('coach', $coach->type);
        $this->assertEquals(1300, $coach->hourly_rate);
    }

    /** @test */
    public function user_can_update_a_coach_to_a_volunteer()
    {
        $instructor = factory(Instructor::class)->states('coach')->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'hourly_rate' => '1200',
        ]);

        $response = $this->put("instructors/{$instructor->id}", [
            'name' => 'Sally Po',
            'email' => 'spo@examples.com',
            'type' => 'volunteer',
        ]);
        
        $response->assertRedirect("instructors/{$instructor->id}")
            ->assertSessionHas('message', "Instructor updated.");

        $instructor = instructor::first();
        
        $this->assertEquals('Sally Po', $instructor->name);
        $this->assertEquals('spo@examples.com', $instructor->email);
        $this->assertEquals('volunteer', $instructor->type);
        $this->assertEquals(0, $instructor->hourly_rate);
    }

    /** @test */
    public function user_can_update_a_volunteer_to_a_coach()
    {
        $instructor = factory(Instructor::class)->states('volunteer')->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'hourly_rate' => 0,
        ]);

        $response = $this->put("instructors/{$instructor->id}", [
            'name' => 'Sally Po',
            'email' => 'spo@examples.com',
            'type' => 'coach',
            'hourly_rate' => '12.25',
        ]);
        
        $response->assertRedirect("instructors/{$instructor->id}")
            ->assertSessionHas('message', "Instructor updated.");

        $instructor = instructor::first();
        
        $this->assertEquals('Sally Po', $instructor->name);
        $this->assertEquals('spo@examples.com', $instructor->email);
        $this->assertEquals('coach', $instructor->type);
        $this->assertEquals(1225, $instructor->hourly_rate);
    }

    /** @test */
    public function an_instructor_is_unassigned_from_future_courses_when_type_is_edited()
    {
        $instructor = factory(Instructor::class)->states('volunteer')->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'hourly_rate' => 0,
        ]);

        $futureCourse = factory(Course::class)->create();
        $futureCourse->instructors()->attach($instructor->id, [
            'date_from' => $futureCourse->date_from->format('Y-m-d'),
            'date_to' => $futureCourse->date_to->format('Y-m-d'),
        ]);

        $pastCourse = factory(Course::class)->create([
            'date_from' => Carbon::parse('-10 days'),
            'date_to' => Carbon::parse('-7 days'),
        ]);
        $pastCourse->instructors()->attach($instructor->id, [
            'date_from' => $pastCourse->date_from->format('Y-m-d'),
            'date_to' => $pastCourse->date_to->format('Y-m-d'),
        ]);

        $response = $this->put("instructors/{$instructor->id}", [
            'name' => 'Sally Po',
            'email' => 'spo@examples.com',
            'type' => 'coach',
            'hourly_rate' => '12.25',
        ]);

        $this->assertEquals(0, $futureCourse->fresh()->instructors()->count());
        $this->assertEquals(1, $pastCourse->fresh()->instructors()->count());
    }
}
