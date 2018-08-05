<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Instructor;
use Carbon\Carbon;
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

    /** @test */
    public function user_can_view_an_instructors_certificates()
    {
        $instructor = factory(Instructor::class)->states('volunteer')->create();

        $qualification = factory(Certificate::class)->states('qualification')->create([
            'name' => 'Coaching certificate',
            'description' => 'Cricket coaching level 4',
            'expiry_date' => null,
            'instructor_id' => $instructor->id,
        ]);
            
        $backgroundCheck = factory(Certificate::class)->states('background-check')->create([
            'name' => 'DBS Check',
            'description' => 'background-check',
            'expiry_date' => Carbon::parse('+1 year'),
            'instructor_id' => $instructor->id,
        ]);

        $response = $this->get("/instructors/{$instructor->id}");

        $response->assertStatus(200);
        $response->assertSee($instructor->name);
        $response->assertSee($instructor->email);
        $response->assertSee('Volunteer');

        $response->assertSee('Coaching certificate');
        $response->assertSee('Cricket coaching level 4');
        $response->assertSee('qualification');
        $response->assertSee('N/A'); // for expiry_date
        
        $response->assertSee('DBS Check');
        $response->assertSee('background-check');
        $response->assertSee(Carbon::parse('+1 year')->format('d-m-Y'));
    }
}
