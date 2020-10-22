<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ChargingCodeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        //return auth()->user()->can('edit-charging-codes');
        return false;
    }

    public function rules()
    {
        return [
            'expires_at' => 'required',
        ];
    }
}
