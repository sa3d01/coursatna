<?php

namespace App\Observers;

use App\Models\Announcement;
use App\Models\User;
use App\Traits\MoFCM;

class AnnouncementObserver
{
    use MoFCM;

    public function created(Announcement $announcement)
    {
        $data = [
            'title' => 'تنبيه من الدكتور '. $announcement->user->name,
            'body' => $announcement->text,
            'key' => 'NEW_ANNOUNCEMENT',
            //
            'announcement_id' => $announcement->id,
            'image_link' => $announcement->user->avatar_link,
        ];


        $where = [
            'subject' => $announcement->level,
            'faculty_id' => $announcement->faculty_id,
        ];
        if ($announcement->major_id) {
            $where['major_id'] = $announcement->major_id;
        }

        $ios_tokens = User::where($where)
            ->where('os_type', 'ios')->pluck('fcm_token')->toArray();
        $android_tokens = User::where($where)
            ->where('os_type', 'android')->pluck('fcm_token')->toArray();


        if ($ios_tokens)
            $this->sendIosSingleFCM($ios_tokens, $data);
        if ($android_tokens)
            $this->sendAndroidSingleFCM($android_tokens, $data);
    }
}
