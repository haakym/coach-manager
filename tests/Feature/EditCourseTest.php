<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditCourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_the_edit_course_page()
    {
        $course = factory(Course::class)->create();

        $response = $this->get("courses/{$course->id}/edit");

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_edit_a_course()
    {
        $course = factory(Course::class)->create([
            'name' => 'Football skills under 11s',
            'description' => 'Football training for kids',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'date_from' => Carbon::parse('+2 days')->format('Y-m-d'),
            'date_to' => Carbon::parse('+5 days')->format('Y-m-d'),
            'coaches_required' => 2,
            'volunteers_required' => 2,
        ]);

        $response = $this->put("courses/{$course->id}", [
            'name' => 'Football skills under 13s',
            'description' => 'Football training for teens',
            'address' => 'Some Football Pitch, London, N4 XYZ',
            'date_from' => Carbon::parse('+10 days')->format('d-m-Y'),
            'date_to' => Carbon::parse('+12 days')->format('d-m-Y'),
            'coaches_required' => 1,
            'volunteers_required' => 1,
        ]);
        
        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', "Course updated.");

        $course = Course::first();
        
        $this->assertEquals('Football skills under 13s', $course->name);
        $this->assertEquals('Football training for teens', $course->description);
        $this->assertEquals('Some Football Pitch, London, N4 XYZ', $course->address);
        $this->assertEquals(Carbon::parse('+10 days')->format('Y-m-d'), $course->date_from->format('Y-m-d'));
        $this->assertEquals(Carbon::parse('+12 days')->format('Y-m-d'), $course->date_to->format('Y-m-d'));
        $this->assertEquals(1, $course->coaches_required);
        $this->assertEquals(1, $course->volunteers_required);
    }

    /** @test */
    public function a_courses_instructors_are_not_unassigned_when_a_courses_dates_or_requirements_are_not_updated()
    {
        $courseData = [
            'name' => 'Football skills under 11s',
            'description' => 'Football training for kids',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'date_from' => Carbon::parse('+2 days')->format('Y-m-d'),
            'date_to' => Carbon::parse('+5 days')->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 0,
        ];
            
        $course = factory(Course::class)->create(array_merge($courseData, ['status' => 'assigned']));

        $coach = factory(Instructor::class)->states('coach')->create();
        $course->instructors()->attach($coach->id, [
            'date_from' => $course->date_from->format('Y-m-d'),
            'date_to' => $course->date_to->format('Y-m-d'),
        ]);
        
        $this->assertEquals(1, $course->instructors()->count());

        $response = $this->put("courses/{$course->id}", $courseData);
            
        $this->assertEquals(1, Course::first()->instructors()->count());
        $this->assertEquals('assigned', Course::first()->status);
    }

    /** @test */
    public function a_courses_instructors_are_unassigned_when_a_courses_dates_or_requirements_are_updated()
    {
        $course = factory(Course::class)->create([
            'name' => 'Football skills under 11s',
            'description' => 'Football training for kids',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'status' => 'assigned',
            'date_from' => Carbon::parse('+2 days')->format('Y-m-d'),
            'date_to' => Carbon::parse('+5 days')->format('Y-m-d'),
            'coaches_required' => 1,
            'volunteers_required' => 1,
        ]);

        $volunteer = factory(Instructor::class)->states('volunteer')->create();
        $coach = factory(Instructor::class)->states('coach')->create();

        $course->instructors()->attach($volunteer->id, [
            'date_from' => $course->date_from->format('Y-m-d'),
            'date_to' => $course->date_to->format('Y-m-d'),
        ]);

        $course->instructors()->attach($coach->id, [
            'date_from' => $course->date_from->format('Y-m-d'),
            'date_to' => $course->date_to->format('Y-m-d'),
        ]);

        $this->assertEquals(2, Course::first()->instructors->count());
        
        $response = $this->put("courses/{$course->id}", [
            'name' => 'Football skills under 13s',
            'description' => 'Football training for teens',
            'address' => 'Some Football Pitch, London, N4 XYZ',
            'date_from' => Carbon::parse('+10 days')->format('d-m-Y'),
            'date_to' => Carbon::parse('+12 days')->format('d-m-Y'),
            'coaches_required' => 2,
            'volunteers_required' => 2,
        ]);

        $course = Course::first();
            
        $this->assertEquals(0, $course->instructors()->count());
        $this->assertEquals('pending', $course->status);
    }

    /** @test */
    public function user_cannot_edit_course_that_has_already_passed()
    {
        $dateFrom = Carbon::parse('-10 days');
        $dateTo = $dateFrom->copy()->subDays(5);

        $course = factory(Course::class)->create([
            'name' => 'Football skills under 11s',
            'description' => 'Football training for kids',
            'address' => 'SuperSkills Soccer UK Ltd, Bridge Rd, Wembley HA9 9JP',
            'date_from' => $dateFrom->format('Y-m-d'),
            'date_to' => $dateTo->format('Y-m-d'),
        ]);

        $response = $this->put("courses/{$course->id}", [
            'name' => 'Football skills under 13s',
            'description' => 'Football training for teens',
            'address' => 'Some Football Pitch, London, N4 XYZ',
            'date_from' => Carbon::parse('+10 days')->format('d-m-Y'),
            'date_to' => Carbon::parse('+12 days')->format('d-m-Y'),
            'coaches_required' => 2,
            'volunteers_required' => 2,
        ]);
        
        $response->assertRedirect("courses/{$course->id}")
            ->assertSessionHas('message', "You cannot edit a course that has already started or finished.");
    }
}
