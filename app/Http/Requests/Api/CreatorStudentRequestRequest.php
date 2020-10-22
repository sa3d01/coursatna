<?php

namespace App\Http\Requests\Api;

class CreatorStudentRequestRequest extends ApiMasterRequest
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
            'notes' => 'nullable|max:400|string',
            //'questions' => 'required|array',
            //'questions.*.question' => 'required|string|max:400',
            //'questions.*.answer' => 'required|string|max:400',
        ];
    }
}
