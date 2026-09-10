<?php

namespace App\Http\Controllers;

use App\Models\Acknowledgement;
use App\Models\ThankYouTemplate;
use Illuminate\Contracts\View\View;

class AcknowledgementPrintController extends Controller
{
    public function show(Acknowledgement $acknowledgement): View
    {
        abort_unless(auth()->check() && auth()->user()->admin === 15, 403);

        $content = ThankYouTemplate::first()?->content ?? '';

        $content = str_ireplace(
            ['[imie]', '[nazwisko]', '[nazwa]'],
            [$acknowledgement->imie, $acknowledgement->nazwisko, $acknowledgement->nazwa],
            $content
        );

        return view('acknowledgements.print', [
            'content' => $content,
        ]);
    }
}
