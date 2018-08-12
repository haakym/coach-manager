<?php

namespace App\Http\Transformers\DataTable;

use League\Fractal\TransformerAbstract;
use App\Models\Instructor;
use App\Http\Transformers\BuildsLinks;

class InstructorTransformer extends TransformerAbstract
{
    use BuildsLinks;

    public function transform(Instructor $instructor)
    {
        return [
            'id' => $instructor->id,
            'name' => $instructor->name,
            'type' => $instructor->type,
            'email' => $instructor->email,
            'hourly_rate' => $instructor->hourly_rate ? "£ {$instructor->hourly_rate_in_pounds}" : 'N/A',
            'view' => $this->showLink('instructors.show', $instructor->id),
        ];
    }
}
