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

    public function reviewStatus()
    {
        $types = ['coach', 'volunteer'];
        $reviewDate = $this->date_from;
        /**
         * Additionally requires "H:i:s" for date format to pass tests using sqlite, 
         * as in tests using sqlite dates retrieved by Laravel in "Y-m-d H:i:s" format 
         * so date comparisons can fail.
         *  
         * See links for details:
         * - https://github.com/laravel/framework/issues/10006
         * - https://github.com/laravel/framework/issues/24693
         */
        // $reviewDateFormatted = $this->date_from->format('Y-m-d');
        $status = 'assigned';

        foreach ($types as $type) {
            $instructorRequirementByType = $this->instructorRequirementByType($type);

            while ($reviewDate <= $this->date_to) {
                
                if ($instructorRequirementByType != 0) {
                    $assignedCount = call_user_func_array([$this, str_plural($type)], [])
                        ->wherePivot('date_from', '<=', $reviewDate->format('Y-m-d H:i:s'))
                        ->wherePivot('date_to', '>=', $reviewDate->format('Y-m-d H:i:s'))
                        // ->get();
                        ->count();
                    // dd($assignedCount);

                    \Log::info($reviewDate->format('Y-m-d') . ": {$assignedCount}");

                    if ($assignedCount != $instructorRequirementByType) {
                        $status = 'pending';
                        break 2;
                    }
                }

                $reviewDate->addDay();
            }
        }

        if ($status == 'assigned') {
            $this->status = $status;
            $this->save();
        }
        
        return $this;
    }
}
