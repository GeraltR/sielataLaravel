<?php

namespace App\Filament\Resources\ThankYouTemplates\Pages;

use App\Filament\Resources\ThankYouTemplates\ThankYouTemplateResource;
use Filament\Resources\Pages\EditRecord;

class EditThankYouTemplate extends EditRecord
{
    protected static string $resource = ThankYouTemplateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
