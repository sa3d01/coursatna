<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\AuthUsers\StudentUserDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\SubjectDTO;
use App\Models\Favourite;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDTO extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $favourite=Favourite::where(['user_id'=>\request()->user()->id, 'course_id'=>$this->id])->first();
        if ($favourite){
            $is_favourite=true;
        }else{
            $is_favourite=false;
        }
        $subscribed=Subscribe::where(['user_id'=>$request->user()->id, 'course_id'=> $this->id])->first();
        if ($subscribed){
            $is_subscribed=true;
        }else{
            $is_subscribed=false;
        }
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'teacher' => $this->teacher->name ?? "",
            'subject' => SubjectDTO::make($this->subject),
            'level' => LevelDTO::make($this->level),
            'image' =>$this->image,
            'price' => (int)$this->price,
            'rate'=>(double)$this->ratings->avg('rate'),
            'is_favourite'=>$is_favourite,
            'subscribed'=>$is_subscribed
        ];
    }
}
