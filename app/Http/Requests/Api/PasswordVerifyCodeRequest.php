<?php

namespace App\Http\Requests\Api;

use App\Helpers\MoPhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class PasswordVerifyCodeRequest extends ApiMasterRequest
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

    protected function prepareForValidation()
    {
        if ($this->has('phone')) {

            $phone = new MoPhone($this->phone);
            if (!$phone->isValid()) {
                throw new HttpResponseException(response()->json([
                    'field' => 'phone',
                    'message' => $phone->errorMsg()
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)); // 422
            }

            $this->merge(['phone' => $phone->getNormalized()]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'verification_code' => 'required|string|max:9|exists:verification_codes,code',
            'phone' => 'required|string|max:90',
        ];
    }
}
