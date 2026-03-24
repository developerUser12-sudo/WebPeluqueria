<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        VerifyEmail::toMailUsing(function ($notifiable, $url) {

            return (new MailMessage)
                ->subject('Verifica tu cuenta')
                ->view('emails.verify', [
                    'url' => $url,
                    'user' => $notifiable
                ]);
        });
        ResetPassword::toMailUsing(function ($notifiable, $token) {
        $url = url(route('password.reset', ['token' => $token, 'email' => $notifiable->email], false));

        return (new MailMessage)
            ->subject('Restablece tu contraseña')
            ->view('emails.reset-password', [
                'url' => $url,
                'user' => $notifiable
            ]);
    });
    }
}
