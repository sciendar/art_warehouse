<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewUseVerifyEmail;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerifyEmailController extends Controller
{
    public function verify(Request $request, $token = null)
    {
        if($request->method() == 'POST') {
            $user = User::find(auth()->id());
            if($user->verify_token == null) {
                $user->verify_token = Str::random(40);
                $user->save();
            }
            try {
                Mail::to($user->email)->send(new VerifyEmail($user));
            } catch (\Exception $e) {
                Log::error('Письмо не отправлено ' . $e);
            }

            return back()->with('success', trans('trans.check_your_email_and_click_the_link_to_verify'));
        }

        $user = User::where('verify_token', $token)->first();

        if(!$user || $token == null) {
            return redirect()->route('home')->with('error', trans('trans.sorry_your_link_cannot_be_identified'));
        }
        if($user->email_verified_at != null) {
            return redirect()->route('home')->with('error', trans('trans.your_email_address_has_already_been_verified'));
        }

        $user->email_verified_at = now();
        $user->save();

        try {
            Mail::to(config('mail.from.address'))->send(new NewUseVerifyEmail($user));
        } catch (\Exception $e) {
            Log::error('Письмо не отправлено ' . $e);
        }

        return redirect()->route('home')->with('success', trans('trans.your_email_address_has_been_confirmed'));
    }
}
