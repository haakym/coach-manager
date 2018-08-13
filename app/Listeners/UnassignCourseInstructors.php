<?php

namespace App\Listeners;

use App\Events\CourseDateOrRequiredAttributesUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnassignCourseInstructors
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
     * @param  CourseDateOrRequiredAttributesUpdated  $event
     * @return void
     */
    public function handle(CourseDateOrRequiredAttributesUpdated $event)
    {
        $event->course->unassignInstructors();
    }
}
