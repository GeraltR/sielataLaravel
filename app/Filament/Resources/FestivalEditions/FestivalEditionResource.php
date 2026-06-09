<?php

namespace App\Filament\Resources\FestivalEditions;

use App\Filament\Resources\FestivalEditions\Pages\CreateFestivalEdition;
use App\Filament\Resources\FestivalEditions\Pages\EditFestivalEdition;
use App\Filament\Resources\FestivalEditions\Pages\ListFestivalEditions;
use App\Filament\Resources\FestivalEditions\Schemas\FestivalEditionForm;
use App\Filament\Resources\FestivalEditions\Tables\FestivalEditionsTable;
use App\Models\FestivalEdition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FestivalEditionResource extends Resource
{
    protected static ?string $model = FestivalEdition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Nazwa';

    protected static ?string $pluralModelLabel = 'Edycje Festiwalu';

    public static function form(Schema $schema): Schema
    {
        return FestivalEditionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FestivalEditionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Edycje Festiwalu';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFestivalEditions::route('/'),
            'create' => CreateFestivalEdition::route('/create'),
            'edit' => EditFestivalEdition::route('/{record}/edit'),
        ];
    }

}
