<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Requests\AssignInstructorToCourseRequest;

class CourseInstructorController extends Controller
{
    public function store(Course $course, AssignInstructorToCourseRequest $request)
    {
        $course->instructors()->create([
            'instructor_id' => $instructor->id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);

        // assign instructor to course
        // validation
        // make sure it's free
            // make sure volunteer or coach space is available/required
        // make sure dates are within course dates
    }
}
