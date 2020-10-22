<?php

namespace App\Http\Requests\Api\Money;

use App\Http\Requests\Api\ApiMasterRequest;

class ExternalTransactionStoreRequest extends ApiMasterRequest
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
            'amount' => 'required|string',
            //'prac_reference' => 'required|string|max:100|unique:external_transactions',
            'prac_reference' => 'required|string|max:100',
            'provider_reference' => 'required|string|max:100|unique:external_transactions',
        ];
    }
}
