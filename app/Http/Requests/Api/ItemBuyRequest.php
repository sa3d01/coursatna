<?php

namespace App\Http\Requests\Api;

class ItemBuyRequest extends ApiMasterRequest
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
            //'reference' => 'required|string|max:100|unique:transactions',
            //'reference' => 'required|string|max:100',
        ];
    }
}
