<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Course;
use App\Models\Instructor;
use Carbon\Carbon;

class CourseInstructorAssignmentIsValid implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($assignmentProposal)
    {
        $this->dateFrom = Carbon::createFromFormat('d-m-Y', $assignmentProposal['date_from']);
        $this->dateTo = Carbon::createFromFormat('d-m-Y', $assignmentProposal['date_to']);
        $this->instructor = Instructor::findOrFail($assignmentProposal['instructor_id']);
        $this->course = $assignmentProposal['course'];
        $this->type = $assignmentProposal['type'];
        // $assignmentProposal
        "date_from" => "01-01-2019"
        "date_to" => "06-01-2019"
        "instructor_id" => 1
        "type" => "coach"
        dd($assignmentProposal);
        // $this->course = $course;
        // $this->instructor = $instructor;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // course status must not be assigned
        $instructorRequirement = $this->course->instructorRequirementByType($this->type);

        Course::where('date_from')
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
