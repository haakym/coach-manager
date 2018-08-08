<?php

namespace Tests\Unit\Models;

use App\Models\Instructor;
use Tests\TestCase;

class InstructorTest extends TestCase
{
    /** @test */
    public function gets_hourly_rate_in_pounds()
    {
        $coach = factory(Instructor::class)->states('coach')->make([
            'hourly_rate' => 1650
        ]);

        $this->assertEquals('16.50', $coach->hourly_rate_in_pounds);
    }

    /** @test */
    public function sets_hourly_rate_to_int()
    {
        $coach = factory(Instructor::class)->states('coach')->make();
        
        // ToDo, fix this
        $coach->hourly_rate = '1';
        $this->assertEquals('1.00', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = '16.50';
        $this->assertEquals('16.50', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = '16.5';
        $this->assertEquals('16.50', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = '2000';
        $this->assertEquals('2000.00', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = '0.01';
        $this->assertEquals('0.01', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = '1.111';
        $this->assertEquals('1.11', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = '999.999';
        $this->assertEquals('999.99', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = 0.1;
        $this->assertEquals('0.10', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = 1.111;
        $this->assertEquals('1.11', $coach->hourly_rate_in_pounds);

        $coach->hourly_rate = 'a';
        $this->assertEquals('0.00', $coach->hourly_rate_in_pounds);
        
        $coach->hourly_rate = true;
        $this->assertEquals('0.00', $coach->hourly_rate_in_pounds);
    }
}
