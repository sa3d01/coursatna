<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\NotificationStoreRequest;
use App\Models\Country;
use App\Models\Faculty;
use App\Models\Governorate;
use App\Models\Level;
use App\Models\University;
use App\Models\User;
use App\Traits\MoFCM;

class NotificationController extends Controller
{
    use MoFCM;

    public function index()
    {
        return redirect()->route('dashboard.notifications.create');
    }

    public function create()
    {
        $countries = Country::all();
        $governorates = Governorate::where('country_id', $countries->first()->id)->get();
        $universities = University::where('governorate_id', $governorates->first()->id)->get();
        if (count($universities) > 0) {
            $firstUniversityId = $universities->first()->id;
            $faculties = Faculty::where('university_id', $firstUniversityId)->get();

        } else {
            $faculties = [];
        }
        return view('dashboard.notifications.create')
            ->with('levels', Level::all())
            ->with('countries', $countries)
            ->with('governorates', $governorates)
            ->with('universities', $universities)
            ->with('faculties', $faculties);
    }

    public function store(NotificationStoreRequest $request)
    {
        /* == Notification Payload == */
        $notificationPayload = [
            'title' => $request['title'],
            'body' => $request['message'],
            'key' => 'CUSTOM',
        ];

        /* == Target Segment == */
        $where = [
            'subject' => $request['subject'],
            //'country_id' => $request['country_id'],
        ];
        if ($request['notification_for'] == 'UNIVERSITY') {
            $where ['faculty_id'] = $request['faculty_id'];
            if ($request->has('major_id')) {
                $where['major_id'] = $request['major_id'];
            }
        }
        $ios_tokens = User::where($where)
            ->where('os_type', 'ios')->pluck('fcm_token')->toArray();
        $android_tokens = User::where($where)
            ->where('os_type', 'android')->pluck('fcm_token')->toArray();

        /* == Send Notification == */
        if ($ios_tokens)
            $this->sendIosSingleFCM($ios_tokens, $notificationPayload);

        if ($android_tokens)
            $this->sendAndroidSingleFCM($android_tokens, $notificationPayload);

        return redirect()->route('dashboard.notifications.create')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

}
