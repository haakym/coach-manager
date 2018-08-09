<?php

namespace App\Http\Requests;

use App\Models\Instructor;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CourseInstructorAssignmentIsValid;

class AssignInstructorToCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date_from' => [
                'required',
                'date_format:"d-m-Y',
                'after_or_equal:' . $this->course->date_from,
            ],
            'date_to' => [
                'required',
                'date_format:"d-m-Y',
                'before_or_equal:' . $this->course->date_to,
            ],
            'type' => [
                'required',
                'in:coach,instructor',
            ],
            'instructor_id' => [
                'required',
                // 'exists,instructors,id',
                new CourseInstructorAssignmentIsValid(
                    array_merge(
                        $this->all(),
                        ['course' => $this->course]
                    )
                ),
            ],
        ];
    }

    public function messages()
    {
        return [
            'instructor_id.required' => 'Please select an instructor.',
            'instructor_id.exists' => 'Instructor not found.',
        ];
    }
}
