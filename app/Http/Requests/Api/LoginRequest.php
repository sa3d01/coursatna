<?php

namespace App\Http\Requests\Api;

use App\Helpers\MoPhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class LoginRequest extends ApiMasterRequest
{
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

    public function rules()
    {
        return [
            'phone' => 'required|string|max:90',
            'password' => 'required|string|min:6|max:30',
            'fcm_token' => 'required|string',
            'os_type' => 'required|in:android,ios',
        ];
    }
}
