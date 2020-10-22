<?php

namespace App\Http\Resources\Locations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityDTO extends JsonResource
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
            'id' => (int)$this->id,
            'governorate_id' => (int)$this->governorate_id,
            'name' => [
                'en' => $this->name_en,
                'ar' => $this->name_ar,
            ],
        ];
    }
}
