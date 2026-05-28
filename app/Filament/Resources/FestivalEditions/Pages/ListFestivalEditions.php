<?php

namespace App\Filament\Resources\FestivalEditions\Pages;

use App\Filament\Resources\FestivalEditions\FestivalEditionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFestivalEditions extends ListRecords
{
    protected static string $resource = FestivalEditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
