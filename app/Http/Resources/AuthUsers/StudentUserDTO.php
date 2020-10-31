<?php

namespace App\Http\Resources\AuthUsers;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentUserDTO extends JsonResource
{

    public function toArray($request)
    {
        if ($this->level_id!=null){
            if($this->level->college_id!=null){
                $level=[
                    'id' => $this->level ? (int)$this->level->id : 0,
                    'class_stage' => [
                        'id'=>$this->level ? (int)$this->level->college_id : 0,
                        'name'=>[
                            'en' => $this->level ? $this->level->college->name_en : "",
                            'ar' => $this->level ? $this->level->college->name_ar : "",
                        ]
                    ],
                    'stage' => [
                        'id'=>$this->level ? (int)$this->level->stage_id : 0,
                        'name'=>[
                            'en' => $this->level ? $this->level->stage->name_en : "",
                            'ar' => $this->level ? $this->level->stage->name_ar : "",
                        ]
                    ],
                ];
            }else{
                $level=[
                    'id' => $this->level ? (int)$this->level->id : 0,
                    'class_stage' => [
                        'id'=>$this->level ? (int)$this->level->class_stage_id : 0,
                        'name'=>[
                            'en' => $this->level ? $this->level->class_stage->name_en : "",
                            'ar' => $this->level ? $this->level->class_stage->name_ar : "",
                        ]
                    ],
                    'stage' => [
                        'id'=>$this->level ? (int)$this->level->stage_id : 0,
                        'name'=>[
                            'en' => $this->level ? $this->level->stage->name_en : "",
                            'ar' => $this->level ? $this->level->stage->name_ar : "",
                        ]
                    ],
                ];
            }
        }else{
            $level="";
        }
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'email' => $this->email ?? "",
            'phone' => $this->phone ?? "",
            'birthday' => $this->birthday ?? "",
            'avatar_link' => $this->avatarLink,
            'cover_photo_link' => $this->cover_photo_link,
            'gender' => $this->gender ?? "",
            'bio' => $this->bio ?? "",
            'learn_type'=>$this->learn_type,
            'level' => $level,
            'governorate' => [
                'id' => $this->governorate ? (int)$this->governorate->id : 0,
                'name' => [
                    'en' => $this->governorate ? $this->governorate->name_en : "",
                    'ar' => $this->governorate ? $this->governorate->name_ar : "",
                ],
            ],
            'city' => [
                'id' => $this->city ? (int)$this->city->id : 0,
                'name' => [
                    'en' => $this->city ? $this->city->name_en : "",
                    'ar' => $this->city ? $this->city->name_ar : "",
                ],
            ],
        ];
    }
}
