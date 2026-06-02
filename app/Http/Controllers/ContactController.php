<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email',
            'phone'           => 'nullable|string|max:50',
            'subject'         => 'nullable|string|max:255',
            'message'         => 'required|string',
            'recaptcha_token' => 'required|string',
        ]);

        // Weryfikacja reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret'),
            'response' => $request->recaptcha_token,
        ]);

        $captcha = $response->json();

        if (!$captcha['success'] || $captcha['score'] < 0.5) {
            return response()->json(['message' => 'Weryfikacja reCAPTCHA nie powiodła się.'], 422);
        }

        Mail::to(config('mail.from.address'))->send(new ContactMail($request->only(
            'name', 'email', 'phone', 'subject', 'message'
        )));

        return response()->json(['ok' => true]);
    }
}