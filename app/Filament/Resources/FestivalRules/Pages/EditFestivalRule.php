<?php

namespace App\Filament\Resources\FestivalRules\Pages;

use App\Filament\Resources\FestivalRules\FestivalRuleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFestivalRule extends EditRecord
{
    protected static string $resource = FestivalRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
