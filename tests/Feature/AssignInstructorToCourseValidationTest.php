<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class AssignInstructorToCourseValidationTest extends TestCase
{
    use RefreshDatabase, InteractsWithExceptionHandling;

    /** @test */
    public function validation_fails_when_course_status_is_assigned()
    {
        
    }

    /** @test */
    public function validation_fails_when_coach_requirement_is_already_met()
    {

    }

    /** @test */
    public function validation_fails_when_coach_double_books()
    {

    }

    /** @test */
    public function validation_fails_when_coach_is_assigned_to_a_fully_booked_day()
    {

    }
}
