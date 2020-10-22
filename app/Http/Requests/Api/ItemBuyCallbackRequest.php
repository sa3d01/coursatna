<?php

namespace App\Http\Requests\Api;

class ItemBuyCallbackRequest extends ApiMasterRequest
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
            'merchant_id' => 'required|string|max:100',
            'reference' => 'required|string|max:100',
            'status' => 'required|in:PAID,EXPIRED',
        ];
    }
}
