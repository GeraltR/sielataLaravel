<?php

namespace App\Filament\Resources\Category\Tables;

use Filament\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Collection;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\FiltersLayout;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('symbol')
                    ->label('Symbol')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nazwa')
                    ->label('Nazwa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('klasa')
                    ->label('Klasa')
                    ->sortable(),

                TextColumn::make('rok')
                    ->label('Rok')
                    ->sortable(),

                TextColumn::make('grupa')
                    ->label('Grupa')
                    ->sortable(),

                TextColumn::make('parent.nazwa')
                    ->label('Nadrzędna')
                    ->placeholder('—'),
            ])
            ->defaultSort('nazwa')
            ->recordActions([
                EditAction::make(),
            ])
            ->filters(([
                Filter::make('nie_zawiera')
                    ->label('Nie zawiera')
                    ->form([
                        TextInput::make('fraza')
                            ->label('Wyklucz frazę')
                            ->maxLength(16),
                        TextInput::make('rok')
                            ->label('Wyklucz rok')
                            ->numeric()
                            ->maxLength(4),

                    ])
                    ->columns(2)
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query
                            ->when(
                                $data['fraza'],
                                fn(Builder $query) => $query
                                    ->where('symbol', 'not like', '%' . $data['fraza'] . '%')
                            )
                            ->when(
                                $data['rok'],
                                fn(Builder $query) => $query
                                    ->where('rok', '!=', $data['rok'])
                            )
                    )
            ]))
            ->filtersFormColumns(2)
            ->filtersLayout(FiltersLayout::AboveContent)
            ->deferFilters(false)
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('zmien_rok')
                        ->label('Zmień rok')
                        ->form([
                            TextInput::make('rok')
                                ->label('Nowy rok')
                                ->required()
                                ->numeric(),
                        ])
                        ->action(
                            fn(Collection $records, array $data) =>
                            $records->each->update(['rok' => $data['rok']])
                        ),
                ])
            ]);
    }
}
