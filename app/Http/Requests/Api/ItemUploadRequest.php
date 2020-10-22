<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ItemUploadRequest extends FormRequest
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

    public function rules(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:150',
            'type' => 'required|in:BOOK,SHEET,SUMMARY,OTHER',
            'subject' => 'required|exists:levels,label',
            'author' => 'nullable|string|max:150',
            'file' => 'required|mimes:pdf',
            'image' => 'nullable|mimes:png,jpeg,jpg',
            'price' => 'required|numeric',
            'description' => 'required|string|max:500',
            'item_for' => 'required|in:UNIVERSITY,SCHOOL',
        ];

        if ($request['item_for'] == 'UNIVERSITY') {
            //$rules['major_id'] = 'nullable|numeric|exists:majors,id';
            //$rules['faculty_id'] = 'required|numeric|exists:faculties,id';
            //$rules['university_id'] = 'required|numeric|exists:universities,id';
            $rules['university_subject_id'] = 'required|numeric|exists:university_subjects,id';
            //$rules['city_id'] = 'required|numeric|exists:cities,id';
        } else {
            $rules['school_subject_id'] = 'required|numeric|exists:school_subjects,id';
        }

        return $rules;
    }
}
