<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectDTO extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'image' => $this->image,
            'name' => [
                'en' => $this->name_en,
                'ar' => $this->name_ar,
            ],
        ];
    }
}
