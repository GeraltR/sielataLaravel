<?php

namespace App\Filament\Resources\Category;

use App\Filament\Resources\Category\Pages\CreateCategory;
use App\Filament\Resources\Category\Pages\EditCategory;
use App\Filament\Resources\Category\Pages\ListCategories;
use App\Filament\Resources\Category\Schemas\CategoryForm;
use App\Filament\Resources\Category\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'nazwa';

    protected static ?string $pluralModelLabel = 'Kategorie';

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getNavigationLabel(): string
    {
        return 'Kategorie';
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit'   => EditCategory::route('/{record}/edit'),
        ];
    }
}