<?php

namespace App\Http\Transformers\DataTable;

use League\Fractal\TransformerAbstract;
use App\Models\Course;
use App\Http\Transformers\BuildsLinks;

class CourseTransformer extends TransformerAbstract
{
    use BuildsLinks;

    public function transform(Course $course)
    {
        return [
            'id' => $course->id,
            'name' => $course->name,
            'description' => $course->description,
            'address' => $course->address,
            'date_from' => $course->date_from->format('d-m-Y'),
            'date_to' => $course->date_to->format('d-m-Y'),
            'coaches_required' => $course->coaches_required,
            'volunteers_required' => $course->volunteers_required,
            'view' => $this->showLink('courses.show', $course->id),
        ];
    }
}
