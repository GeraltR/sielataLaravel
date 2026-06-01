<?php

namespace App\Filament\Resources\FestivalEditions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class FestivalEditionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Podstawowe informacje')
                    ->schema([
                        TextInput::make('edition')
                            ->label('Numer edycji')
                            ->required()
                            ->numeric(),

                        TextInput::make('title')
                            ->label('Tytuł')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('city')
                            ->label('Miasto')
                            ->required()
                            ->maxLength(50),
                            
                        TextInput::make('location')
                            ->label('Lokalizacja'),

                        TextInput::make('rok')
                            ->label('Rok')
                            ->required()
                            ->numeric(),

                        Toggle::make('active')
                            ->label('Aktywna edycja'),
                    ]),

                Section::make('Rejestracja')
                    ->schema([
                        DateTimePicker::make('registration_start')
                            ->label('Początek rejestracji')
                            ->native(false)
                            ->displayFormat('d.m.Y H:i')
                            ->required(),

                        DateTimePicker::make('registration_end')
                            ->label('Koniec rejestracji')
                            ->native(false)
                            ->displayFormat('d.m.Y H:i')
                            ->required(),
                    ]),

                Section::make('Festiwal')
                    ->schema([
                        DateTimePicker::make('festival_start')
                            ->label('Początek festiwalu')
                            ->native(false)
                            ->displayFormat('d.m.Y H:i')
                            ->required(),

                        DateTimePicker::make('festival_end')
                            ->label('Koniec festiwalu')
                            ->native(false)
                            ->displayFormat('d.m.Y H:i')
                            ->required(),

                        DateTimePicker::make('results_at')
                            ->label('Ogłoszenie wyników')
                            ->native(false)
                            ->displayFormat('d.m.Y H:i')
                            ->required(),
                    ]),
            ]);
    }
}
