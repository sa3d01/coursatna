<?php

namespace App\Http\Resources\Ask;

use App\Http\Resources\AuthUsers\StudentUserDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\SubjectDTO;
use App\Models\Ask;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionDTO extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $asks_count=Ask::where('section_id',$this->id)->count();
        return [
            'id' => (int)$this->id,
            'name_ar' => $this->name_ar,
            'subject' => SubjectDTO::make($this->subject),
            'asks_count'=>$asks_count
        ];
    }
}
