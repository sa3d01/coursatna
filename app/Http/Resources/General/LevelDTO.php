<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelDTO extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->college_id!=null){
            return [
                'id' => (int)$this->id,
                'class_stage' => [
                    'id'=>(int)$this->college_id,
                    'name'=>[
                        'en' => $this->college->name_en,
                        'ar' => $this->college->name_ar,
                    ]
                ],
                'stage' => [
                    'id'=>(int)$this->stage_id,
                    'name'=>[
                        'en' => $this->stage->name_en,
                        'ar' => $this->stage->name_ar,
                    ]
                ],
            ];
        }else{
            return [
                'id' => (int)$this->id,
                'class_stage' => [
                    'id'=>(int)$this->class_stage_id ,
                    'name'=>[
                        'en' => $this->class_stage->name_en,
                        'ar' => $this->class_stage->name_ar,
                    ]
                ],
                'stage' => [
                    'id'=>(int)$this->stage_id,
                    'name'=>[
                        'en' => $this->stage->name_en ,
                        'ar' => $this->stage->name_ar ,
                    ]
                ],
            ];
        }
//        return [
//            'id' => (int)$this->id,
//            'class_stage' => [
//                'name'=>[
//                    'en' => $this->class_stage->name_en,
//                    'ar' => $this->class_stage->name_ar,
//                ]
//            ],
//            'stage' => [
//                'name'=>[
//                    'en' => $this->stage->name_en,
//                    'ar' => $this->stage->name_ar,
//                ]
//            ],
//        ];
    }
}
