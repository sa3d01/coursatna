<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class NotificationStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $rules = [
            'country_id' => 'required|numeric|exists:countries,id',
            'subject' => 'required|exists:levels,label',
            'title' => 'required|string|max:190',
            'message' => 'required|string|max:500',
            'notification_for' => 'required|in:UNIVERSITY,SCHOOL',
        ];

        if ($request['notification_for'] == 'UNIVERSITY') {
            //$rules['governorate_id'] = 'required|numeric|exists:governorates,id';
            //$rules['university_id'] = 'required|numeric|exists:universities,id';
            $rules['faculty_id'] = 'required|numeric|exists:faculties,id';
            $rules['major_id'] = 'nullable|numeric|exists:majors,id';
        }

        return $rules;
    }
}
