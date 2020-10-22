<?php

namespace App\Http\Requests\Api;

use App\Helpers\MoPhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class PhoneRegisterRequest extends ApiMasterRequest
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
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:90|unique:users',
            'password' => 'required|string|min:6|max:30',
            'birthday' => 'required|date|before:today',
            'gender' => 'nullable|string|in:MALE,FEMALE',
            'governorate_id' => 'required|numeric|exists:governorates,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'locale' => 'required|string|max:3|in:en,ar',
            'fcm_token' => 'required|string',
            'os_type' => 'required|in:android,ios',
        ];
    }
}
