<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseInstructor extends Pivot
{
    protected $dates = ['date_from', 'date_to'];
}
