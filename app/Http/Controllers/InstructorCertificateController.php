<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorCertificateController extends Controller
{
    public function store(Instructor $instructor, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|between:2,255',
            'description' => 'nullable|between:10,500',
            'type' => 'required|in:qualification,background-check',
            'expiry_date' => [
                'required',
                'date_format:d-m-Y',
                'after:' . Carbon::parse('+1 month')->format('d-m-Y'), 
            ],
            'file' => 'mimes:mimes:jpeg,bmp,png,gif,pdf|max:2048',
        ]);

        $instructor->certificates()->create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'expiry_date' => Carbon::createFromFormat('d-m-Y', $request->expiry_date),
            'file' => $request->file('file')->store('certificates'),
        ]);

        return redirect("instructors/{$instructor->id}")
            ->with([
                'status' => 'success',
                'message' => 'Certificate uploaded.',
            ]);
    }
}
