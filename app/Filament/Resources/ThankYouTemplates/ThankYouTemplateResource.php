<?php

namespace App\Filament\Resources\ThankYouTemplates;

use App\Filament\Resources\ThankYouTemplates\Pages\EditThankYouTemplate;
use App\Filament\Resources\ThankYouTemplates\Pages\ListThankYouTemplates;
use App\Filament\Resources\ThankYouTemplates\Schemas\ThankYouTemplateForm;
use App\Models\ThankYouTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ThankYouTemplateResource extends Resource
{
    protected static ?string $model = ThankYouTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $modelLabel = 'Szablon podziękowań';

    protected static ?string $pluralModelLabel = 'Szablon podziękowań';

    public static function getNavigationLabel(): string
    {
        return 'Szablon podziękowań';
    }

    public static function form(Schema $schema): Schema
    {
        return ThankYouTemplateForm::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListThankYouTemplates::route('/'),
            'edit' => EditThankYouTemplate::route('/{record}/edit'),
        ];
    }
}
