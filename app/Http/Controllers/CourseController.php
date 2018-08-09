<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|between:2,255',
            'description' => 'nullable|between:10,500',
            'address' => 'nullable|between:10,500',
            'date_from' => 'required|date_format:"d-m-Y|after:today',
            'date_to' => 'required|date_format:"d-m-Y|after_or_equal:date_from',
            'coaches_required' => 'required|integer',
            'volunteers_required' => 'required|integer',
        ]);

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
        return view('courses.show', ['course' => $course]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
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
        //
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
}
