<?php

namespace App\Http\Requests\Api;

class ContactStoreRequest extends ApiMasterRequest
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
            'name' => 'nullable|string|max:190',
            'phone' => 'nullable|string|max:190',
            'email' => 'nullable|email|max:190',
            'redirected_from' => 'nullable|string|max:190',
            'required_value' => 'nullable|string|max:190',
            'message' => 'nullable|string|max:500',
        ];
    }
}
