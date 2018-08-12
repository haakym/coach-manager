<?php

namespace App\Http\Controllers\DataTable;

use DataTables;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\DataTable\CourseTransformer;

class CourseController extends Controller
{
    public function index()
    {
        return view('datatables.courses.index');
    }

    public function data()
    {
        return DataTables::of(Course::query())
            ->setTransformer(new CourseTransformer)
            ->toJson();
    }
}
