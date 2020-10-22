<?php

namespace App\Http\Requests\Dashboard\SysManagement;

use App\Helpers\MoPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SysUserStoreRequest extends FormRequest
{
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

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:190',
            'phone' => 'nullable|string|max:90|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:SYS_SUPPORT',
            'password' => 'required|min:5|confirmed',
        ];
    }
}
