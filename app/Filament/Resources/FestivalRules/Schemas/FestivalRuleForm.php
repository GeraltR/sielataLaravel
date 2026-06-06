<?php

namespace App\Filament\Resources\FestivalRules\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\FestivalEdition;

class FestivalRuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('festival_edition_id')
                    ->label('Edycja festiwalu')
                    ->options(
                        FestivalEdition::orderBy('rok', 'desc')
                            ->pluck('edition', 'id')
                    )
                    ->required()
                    ->searchable(),

                TextInput::make('title')
                    ->label('Tytuł regulaminu')
                    ->nullable(),

                RichEditor::make('content')
                    ->label('Treść regulaminu')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'h2',
                        'h3',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'link',
                        'undo',
                        'redo',
                    ]),
            ]);
    }
}
