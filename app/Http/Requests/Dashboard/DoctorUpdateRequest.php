<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->can('edit-doctors');
    }

    public function rules()
    {
        return [
            'city_id' => 'required|numeric|exists:cities,id',
            'university_id' => 'required|numeric|exists:universities,id',
            'faculty_id' => 'required|numeric|exists:faculties,id',
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|unique:users,email,' . $this->doctor->id,
            'password' => 'nullable|min:5|confirmed',
            'avatar' => 'nullable|mimes:png,jpeg,jpg',
        ];
    }
}
