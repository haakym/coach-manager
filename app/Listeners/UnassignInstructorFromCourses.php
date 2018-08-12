<?php

namespace App\Listeners;

use App\Events\InstructorTypeUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnassignInstructorFromCourses
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
     * @param  InstructorTypeUpdated  $event
     * @return void
     */
    public function handle(InstructorTypeUpdated $event)
    {
        $event->instructor->unassignFromCourses();
    }
}
