<?php

namespace App\Http\Requests\Api\Settings;

use App\Http\Requests\Api\ApiMasterRequest;

class LevelUpdateRequest extends ApiMasterRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'level_id' => 'nullable|numeric|exists:levels,id',
        ];
    }
}
