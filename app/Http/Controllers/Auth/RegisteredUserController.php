<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Carbon\Carbon;



class RegisteredUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'imie' => ['required', 'string', 'max:255'],
            'nazwisko' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rokur' => ['required', 'integer', 'between:1900,' . $this->MaxYear()],
            'miasto' => ['required', 'string', 'max:255'],
            'recaptchatoken' => ['required', 'google_captcha'],
        ]);


        $user = Users::create([
            'imie' => $request->imie,
            'nazwisko' => $request->nazwisko,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'miasto' => $request->miasto,
            'rokur' => $request->rokur,
            'klub' => $request->klub,
            'data' => Carbon::now()->toDateTimeString(),
            'admin' => 0
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }

    public function messages()
    {
        return [
            'imie.required' => 'Imię jest wymagane.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field must not exceed 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password field must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'rokur.required' => 'Pole rok urodzenia musi być podane w celu koreślenia klasy wiekowej',
            'rokur.between' => 'Rok urodzenia musi być większy niż 1900 i mniejszy od obecnego',
        ];
    }
}
