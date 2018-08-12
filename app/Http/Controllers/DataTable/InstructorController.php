<?php

namespace App\Http\Controllers\DataTable;

use DataTables;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\DataTable\InstructorTransformer;

class InstructorController extends Controller
{
    public function index()
    {
        return view('datatables.instructors.index');
    }

    public function data()
    {
        return DataTables::of(Instructor::query())
            ->setTransformer(new InstructorTransformer)
            ->toJson();
    }
}
