<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class AssignInstructorToCourseTest extends TestCase
{
    use RefreshDatabase, InteractsWithExceptionHandling;

    /** @test */
    public function user_can_assign_a_coach_to_a_course()
    {
        $this->withoutExceptionHandling();

        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $coach = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 0,
        ]);

        $response = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach->id,
            'type' => 'coach',
        ]);

        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', ucfirst($coach->type) . ' assigned to course.');

        // Todo: complete assertions
    }

    /** @test */
    public function user_can_assign_two_coaches_to_share_a_course()
    {
        $this->withoutExceptionHandling();
        
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $coach1 = factory(Instructor::class)->states('coach')->create();
        $coach2 = factory(Instructor::class)->states('coach')->create();

        $course = factory(Course::class)->create([
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 0,
        ]);

        // coach1 assigned to day 1 to day 3
        $course->instructors()->attach($coach1->id, [
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->copy()->subDays(2)->format('Y-m-d'),
        ]);

        // coach2 assigned to day 4 to day 5
        $response = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->copy()->addDays(3)->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach2->id,
            'type' => 'coach',
        ]);

        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', ucfirst($coach2->type) . ' assigned to course.');

        // Todo: complete assertions
    }

    /** @test */
    public function user_can_assign_coaches_and_instructors()
    {

        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(5);

        $coach = factory(Instructor::class)->states('coach')->create();
        $volunteer = factory(Instructor::class)->states('volunteer')->create();

        $course = factory(Course::class)->create([
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 1,
        ]);

        $response1 = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $coach->id,
            'type' => 'coach',
        ]);

        $response2 = $this->post('/courses/1/instructors', [
            'date_from' => $dateFrom->format('d-m-Y'),
            'date_to' => $dateTo->format('d-m-Y'),
            'instructor_id' => $volunteer->id,
            'type' => 'volunteer',
        ]);

        $response2->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', ucfirst($volunteer->type) . ' assigned to course.');

        // Todo: complete assertions
    }
}
