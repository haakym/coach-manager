<?php

namespace App\Events;

use App\Models\Instructor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class InstructorTypeUpdated
{
    use Dispatchable, SerializesModels;

    public $instructor;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Instructor $instructor)
    {
        $this->instructor = $instructor;
    }
}
