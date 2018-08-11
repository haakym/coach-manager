<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Events\InstructorAssignedToCourse;
use App\Http\Requests\AssignInstructorToCourseRequest;

class CourseInstructorController extends Controller
{
    public function store(Course $course, AssignInstructorToCourseRequest $request)
    {
        $course->instructors()->attach($request->instructor_id, [
            'date_from' => Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d'),
            'date_to' => Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d'),
        ]);

        event(new InstructorAssignedToCourse($course));

        return redirect("courses/{$course->id}")
            ->with([
                'status' => 'success',
                'message' => ucfirst($request->type) . ' assigned to course.',
            ]);
    }
}
