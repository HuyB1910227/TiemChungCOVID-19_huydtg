<?php

namespace App\Http\Controllers\Patient;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Patient;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = 'nguoi-dan/home';
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:patient');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    // protected function guard()
    // {
    //     return auth()->guard('patients');
    // }

    protected function show() {
        return view('patient.verify');
    }

    // protected function verificationUrl($notifiable)
    // {
    //     return route('patient.verification.verify', [
    //         'id' => $notifiable->getKey(),
    //         'hash' => sha1($notifiable->getEmailForVerification()),
    //     ]);
    // }

    // public function resend(Request $request)
    // {
    //     if ($request->user()->hasVerifiedEmail()) {
    //         return redirect()->route('home');
    //     }

    //     $request->user()->sendEmailVerificationNotification();

    //     return back()->with('resent', true);
    // }
    public function resend(Request $request)
        {
            /** @var App\Models\Patient $patient */
      
            $patient = Auth::guard('patient')->user();
            $patient->sendEmailVerificationNotification();
            return redirect()->route('patient.verification.notice')->with('resent', true);
        }

   
}
