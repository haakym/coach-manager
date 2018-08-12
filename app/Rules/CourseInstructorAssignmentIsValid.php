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
        $this->instructor = Instructor::find($assignmentProposal['instructor_id']);
        $this->course = $assignmentProposal['course'];
        $this->type = $assignmentProposal['type'];
        $this->message = 'The assigned instructor and dates are invalid.';
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
        if ($this->course->status === 'assigned') {
            $this->message = 'The course is already fully assigned.';
            return false;
        }

        $currentAssignments = $this->instructor->courses()
            ->where('courses.id', '!=', $this->course->id)
            ->wherePivot('date_from', '>=', $this->dateFrom->format('Y-m-d') . ' 00:00:00')
            ->wherePivot('date_to', '<=', $this->dateTo->format('Y-m-d') . ' 00:00:00')
            ->count();
        
        if ($currentAssignments != 0) {
            $this->message = 'Coach is already assigned to a different course within this date range.';
            return false;
        }

        $instructorRequirement = $this->course->instructorRequirementByType($this->type);
        
        $instructorsAssigned = call_user_func_array([$this->course, str_plural($this->type)], [])
                            ->wherePivot('date_from', '<=', $this->dateFrom->format('Y-m-d') . ' 00:00:00')
                            ->wherePivot('date_to', '>=', $this->dateTo->format('Y-m-d') . ' 00:00:00')
                            ->get();

        if ($instructorsAssigned->count() >= $instructorRequirement) {
            $this->message = 'There are already enough ' . str_plural($this->type) . ' assigned for these dates.';
            return false;
        }

        if ($instructorsAssigned->where('id', $this->instructor->id)->count() > 0) {
            $this->message = ucfirst($this->type) . ' already assigned within this date range.';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
