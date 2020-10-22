<?php

namespace App\Http\Requests\Api;

class PostStoreRequest extends ApiMasterRequest
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
            'text' => 'nullable|string|max:500',

            //'attachments' => 'nullable|array',
            //'attachments.*.file' => 'required|mimes:png,jpeg,jpg',
            //'attachments.*.type' => 'required|string|min:2|max:10',

            'images' => 'nullable|array',
            'images.*' => 'required|mimes:png,jpeg,jpg',
        ];
    }
}
