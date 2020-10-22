<?php

namespace App\Models;

use App\Traits\UserTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use HasRoles;
    use UserTrait;

    protected $fillable = [
        // By User
        'name',
        'email',
        'password',
        'birthday',
        'phone',
        'phone_verified_at',
        'level_updated_at',
        'avatar',
        'cover_photo',
        'gender',
        'bio',
        'level_id',
        'school_name',
        'governorate_id',
        'city_id',
        // By Admin
        'is_verified_by_admin',
        // By System
        'banned',
        'locale',
        'fcm_token',
        'notification_toggle',
        'os_type',
        'last_session_id',
        'last_ip',
        'type',
        'wallet',//for users
        'center_id',//for teachers
        'subject_id',//for teachers
        'debit'//for teachers
    ];

    protected $appends = [
        'allPermissions',
        'profileLink',
        'avatarLink',
        'cover_photo_link',
        'isMe',
        'student_role',
        'conversation_request_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return all the permissions the model has, both directly and via roles.
     *
     * @throws \Exception
     */
    public function getAllPermissionsAttribute()
    {
        $res = [];
        $allPermissions = $this->getAllPermissions();
        foreach ($allPermissions as $p) {
            $res[] = $p->name;
        }
        return $res;
    }

//    public function getStudentRoleAttribute()
//    {
//        return 'NONE';
//    }

//    public function getConversationRequestStatusAttribute()
//    {
//        $authUserId = auth()->id();
//        $receivedRequests = $this->conversationRequestsReceived;
//        if ($receivedRequests->contains('sender_id', $authUserId)) {
//            return $receivedRequests->where('sender_id', $authUserId)->first()->status;
//        }
//        return 'NONE';
//    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // --------- RELATIONS --------- //

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function center()
    {
        return $this->belongsTo(Center::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

//    public function authoredItems()
//    {
//        return $this->belongsToMany(Item::class, 'item_authors', 'author_id', 'item_id');
//    }
//
//    public function boughtItems()
//    {
//        return $this->belongsToMany(Item::class, 'user_bought_item', 'buyer_id', 'item_id');
//    }
    public function nameForSelect(){
        return $this->name;
    }

    public function getRoleArabicName(){
        $role=$this->roles()->first();
        return $role->name ?? '';
    }
    public function favouriteCourses()
    {
        return $this->hasManyThrough( 'App\Models\Course','App\Models\Favourite','user_id','id','id','course_id');
    }
    public function getStatusIcon()
    {
        if ($this->attributes['status'] === 1){
            $name = 'مفعل';
            $key = 'success';
        }else{
            $name = 'محظور';
            $key = 'danger';
        }
        return "<a class='badge badge-$key-inverted'>
                $name
                </a>";
    }
}
