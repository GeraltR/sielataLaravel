<?php

namespace App\Filament\Resources\Category\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('symbol')
                    ->label('Symbol')
                    ->required()
                    ->maxLength(6),

                TextInput::make('nazwa')
                    ->label('Nazwa')
                    ->required()
                    ->maxLength(80),

                TextInput::make('klasa')
                    ->label('Klasa')
                    ->required()
                    ->maxLength(1),

                TextInput::make('rok')
                    ->label('Rok')
                    ->required()
                    ->numeric(),

                TextInput::make('grupa')
                    ->label('Grupa')
                    ->required()
                    ->maxLength(15),

                Select::make('idparent')
                    ->label('Kategoria nadrzędna')
                    ->options(fn () => Category::orderBy('nazwa')->pluck('nazwa', 'idkat'))
                    ->searchable()
                    ->nullable()
                    ->default(12),
            ]);
    }
}