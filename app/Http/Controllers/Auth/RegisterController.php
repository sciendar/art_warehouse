<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\NewUser;
use App\Mail\VerifyEmail;
use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @return RedirectResponse|JsonResponse
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): JsonResponse|RedirectResponse
    {
        $data = $this->validator($request->all())->validate();

        $is_f_name_check = $this->name_check($data['first_name']);
        $is_l_name_check = $this->name_check($data['last_name']);
        if (isset($is_f_name_check['error']) || isset($is_l_name_check['error'])) {
            return back()->with('error', trans('trans.recaptcha'));
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'],
            'password'     => Hash::make($data['password']),
            'verify_token' => Str::random(40),
        ]);

        if($user->verify_token == null) // не понятно, но должно быть
        {
            $user->verify_token = Str::random(40);
            $user->save();
        }
        try {
            Mail::to($user->email)->send(new VerifyEmail($user));
            Mail::to($user->email)->send(new Welcome($user));
            Mail::to(config('mail.from.address'))->send(new NewUser($user));
        } catch (\Exception $e) {
            Log::error('Письмо не отправлено ' . $e);
        }

        return $user;
    }

    public function name_check($name)
    {
        if (strlen($name) > 7) {
            $count = 0; // Инициализация счётчика

            // Проход по каждому символу строки
            for ($i = 0; $i < strlen($name); $i++) {
                if (ctype_upper($name[$i])) { // Проверка, является ли символ буквой в верхнем регистре
                    $count++; // Увеличение счётчика
                }
            }
            $v = $count / strlen($name);
            if ($v < 1 && $v > 0.3) {
                return ['error' => trans('trans.recaptcha')];
            }
        }
    }
}
