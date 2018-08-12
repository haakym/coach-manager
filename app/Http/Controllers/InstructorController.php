<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\InstructorTypeUpdated;

class InstructorController extends Controller
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
        return view('instructors/create');
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
            'email' => 'required|email|unique:instructors',
            'type' => 'required|in:coach,volunteer',
            'hourly_rate' => 'required_if:type,coach|regex:/^\d*(\.\d{1,2})?$/'
        ], [
            'hourly_rate.regex' => 'The hourly rate format is invalid, please use the following format: 0.00.'
        ]);

        $instructor = Instructor::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'hourly_rate' => $request->has('hourly_rate') ? $request->hourly_rate : 0,
        ]);

        return redirect("instructors/{$instructor->id}")
            ->with([
                'status' => 'success',
                'message' => "New {$instructor->type} {$instructor->name} added.",
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function show(Instructor $instructor)
    {
        return view('instructors.show', ['instructor' => $instructor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function edit(Instructor $instructor)
    {
        return view('instructors/edit', ['instructor' => $instructor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instructor $instructor)
    {
        $request->validate([
            'name' => 'required|between:2,255',
            'email' => [
                'required',
                'email',
                Rule::unique('instructors')->ignore($instructor->id),
            ],
            'type' => 'required|in:coach,volunteer',
            'hourly_rate' => 'required_if:type,coach|regex:/^\d*(\.\d{1,2})?$/'
        ], [
            'hourly_rate.regex' => 'The hourly rate format is invalid, please use the following format: 0.00.'
        ]);

        $instructor->name = $request->name;
        $instructor->email = $request->email;
        $instructor->type = $request->type;
        $instructor->hourly_rate = $request->has('hourly_rate') ? $request->hourly_rate : 0;
        
        $typeChanged = $instructor->isDirty('type');
        
        $instructor->save();

        if ($typeChanged) {
            event(new InstructorTypeUpdated($instructor));
        }

        return redirect("instructors/{$instructor->id}")
            ->with([
                'status' => 'success',
                'message' => "Instructor updated.",
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instructor $instructor)
    {
        //
    }
}
