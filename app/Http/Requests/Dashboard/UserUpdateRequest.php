<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\MoPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Hash;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->user->hasRole('SUPER_ADMIN') && !$this->user->isMe) {
            return false;
        }

        return auth()->check() && auth()->user()->can('edit-users');
    }

    protected function prepareForValidation()
    {
        if ($this->has('phone') && $this->phone) {
            $phone = new MoPhone($this->phone);
            if (!$phone->isValid()) {
                throw  ValidationException::withMessages([
                    'phone' => $phone->errorMsg(),
                ]);
            }
            $this->merge(['phone' => $phone->getNormalized()]);
        }

        if ($this->has('current_password') && $this->current_password) {
            if (!Hash::check($this->current_password, $this->user->password)) {
                throw  ValidationException::withMessages([
                    'current_password' => 'Wrong password!',
                ]);
            }
        }
    }

    public function rules(Request $request)
    {
        $rules = [
            'is_verified_by_admin' => 'required|boolean',
            'name' => 'required|max:255|min:3',
            'phone' => 'required|string|max:90|unique:users,phone,' . $this->user->id,
            'email' => 'required|email|max:90|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:5|confirmed',
        ];

        if ($this->user->isMe) {
            $rules['current_password'] = 'required';
        }

        if (auth()->user()->can('edit-users') && !$this->user->isMe) {
            $rules['role'] = 'required|in:UNIVERSITY_STUDENT,SCHOOL_STUDENT';
        }

        if ($request['role'] && $request['role'] == 'UNIVERSITY_STUDENT') {
            $rules['governorate_id'] = 'required|numeric|exists:governorates,id';
            $rules['university_id'] = 'required|numeric|exists:universities,id';
            $rules['faculty_id'] = 'required|numeric|exists:faculties,id';
            $rules['subject'] = 'required|exists:levels,label';
        }
        if ($request['role'] && $request['role'] == 'SCHOOL_STUDENT') {
            $rules['governorate_id'] = 'required|numeric|exists:governorates,id';
            $rules['school_name'] = 'required|string|max:190';
            $rules['subject'] = 'required|exists:levels,label';
        }

        return $rules;
    }
}
