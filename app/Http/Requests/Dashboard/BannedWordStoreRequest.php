<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BannedWordStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'word' => 'required|string|max:100|alpha|unique:banned_words,word',
            'category' => 'required|string|in:ABUSE,POLITICAL',
        ];
    }
}
