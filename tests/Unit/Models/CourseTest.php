<?php

namespace Tests\Unit\Models;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;

class CourseTest extends TestCase
{
    /** @test */
    public function checks_if_started_or_finished()
    {
        $startedCourse = factory(Course::class)->make([
            'date_from' => Carbon::parse('-1 day'),
            'date_to' => Carbon::parse('+1 day'),
        ]);

        $finishedCourse = factory(Course::class)->make([
            'date_from' => Carbon::parse('-5 days'),
            'date_to' => Carbon::parse('-3 days'),
        ]);

        $notStartedCourse = factory(Course::class)->make([
            'date_from' => Carbon::parse('+5 days'),
            'date_to' => Carbon::parse('+10 days'),
        ]);

        $this->assertTrue($startedCourse->has_started);
        $this->assertTrue($finishedCourse->has_started);
        $this->assertFalse($notStartedCourse->has_started);
    }
}
