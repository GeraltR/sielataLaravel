<?php

namespace App\Filament\Resources\FestivalRules\Pages;

use App\Filament\Resources\FestivalRules\FestivalRuleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFestivalRules extends ListRecords
{
    protected static string $resource = FestivalRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
