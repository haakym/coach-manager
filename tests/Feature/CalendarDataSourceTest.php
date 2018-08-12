<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarDataSourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function calendar_data_is_properly_formed()
    {
        $dateFrom = Carbon::parse('first day of January next year');
        $dateTo = $dateFrom->copy()->addDays(2);

        $course = factory(Course::class)->create([
            'name' => 'Football Skills Training',
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 1,
        ]);

        $response = $this->get('calendar/data');

        $response->assertStatus(200)
            ->assertExactJson([
                'course_id' => $course->id,
                'title' => $course->name,
                'start' => $dateFrom->format('Y-m-dT00:00:00'),
                'end' => $dateFrom->format('Y-m-dT23:59:59'),
                'className' => $course->status,
                'url' => url('courses') . "/{$course->id}",
            ]);
    }
}