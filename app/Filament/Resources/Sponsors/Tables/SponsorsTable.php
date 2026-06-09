<?php

namespace App\Filament\Resources\Sponsors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class SponsorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nazwa')
                    ->searchable(),
                ImageColumn::make('logo_image')
                    ->getStateUsing(fn ($record) => $record->logo)
                    ->label('Logo')
                    ->disk('public')
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->logo))
                    ->extraImgAttributes(['style' => 'background-color: white; padding: 6px; border-radius: 6px;',])
                    ->size(80),   
                TextColumn::make('url')
                    ->searchable(),
                TextColumn::make('order')
                    ->label('Kolejność')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
