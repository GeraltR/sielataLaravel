<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use App\Models\Sponsor;

class SponsorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sponsor')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nazwa')
                            ->required()
                            ->maxLength(150),

                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('sponsors')
                            ->imageEditor(),
                        TextInput::make('url')
                            ->label('Adres strony')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('order')
                            ->label('Kolejność')
                            ->numeric()
                            ->default(fn () => (Sponsor::max('order') ?? 0) + 1),

                        Toggle::make('active')
                            ->label('Aktywny')
                            ->default(true),
                    ])
            ]);
    }
}
