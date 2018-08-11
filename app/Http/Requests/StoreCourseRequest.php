<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $instructorMin = '';

        if ($this->coaches_required == 0 && $this->volunteers_required == 0) {
            $instructorMin = '|min:1';
        }

        return [
            'name' => 'required|between:2,255',
            'description' => 'nullable|between:10,500',
            'address' => 'nullable|between:10,500',
            'date_from' => 'required|date_format:"d-m-Y|after:today',
            'date_to' => 'required|date_format:"d-m-Y|after_or_equal:date_from',
            'coaches_required' => 'required|integer' . $instructorMin,
            'volunteers_required' => 'required|integer' . $instructorMin,
        ];
    }

    public function messages()
    {
        return [
            'coaches_required.min' => 'A course must have at least one coach or volunteer.',
            'volunteers_required.min' => 'A course must have at least one coach or volunteer.',
        ];
    }
}
