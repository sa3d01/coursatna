<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\AuthUsers\StudentUserDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\SubjectDTO;
use App\Models\Favourite;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Object_;
use tests\Mockery\Adapter\Phpunit\EmptyTestCase;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'teacher' => $this->teacher ? $this->teacher->name : '',
            'subject' => SubjectDTO::make($this->subject),
            'level' => LevelDTO::make($this->level),
            'image' =>$this->image,
            'price' => (int)$this->price,
            'rate'=>(double)$this->ratings->avg('rate'),
            'attachments'=>AttachmentDTO::collection($this->attachments),
            'sessions_count'=>count($this->sessions),
            'sessions'=>SessionDTO::collection($this->sessions),
            'is_favourite'=>$is_favourite
        ];
    }
}
