<?php

namespace App\Http\Requests\Dashboard\SysManagement;

use App\Helpers\MoPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SysUserUpdateRequest extends FormRequest
{
    public function authorize()
    {
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
            if (!Hash::check($this->current_password, $this->sys_user->password)) {
                throw  ValidationException::withMessages([
                    'current_password' => 'Wrong password!',
                ]);
            }
        }
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|max:255|min:3',
            'phone' => 'required|string|max:90|unique:users,phone,' . $this->sys_user->id,
            'email' => 'required|email|max:90|unique:users,email,' . $this->sys_user->id,
            'password' => 'nullable|min:5|confirmed',
        ];

        if ($this->sys_user->isMe) {
            $rules['current_password'] = 'required';
        }

        if (auth()->user()->can('edit-users-roles') && !$this->sys_user->isMe) {
            $rules['role'] = 'required|in:SYS_SUPPORT';
        }

        return $rules;
    }
}
