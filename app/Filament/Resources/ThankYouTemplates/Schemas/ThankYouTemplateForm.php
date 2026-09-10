<?php

namespace App\Filament\Resources\ThankYouTemplates\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class ThankYouTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('content')
                    ->label('Treść dokumentu')
                    ->helperText('Dostępne znaczniki, podmieniane danymi z wiersza przy druku: [imie], [nazwisko], [nazwa]')
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
                        'alignStart',
                        'alignCenter',
                        'alignEnd',
                        'textColorPicker',
                        'undo',
                        'redo',
                    ]),
            ]);
    }
}
