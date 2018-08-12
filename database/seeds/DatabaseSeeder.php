<?php

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::parse('+1 week');

        factory(Course::class)->create([
            'date_from' => $date,
            'date_to' => $date->copy()->addDays(2),
        ]);

        factory(Course::class)->create([
            'date_from' => $date->copy()->addDays(5),
            'date_to' => $date->copy()->addDays(10),
        ]);

        factory(Instructor::class, 2)->states('coach')->create();
        factory(Instructor::class, 2)->states('volunteer')->create();
    }
}
