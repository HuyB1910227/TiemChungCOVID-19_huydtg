<?php

namespace App;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Auth;


class Patient extends Authenticatable 
{
    use Notifiable;
    protected $guard = 'patient';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'identify_card', 'address', 'phone', 'gender', 'date_of_birth', 'career', 'avatar', 'name', 'email', 'password', 'avatar', 'required_additional_dose'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }
    public function registrationForms () {
        return $this->hasMany(RegistrationForm::class);
    }
    public function vaccinationHistories () {
        return $this->hasMany(VaccinationHistory::class);
    }
    /**
     * Get the verification URL for the given notifiable.
     *
     * @return string
     */
    public function verificationUrl()
    {
        return url(route('patient.verification.verify', [
            'id' => $this->getKey(),
            'hash' => sha1($this->getEmailForVerification()),
        ], false));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $verificationUrl = $this->verificationUrl();
        $this->notify(new VerifyEmail($verificationUrl));
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    

    // public function sendEmailVerificationNotification()
    // {
    //     $url = route('patient.verification.verify', [
    //         'id' => Auth::guard('patient')->id(),
    //         'hash' => sha1(Auth::guard('patient')->user()->getEmailForVerification())
    //     ]);
        
    //     $this->notify(new VerifyEmail($url));
    // }
}
