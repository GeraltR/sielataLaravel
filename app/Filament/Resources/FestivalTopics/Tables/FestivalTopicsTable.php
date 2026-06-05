<?php

namespace App\Filament\Resources\FestivalTopics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Models\FestivalEdition;
use Filament\Tables\Enums\FiltersLayout;

class FestivalTopicsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('festival_edition_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('anniversary_value')
                    ->label('Rocznica')
                    ->sortable(),
                TextColumn::make('anniversary_period')
                    ->label('okres'),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('subtitle')
                    ->searchable(),
                ImageColumn::make('image'),
                TextColumn::make('image_position')
                    ->label('Pozycja obrazu'),
                TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('festival_edition_id')
                    ->label('Edycja')
                    ->options(function () {
                        return FestivalEdition::orderBy('rok', 'desc')
                            ->pluck('edition', 'id')
                            ->prepend('Wszystkie', '')
                            ->toArray();
                    })
                    ->native(false),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
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
