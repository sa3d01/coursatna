<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Resources\Course\AttachmentDTO;
use App\Http\Resources\Course\CourseDTO;
use App\Http\Resources\Course\CourseResource;
use App\Models\Attachment;
use App\Models\Course;
use App\Models\Favourite;
use App\Models\Rating;
use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;


class CourseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $q=Course::query();
        if($user->level_id!=null){
            $q=Course::where('level_id',$user->level_id);
        }
        if ($request->has('subject_id')){
            $q=$q->where('subject_id',$request['subject_id']);
        }
        if ($request->has('rating')){
            $q = $q->withCount(['ratings as average_rating' => function($query) {
                $query->select(\DB::raw('coalesce(avg(rate),0)'));
            }])->orderByDesc('average_rating');
        }
        if ($request->has('newest')){
            $q=$q->latest();
        }
        $q=$q->wherehas('sessions');
        return CourseDTO::collection($q->paginate());
    }
    public function libraryOfCourses(Request $request){
        $user = $request->user();
        $subscribe_courses=Subscribe::where('user_id',$user->id)->pluck('course_id');
        return CourseDTO::collection(Course::whereIn('id',$subscribe_courses)->paginate());
    }
    public function libraryOfAttachments(Request $request){
        $user = $request->user();
        $libraryOfAttachments=Subscribe::where('user_id',$user->id)->pluck('attachment_id');
        return AttachmentDTO::collection(Attachment::whereIn('id',$libraryOfAttachments)->paginate());
    }
    public function show($id)
    {
        return CourseResource::make(Course::find($id));
    }
    public function subscribe($id)
    {
        $user = \request()->user();
        if ($user->type!='USER'){
            return response()->json(['message' => "Wrong credentials."], 401); // HTTP_UNAUTHORIZED
        }
        $course=Course::find($id);
        $wallet = (int)$user->wallet;
        if (Subscribe::where(['user_id'=>$user->id, 'course_id'=> $id])->first())
            return response()->json(['message' => "لم تنتهى مدة اشتراكك بعد"], 400);
        if ($course->price > $wallet)
            return response()->json(['message' => "ﻻ يوجد لديك رصيد كافى للإشتراك"], 400);
        Subscribe::create([
           'user_id'=>$user->id,
           'course_id'=> $id
        ]);
        $user->update([
           'wallet'=>$user->wallet-$course->price
        ]);
        return CourseResource::make(Course::find($id));
    }
    public function attachment_subscribe($id)
    {
        $user = \request()->user();
        if ($user->type!='USER'){
            return response()->json(['message' => "Wrong credentials."], 401); // HTTP_UNAUTHORIZED
        }
        $attachment=Attachment::find($id);
        $wallet = (int)$user->wallet;
        if (Subscribe::where(['user_id'=>$user->id, 'attachment_id'=> $id])->first())
            return response()->json(['message' => "أنت تمتلك بالفعل هذه الملزمة"], 400);
        if ($attachment->price > $wallet)
            return response()->json(['message' => "ﻻ يوجد لديك رصيد كافى للشراء"], 400);
        Subscribe::create([
           'user_id'=>$user->id,
           'attachment_id'=> $id
        ]);
        $user->update([
           'wallet'=>$user->wallet-$attachment->price
        ]);
        return CourseResource::make(Course::find($attachment->course_id));
    }
    public function search(Request $request)
    {
        $user = $request->user();
        $q=Course::where('level_id',$user->level_id);
        $search_input=$request['search_input'];
        if ($request->has('search_input')){
            //Todo:teacher-search
//            $teacher_ids=User::whereType('TEACHER')->where('name','like','%'.$search_input.'%')->pluck('id');
//            $q=$q->whereIn('teacher_id',$teacher_ids);
            $q=$q->where('name','like','%'.$search_input.'%');
        }
        return CourseDTO::collection($q->paginate());
    }
    public function favourite(){
        return CourseDTO::collection(\request()->user()->favouriteCourses);
    }
    public function addToFavourite($course_id){
        $is_favourite=Favourite::where(['user_id'=>\request()->user()->id, 'course_id'=>$course_id])->first();
        if ($is_favourite){
            $is_favourite->delete();
        }else{
            Favourite::create([
                'user_id'=>\request()->user()->id,
                'course_id'=>$course_id
            ]);
        }

        return CourseDTO::collection(\request()->user()->favouriteCourses);
    }
}
