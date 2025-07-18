<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        Validator::extend('google_captcha', function ($attribute, $value, $parameters, $validator) {

            $http = Http::asForm()->post(config('google_captcha.gc_verification_url'), [
                'secret' => config('google_captcha.secret_key'),
                'response' => $value,
            ]);

            if (!$http->object()->success) {

                $errorMessage = null;
                collect($http->object()->{"error-codes"})->each(function ($item) use (&$errorMessage) {
                    $errorMessage .= config('google_captcha.error_codes')[$item];
                });

                $validator->addReplacer(
                    'google_captcha',
                    function ($message, $attribute, $rule, $parameters) use ($errorMessage) {
                        return \str_replace(':message', $errorMessage, $message);
                    }
                );
            }

            return $http->object()->success;
        }, ":message");
    }
}
