<?php

namespace App\Filament\Resources\FestivalRules;

use App\Filament\Resources\FestivalRules\Pages\CreateFestivalRule;
use App\Filament\Resources\FestivalRules\Pages\EditFestivalRule;
use App\Filament\Resources\FestivalRules\Pages\ListFestivalRules;
use App\Filament\Resources\FestivalRules\Schemas\FestivalRuleForm;
use App\Filament\Resources\FestivalRules\Tables\FestivalRulesTable;
use App\Models\FestivalRule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FestivalRuleResource extends Resource
{
    protected static ?string $model = FestivalRule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return FestivalRuleForm::configure($schema);
    }



    public static function table(Table $table): Table
    {
        return FestivalRulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Regulamin';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFestivalRules::route('/'),
            'create' => CreateFestivalRule::route('/create'),
            'edit' => EditFestivalRule::route('/{record}/edit'),
        ];
    }
}
