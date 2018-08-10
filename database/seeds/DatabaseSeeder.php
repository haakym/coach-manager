<?php

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Instructor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Course::class, 3)->create();
        factory(Instructor::class, 2)->states('coach')->create();
        factory(Instructor::class, 2)->states('volunteer')->create();
    }
}
