<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CreatorStudentStoreRequest extends FormRequest
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
            'governorate_id' => 'required|numeric|exists:governorates,id',
            'university_id' => 'required|numeric|exists:universities,id',
            'faculty_id' => 'required|numeric|exists:faculties,id',
            'name' => 'required|min:3|max:190',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ];
    }
}
