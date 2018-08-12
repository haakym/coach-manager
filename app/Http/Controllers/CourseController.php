<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $course = Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'date_from' => Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d'),
            'date_to' => Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d'),
            'coaches_required' => (int) $request->coaches_required,
            'volunteers_required' => (int) $request->volunteers_required,
        ]);

        return redirect("courses/{$course->id}")
            ->with([
                'status' => 'success',
                'message' => "New course {$course->name} added.",
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load('instructors');

        $data = [
            'course' => $course,
            'coaches' => Instructor::coaches()->get(),
            'volunteers' => Instructor::volunteers()->get(),
        ];

        return view('courses.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        if ($course->has_started) {
            return $this->cannotUpdate($course->id);
        }

        return view('courses.edit', ['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        if ($course->has_started) {
            return $this->cannotUpdate($course->id);
        }

        $validatedData = $request->validate([
            'name' => 'required|between:2,255',
            'description' => 'nullable|between:10,500',
            'address' => 'nullable|between:10,500',
        ]);

        $course->name = $request->name;
        $course->description = $request->description;
        $course->address = $request->address;
        $course->save();

        return redirect("courses/{$course->id}")
            ->with([
                'status' => 'success',
                'message' => 'Course updated.',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    private function cannotUpdate($id)
    {
        return redirect()->route('courses.show', ['id' => $id])
            ->with([
                'status' => 'info',
                'message' => 'You cannot edit a course that has already started or finished.'
            ]);
    }
}
