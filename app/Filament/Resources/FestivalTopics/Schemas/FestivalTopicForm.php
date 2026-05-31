<?php

namespace App\Filament\Resources\FestivalTopics\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\FestivalEdition;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class FestivalTopicForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Temat festiwalu')
                    ->schema([
                        Select::make('festival_edition_id')
                            ->label('Edycja festiwalu')
                            ->options(
                                FestivalEdition::all()
                                    ->pluck('display_name', 'id')
                            )
                            ->searchable()
                            ->required(),
                        TextInput::make('anniversary_value')
                        ->label('Rocznica'),
                        TextInput::make('anniversary_period')
                        ->label('okres'),
                        TextInput::make('title')
                            ->label('Tytuł')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('subtitle')
                            ->label('Podtytuł')
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Opis')
                            ->rows(5),

                        FileUpload::make('image')
                            ->label('Grafika')
                            ->image()
                            ->directory('festival-topics'),

                        TextInput::make('order')
                            ->label('Kolejność')
                            ->numeric()
                            ->default(0),

                        Toggle::make('active')
                            ->label('Aktywny')
                            ->default(true),
                    ])
            ]);
    }
}
