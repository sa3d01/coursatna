<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'subject',
        'text',
        'user_id',
        'faculty_id',
        'major_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty');
    }

    public function major()
    {
        return $this->belongsTo('App\Models\Major');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\Attachment', 'related_to_id')
            ->where('related_to_model', '=', 'Announcement');
    }
}
