<?php

namespace Tests\Unit\Models;

use App\Models\Instructor;
use Tests\TestCase;

class InstructorTest extends TestCase
{
    /** @test */
    public function hourly_rate_in_pounds()
    {
        $coach = factory(Instructor::class)->states('coach')->make([
            'hourly_rate' => 1650
        ]);

        $this->assertEquals('16.50', $coach->hourly_rate_in_pounds);
    }
}
