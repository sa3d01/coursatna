<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Country' => 'App\Policies\CountryPolicy',
        'App\Models\Governorate' => 'App\Policies\GovernoratePolicy',
        'App\Models\City' => 'App\Policies\CityPolicy',
        'App\Models\University' => 'App\Policies\UniversityPolicy',
        'App\Models\Faculty' => 'App\Policies\FacultyPolicy',
        'App\Models\Major' => 'App\Policies\MajorPolicy',
        'App\Models\Field' => 'App\Policies\FieldPolicy',
        'App\Models\Item' => 'App\Policies\ItemPolicy',
        'App\Models\ChargingCode' => 'App\Policies\ChargingCodePolicy',
        'App\Models\ChatRoom' => 'App\Policies\RoomPolicy',
        'App\Models\Subject' => 'App\Policies\SchoolSubjectPolicy',
        'App\Models\UniversitySubject' => 'App\Policies\UniversitySubjectPolicy',
        'App\Models\Announcement' => 'App\Policies\AnnouncementPolicy',
        'App\Models\BannedWord' => 'App\Policies\BannedWordPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
