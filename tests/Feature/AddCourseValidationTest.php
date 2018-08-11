<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCourseValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function validation_fails_when_coaches_and_volunteers_set_to_zero()
    {
        $response = $this->post('courses', [
            'coaches_required' => '0',
            'volunteers_required' => '0',
        ]);

        $response->assertSessionHasErrors([
            'coaches_required' => 'A course must have at least one coach or volunteer.',
            'volunteers_required' => 'A course must have at least one coach or volunteer.',
        ]);
    }
}
