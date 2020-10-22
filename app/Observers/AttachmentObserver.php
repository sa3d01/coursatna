<?php

namespace App\Observers;

use App\Models\Attachment;
use App\Models\User;
use App\Traits\MoFCM;

class AttachmentObserver
{
    use MoFCM;

    public function created(Attachment $item)
    {
        $this->sendForApproved($item);
    }

    public function updated(Attachment $item)
    {
        $this->sendForApproved($item);
    }

    private function sendForApproved(Attachment $item)
    {
//        if ($item->status == 'APPROVED') {
//            $data = [
//                'title' => 'New ' . $item->type,
//                'body' => 'تم إضافة ' . $item->name,
//                'key' => 'NEW_ITEM',
//                //
//                'item_id' => $item->id,
//                'image_link' => $item->image_link,
//            ];
//
//            $where = ['subject' => $item->subject];
//            if ($item->item_for == 'UNIVERSITY') {
//                $universitySubject = UniversitySubject::where([
//                    'id' => $item->university_subject_id
//                ])->first();
//                $where ['faculty_id'] = $universitySubject->faculty_id;
//                if ($universitySubject->major_id) {
//                    $where['major_id'] = $universitySubject->major_id;
//                }
//            }
//            /*if ($item->item_for == 'SCHOOL') {
//                $where  ['school_subject_id'] = '';
//            }*/
//
//            $ios_tokens = User::where($where)
//                ->where('os_type', 'ios')->pluck('fcm_token')->toArray();
//            $android_tokens = User::where($where)
//                ->where('os_type', 'android')->pluck('fcm_token')->toArray();
//
//            if ($ios_tokens)
//                $this->sendIosSingleFCM($ios_tokens, $data);
//            if ($android_tokens)
//                $this->sendAndroidSingleFCM($android_tokens, $data);
//        }
    }
}
