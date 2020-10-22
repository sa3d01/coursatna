<?php

namespace App\Http\Requests\Api\Settings;

use App\Helpers\MoPhone;
use App\Http\Requests\Api\ApiMasterRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileUpdateRequest extends ApiMasterRequest
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

    public function rules(Request $request)
    {
        $rules = [
            'name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50|unique:users,phone,' . $request->user()->id,
            'avatar' => 'nullable|mimes:png,jpg,jpeg',
            'gender' => 'nullable|string|in:MALE,FEMALE',
            'governorate_id' => 'nullable|numeric|exists:governorates,id',
            'city_id' => 'nullable|numeric|exists:cities,id',
            'locale' => 'nullable|string|max:3',
            'fcm_token' => 'nullable|string',
            'notification_toggle' => 'nullable|boolean',
            'birthday' => 'nullable|date|before:today',
            'os_type' => 'nullable|in:android,ios',
        ];
        return $rules;
    }
}
