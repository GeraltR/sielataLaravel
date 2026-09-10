<?php

namespace App\Http\Controllers;

use App\Filament\RichEditor\Plugins\FontRichContentPlugin;
use App\Models\Acknowledgement;
use App\Models\ThankYouTemplate;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AcknowledgementPrintController extends Controller
{
    public function show(Acknowledgement $acknowledgement): View
    {
        abort_unless(auth()->check() && auth()->user()->admin === 15, 403);

        return view('acknowledgements.print', [
            'content' => $this->renderContentFor($acknowledgement, ThankYouTemplate::first()?->content ?? ''),
        ]);
    }

    public function showBatch(Request $request): View
    {
        abort_unless(auth()->check() && auth()->user()->admin === 15, 403);

        $ids = collect(explode(',', (string) $request->query('ids')))
            ->map(fn (string $id) => (int) trim($id))
            ->filter()
            ->unique()
            ->values();

        abort_if($ids->isEmpty(), 404);

        $acknowledgements = Acknowledgement::whereIn('id', $ids)->get()
            ->sortBy(fn (Acknowledgement $acknowledgement) => $ids->search($acknowledgement->id))
            ->values();

        abort_if($acknowledgements->isEmpty(), 404);

        $template = ThankYouTemplate::first()?->content ?? '';

        return view('acknowledgements.print-batch', [
            'contents' => $acknowledgements->map(
                fn (Acknowledgement $acknowledgement) => $this->renderContentFor($acknowledgement, $template),
            ),
        ]);
    }

    private function renderContentFor(Acknowledgement $acknowledgement, string $template): string
    {
        $content = str_ireplace(
            ['[imie]', '[nazwisko]', '[nazwa]'],
            [e($acknowledgement->imie), e($acknowledgement->nazwisko), e($acknowledgement->nazwa)],
            $template
        );

        return RichContentRenderer::make($content)
            ->plugins([FontRichContentPlugin::make()])
            ->toHtml();
    }
}
