<?php

namespace App\Filament\Resources\Acknowledgements\Pages;

use App\Filament\Resources\Acknowledgements\AcknowledgementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAcknowledgement extends EditRecord
{
    protected static string $resource = AcknowledgementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
