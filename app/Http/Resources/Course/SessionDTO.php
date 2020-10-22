<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\AuthUsers\StudentUserDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\SubjectDTO;
use App\Models\Subscribe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionDTO extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $subscribed=Subscribe::where(['user_id'=>$request->user()->id, 'course_id'=> $this->course_id])->first();
        $arr['id']=(int)$this->id;
        $arr['topic']=$this->topic;
        if ($subscribed){
            $updated_at= Carbon::parse($subscribed->updated_at);
            $now = Carbon::now();
            $difference = ($updated_at->diff($now)->days > 30)
                ? 0
                : 1;
            $arr['open']=$difference;
        }else{
            $arr['open']=(int)$this->open;
        }
        $arr['file_type']=$this->file_type;
        $arr['file']=$this->file;
        return $arr;
    }
}
