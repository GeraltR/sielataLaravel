<?php

return [
    'site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
    'secret_key' => env('GOOGLE_RECHAPTCHA_SECRET_KEY'),
    'gc_verification_url' => env('GOOGLE_RECAPTCHA_URL'),
    'error_codes' => [
        "missing-input-secret" => "Zgubiony sekretny parametr dla reCaptcha",
        "invalid-input-secret" => "Sekretny parameter jest błędny.",
        "missing-input-response" => "Parametr odpowiedzi zaginął.",
        "invalid-input-response" => "Parametr odpowiedzi jest błędny.",
        "bad-request" => "Błędna odpowiedź",
        "timeout-or-duplicate" => "Upłynął limit czasu oczekiwania na odpowiedź",
    ],

];
