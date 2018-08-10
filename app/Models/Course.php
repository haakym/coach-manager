<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Instructor;
use App\Models\CourseInstructor;

class Course extends Model
{
    protected $guarded = [];

    protected $dates = ['date_from', 'date_to'];
    
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class)
            ->using(CourseInstructor::class)
            ->withPivot('date_from', 'date_to')
            ->withTimestamps();
            // ->as('bettername')
    }
    
    public function coaches()
    {
        return $this->instructors()->where('type', 'coach');
    }
    
    public function volunteers()
    {
        return $this->instructors()->where('type', 'volunteer');
    }

    public function instructorRequirementByType($type)
    {
        $attribute = str_plural($type) . '_required';

        return $this->$attribute;
    }
}
