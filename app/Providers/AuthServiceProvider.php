<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\ResetsPasswords;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //cuztomise verify email
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage())
            ->subject('Verify Email Address')
            ->action('Verify Email Address', $url)
            ->view('mail.verify', compact('url'));
        });
        
        //customize fogot pass email ???
        
        // ResetPassword::toMailUsing(function ($notifiable, $token) {
        //     $url = route('password.reset',$token).'?email='.$notifiable->getEmailForPasswordReset();
        //     return (new MailMessage())
        //         ->subject('Password reset')
        //         ->view('mail.password.reset', compact('url'));
        // });
    }
}
