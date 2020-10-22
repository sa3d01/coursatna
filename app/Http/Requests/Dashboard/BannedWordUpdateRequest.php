<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BannedWordUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'word' => 'required|string|max:100|unique:banned_words,word,' . $this->banned_word->id,
            'category' => 'required|string|in:ABUSE,POLITICAL',
        ];
    }
}
