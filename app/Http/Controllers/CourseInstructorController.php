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
        $course->instructors()->attach($request->instructor_id, [
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);

        return redirect("courses/{$course->id}")
            ->with([
                'status' => 'success',
                'message' => ucfirst($request->type) . ' assigned to course.',
            ]);
    }
}
