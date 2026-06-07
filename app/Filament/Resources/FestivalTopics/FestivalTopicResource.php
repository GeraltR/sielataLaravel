<?php

namespace App\Filament\Resources\FestivalTopics;

use App\Filament\Resources\FestivalTopics\Pages\CreateFestivalTopic;
use App\Filament\Resources\FestivalTopics\Pages\EditFestivalTopic;
use App\Filament\Resources\FestivalTopics\Pages\ListFestivalTopics;
use App\Filament\Resources\FestivalTopics\Schemas\FestivalTopicForm;
use App\Filament\Resources\FestivalTopics\Tables\FestivalTopicsTable;
use App\Models\FestivalTopic;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FestivalTopicResource extends Resource
{
    protected static ?string $model = FestivalTopic::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return FestivalTopicForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FestivalTopicsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Tematy edycji';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFestivalTopics::route('/'),
            'create' => CreateFestivalTopic::route('/create'),
            'edit' => EditFestivalTopic::route('/{record}/edit'),
        ];
    }
}
