<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ItemStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'type' => 'required|in:BOOK,SHEET,SUMMARY,OTHER',
            'subject' => 'required|exists:levels,label',
            'file' => 'required|mimes:pdf',
            'image' => 'nullable|mimes:png,jpeg,jpg',
            'price' => 'required|numeric',
            'description' => 'required|string|max:500',
            'university_subject_id' => 'required|numeric|exists:university_subjects,id',
        ];
    }
}
