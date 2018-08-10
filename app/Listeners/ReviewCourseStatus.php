<?php

namespace App\Listeners;

use App\Events\InstructorAssignedToCourse;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewCourseStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InstructorAssignedToCourse  $event
     * @return void
     */
    public function handle(InstructorAssignedToCourse $event)
    {
        //
    }
}
