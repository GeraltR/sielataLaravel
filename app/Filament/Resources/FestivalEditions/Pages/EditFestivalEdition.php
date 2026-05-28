<?php

namespace App\Filament\Resources\FestivalEditions\Pages;

use App\Filament\Resources\FestivalEditions\FestivalEditionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFestivalEdition extends EditRecord
{
    protected static string $resource = FestivalEditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
