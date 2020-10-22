<?php

namespace App\Http\Requests\Api\Money;

use App\Http\Requests\Api\ApiMasterRequest;

class InternalTransactionStoreRequest extends ApiMasterRequest
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
            'related_model' => 'required|string|max:15|in:Item',
            'related_id' => 'required|numeric',
            'amount' => 'required|numeric',
        ];
    }
}
