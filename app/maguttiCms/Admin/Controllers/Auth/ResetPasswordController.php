<?php

namespace App\maguttiCms\Admin\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    protected $redirectTo   = '/admin';
    protected $redirectPath = '/admin';
    protected $guard        = 'admin';
    protected $broker       = 'admin';

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->redirectTo      = '/admin';
        $this->redirectPath    = '/admin';
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function broker()
    {
        return Password::broker('admin');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();
        $this->guard()->login($user);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:10|regex:'.config('maguttiCms.security.password_regex'),
        ];
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($response == 'passwords.user') {
            $response = 'passwords.invalid';
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
