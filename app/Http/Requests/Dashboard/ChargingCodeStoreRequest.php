<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ChargingCodeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('create-charging-codes');
    }

    public function rules()
    {
        return [
            'expires_at' => 'required',
            'money' => 'required|numeric|min:5|max:500',
            'count' => 'required|numeric|min:1|max:5000',
        ];
    }
}
