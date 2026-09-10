<?php

namespace App\Filament\Resources\Acknowledgements\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AcknowledgementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('imie')
                    ->label('Imię'),
                TextInput::make('nazwisko')
                    ->label('Nazwisko'),
                TextInput::make('nazwa')
                    ->label('Nazwa'),
            ]);
    }
}
