<?php

namespace App\Filament\Resources\FestivalTopics\Pages;

use App\Filament\Resources\FestivalTopics\FestivalTopicResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFestivalTopics extends ListRecords
{
    protected static string $resource = FestivalTopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
