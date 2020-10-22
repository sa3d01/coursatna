<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\AuthUsers\StudentUserDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\SubjectDTO;
use App\Models\Subscribe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentDTO extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $subscribed=Subscribe::where(['user_id'=>$request->user()->id, 'attachment_id'=> $this->id])->first();
        $arr['id']=(int)$this->id;
        $arr['name']=$this->name;
        $arr['image']=$this->image;
        $arr['price']=(int)$this->price;
        if ($subscribed){
            $arr['file']=$this->file;
        }else{
            $arr['file']='';
        }
        $arr['file_type']=$this->file_type;
        return $arr;
    }
}
