<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CourseSession extends Model
{
    protected $fillable = [
        'topic',
        'uploader_id',
        'course_id',
        'open',
        'file_type',
        'file',
        'external_url',
        'status',
        'start_date',
        'end_date',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, "uploader_id");
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    private $route='course';
    private $images_link='media/videos/course/';

    public function setFileAttribute($file)
    {
        if (isset($this->attributes['file'])) {
            deleteFileFromServer($this->attributes['file']);
        }
        $this->attributes['file'] = $this->upload_file($file);
    }

    public function getFileAttribute()
    {
        $dest='media/videos/course/';
        try {
            if ($this->attributes['file'])
                return asset($dest). '/' . $this->attributes['file'];
            return asset($dest) . '/default.png';
        }catch (\Exception $e){
            return asset($dest) . '/default.png';
        }
    }

    protected function setStartDateAttribute()
    {
        if (request('start_date')!=null){
            if ( is_numeric(request('start_date')) && (int)request('start_date') == request('start_date') ){
                $this->attributes['start_date'] = request('start_date');
            }else{
                $this->attributes['start_date'] = Carbon::parse(request('start_date'))->timestamp;
            }
        }
    }
    protected function setEndDateAttribute($endDate)
    {
        if ($endDate!=null){
            if ( is_numeric($endDate) && (int)$endDate == $endDate ){
                $this->attributes['end_date'] = $endDate;
            }else{
                $this->attributes['end_date'] = Carbon::parse($endDate)->timestamp;
            }
        }
    }

      private function upload_file($file){
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move('media/videos/course/', $filename);
        return $filename;
    }
}
