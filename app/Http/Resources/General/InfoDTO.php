<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfoDTO extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'about' => [
                'en' => $this->about_en,
                'ar' => $this->about_ar,
            ],
            'terms' => [
                'en' => $this->terms_en,
                'ar' => $this->terms_ar,
            ],
        ];
    }
}
