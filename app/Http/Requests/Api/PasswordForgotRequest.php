<?php

namespace App\Http\Requests\Api;

use App\Helpers\MoPhone;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class PasswordForgotRequest extends ApiMasterRequest
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
            //'phone' => 'required|string|max:90|exists:users,phone',
            'phone' => 'required|string|max:90',
        ];
    }
}
