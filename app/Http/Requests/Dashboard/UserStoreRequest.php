<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\MoPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->can('create-users');
    }

    protected function prepareForValidation()
    {
        if ($this->has('phone')) {

            $phone = new MoPhone($this->phone);
            if (!$phone->isValid()) {
                throw  ValidationException::withMessages([
                    'phone' => $phone->errorMsg(),
                ]);
            }

            $this->merge(['phone' => $phone->getNormalized()]);
        }
    }

    public function rules(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:190',
            'phone' => 'required|string|max:90|unique:users',
            'email' => 'required|email|unique:users',
            'subject' => 'required|exists:levels,label',
            //'role' => 'required|exists:roles,id',
            'password' => 'required|min:5|confirmed',
            'governorate_id' => 'required|numeric|exists:governorates,id',
        ];

        if ($request['role'] == 'UNIVERSITY_STUDENT') {
            $rules['faculty_id'] = 'required|numeric|exists:faculties,id';
            $rules['university_id'] = 'required|numeric|exists:universities,id';
        }
        if ($request['role'] == 'SCHOOL_STUDENT') {
            $rules['school_name'] = 'required|string|max:190';
        }

        return $rules;
    }
}
