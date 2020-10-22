<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('dashboard.auth.login',[
            'title' => 'Admin Login',
            'loginRoute' => 'admin.login',
            'forgotPasswordRoute' => 'admin.password.request',
        ]);
    }

    // public function login(Request $request)
    // {
    //     $this->validator($request);
    //     if(Auth::attempt([
    //                 'email'=>$request['email'],
    //                 'password'=>$request['password'],
    //                 'status'=>1
    //             ])
    //     ){
    //         return redirect()
    //             ->intended(route('admin.home'))
    //             ->with('status','You are Logged in as Admin!');
    //     }
    //     return $this->loginFailed();
    // }

    /**
     * Logout the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()
            ->route('admin.login')
            ->with('status','Admin has been logged out!');
    }

    /**
     * Validate the form data.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }

    /**
     * Redirect back after a failed login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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
