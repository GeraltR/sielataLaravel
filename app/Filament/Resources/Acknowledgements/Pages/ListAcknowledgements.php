<?php

namespace App\Filament\Resources\Acknowledgements\Pages;

use App\Filament\Resources\Acknowledgements\AcknowledgementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAcknowledgements extends ListRecords
{
    protected static string $resource = AcknowledgementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
