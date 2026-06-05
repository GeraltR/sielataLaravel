<?php

namespace App\Filament\Resources\FestivalEditions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;

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

                TextColumn::make('location')
                    ->label('Lokalizacja')
                    ->placeholder('Hala MCKiS'),

                TextColumn::make('rok')
                    ->label('Rok')
                    ->sortable(),

                IconColumn::make('active')
                    ->label('Aktywna')
                    ->boolean(),
            ])
            ->filters([
                Filter::make('active')
                    ->label('Tylko aktywne')
                    ->toggle()
                    ->default(true)
                    ->modifyQueryUsing(fn(Builder $query) => $query->where('active', true)),
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
