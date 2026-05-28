<?php

namespace App\Filament\Resources\FestivalEditions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class FestivalEditionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('edition')
                    ->label('Edycja')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Tytuł')
                    ->searchable(),

                TextColumn::make('city')
                    ->label('Miasto')
                    ->sortable(),

                TextColumn::make('rok')
                    ->label('Rok')
                    ->sortable(),

                IconColumn::make('active')
                    ->label('Aktywna')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
