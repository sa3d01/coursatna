<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update([
            'last_session_id' => session()->getId(),
            'last_ip' => $request->ip(),
        ]);

        if ($user->hasRole('UNIVERSITY_DOCTOR') || $user->hasRole('UNIVERSITY_HEAD_DOCTOR')) {
            return redirect()->route('doctor.index')
                ->with('message', 'Logged in successfully')->with('class', 'alert-success');
        }
        if ($user->hasRole('UNIVERSITY_CREATOR_STUDENT')) {
            return redirect()->route('creator-student.index')
                ->with('message', 'Logged in successfully')->with('class', 'alert-success');
        }
        return null;
    }
}
