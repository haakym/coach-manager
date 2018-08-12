<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar/index');
    }

    public function data()
    {
        $start = request('start', Carbon::parse('first day of this month')->format('Y-m-d'));
        $end = request('end', Carbon::parse('last day of this month')->format('Y-m-d'));

        $courses = Course::query()
            ->select(
                'courses.id as course_id',
                'courses.name as title',
                DB::raw('concat(courses.date_from, "T00:00:00") as start'),
                DB::raw('concat(courses.date_to, "T23:59:59") as end'),
                'courses.status as className',
                DB::raw('concat("' . url('courses') . '/", courses.id) as url')
            )->where('courses.date_from', '>=', $start)
            ->orWhere('courses.date_to', '<=', $end)
            ->get();
        
        return response()->json($courses);
    }
}
