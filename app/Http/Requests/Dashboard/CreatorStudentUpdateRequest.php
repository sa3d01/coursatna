<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CreatorStudentUpdateRequest extends FormRequest
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
        return [
            'city_id' => 'required|numeric|exists:cities,id',
            'university_id' => 'required|numeric|exists:universities,id',
            'faculty_id' => 'required|numeric|exists:faculties,id',
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|unique:users,email,' . $this->creator_student->id,
            'password' => 'nullable|min:5|confirmed'
        ];
    }
}
