<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
