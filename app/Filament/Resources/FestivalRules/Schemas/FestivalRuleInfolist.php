<?php

namespace App\Filament\Resources\FestivalRules\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FestivalRuleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('festival_edition_id')
                    ->numeric(),
                TextEntry::make('title'),
                TextEntry::make('anniversary_value')
                    ->numeric(),
                TextEntry::make('anniversary_period'),
                TextEntry::make('subtitle')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->placeholder('-'),
                ImageEntry::make('image_position')
                    ->placeholder('-'),
                TextEntry::make('fade_width'),
                TextEntry::make('order')
                    ->numeric(),
                IconEntry::make('active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
