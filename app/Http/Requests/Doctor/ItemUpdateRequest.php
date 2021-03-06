<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:150',
            'type' => 'required|in:BOOK,SHEET,SUMMARY,OTHER',
            'subject' => 'required|exists:levels,label',
            'file' => 'nullable|mimes:pdf',
            'image' => 'nullable|mimes:png,jpeg,jpg',
            'price' => 'required|numeric',
            'description' => 'required|string|max:500',
            'university_subject_id' => 'nullable|numeric|exists:university_subjects,id',
        ];
    }
}
