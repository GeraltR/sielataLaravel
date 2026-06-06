<?php

namespace App\Filament\Resources\FestivalRules\Pages;

use App\Filament\Resources\FestivalRules\FestivalRuleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFestivalRule extends ViewRecord
{
    protected static string $resource = FestivalRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
