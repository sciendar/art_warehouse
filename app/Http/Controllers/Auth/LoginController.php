<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

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
    protected $redirectTo = '/adminex/paintings';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $authenticate = Auth::attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
//            $user = User::find(Auth::id());
//            if($user->email_verified_at == null and env('APP_ENV') != 'local')
//            {
//                if($user->verify_token == null)
//                {
//                    $user->verify_token = Str::random(40);
//                    $user->save();
//                }

//                Mail::to($user->email)->send(new VerifyEmail($user));
//            }

            if (Str::afterLast($request->url(), '/') == 'login' || Route::is('admin.*')) {
                return redirect()->intended(route('admin.home'));
            } else {
                return redirect()->intended(url()->previous());
            }
        }
        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages(['error' => [trans('auth.failed')]]);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user               = Auth::user();
        $user->last_auth_at = now();
        $user->auth_at      = null;
        $user->auth_code    = null;
        $user->save();

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function username()
    {
        return 'email';
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
