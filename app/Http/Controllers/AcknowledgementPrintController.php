<?php

namespace App\Http\Controllers;

use App\Filament\RichEditor\Plugins\FontRichContentPlugin;
use App\Models\Acknowledgement;
use App\Models\ThankYouTemplate;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Contracts\View\View;

class AcknowledgementPrintController extends Controller
{
    public function show(Acknowledgement $acknowledgement): View
    {
        abort_unless(auth()->check() && auth()->user()->admin === 15, 403);

        $content = ThankYouTemplate::first()?->content ?? '';

        $content = str_ireplace(
            ['[imie]', '[nazwisko]', '[nazwa]'],
            [e($acknowledgement->imie), e($acknowledgement->nazwisko), e($acknowledgement->nazwa)],
            $content
        );

        $content = RichContentRenderer::make($content)
            ->plugins([FontRichContentPlugin::make()])
            ->toHtml();

        return view('acknowledgements.print', [
            'content' => $content,
        ]);
    }
}
