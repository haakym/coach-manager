<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Course;
use App\Models\Instructor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class AssignInstructorToCourseValidationTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    // when course is assigned
    // when requirement is full for duration
    // when requirement is full for part

    /** @test */
    public function validation_fails_when_course_status_is_assigned()
    {
        
    }

    /** @test */
    public function validation_fails_when_coach_requirement_is_already_met_for_dates_specified()
    {

    }

    /** @test */
    public function validation_fails_when_course_status_is_assigned()
    {

    }
}
