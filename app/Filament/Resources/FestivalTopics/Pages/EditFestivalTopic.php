<?php

namespace App\Filament\Resources\FestivalTopics\Pages;

use App\Filament\Resources\FestivalTopics\FestivalTopicResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFestivalTopic extends EditRecord
{
    protected static string $resource = FestivalTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
