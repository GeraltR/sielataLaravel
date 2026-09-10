<?php

namespace App\Filament\Resources\ThankYouTemplates\Pages;

use App\Filament\Resources\ThankYouTemplates\ThankYouTemplateResource;
use App\Models\ThankYouTemplate;
use Filament\Resources\Pages\ListRecords;

class ListThankYouTemplates extends ListRecords
{
    protected static string $resource = ThankYouTemplateResource::class;

    public function mount(): void
    {
        $template = ThankYouTemplate::first() ?? ThankYouTemplate::create();

        $this->redirect(ThankYouTemplateResource::getUrl('edit', ['record' => $template]));
    }
}
