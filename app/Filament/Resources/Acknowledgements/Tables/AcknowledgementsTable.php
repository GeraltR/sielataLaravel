<?php

namespace App\Filament\Resources\Acknowledgements\Tables;

use App\Models\Acknowledgement;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class AcknowledgementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('imie')
                    ->label('Imię')
                    ->searchable(),
                TextColumn::make('nazwisko')
                    ->label('Nazwisko')
                    ->searchable(),
                TextColumn::make('nazwa')
                    ->label('Nazwa')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Utworzono')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Zaktualizowano')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('drukuj')
                    ->label('Drukuj')
                    ->icon(Heroicon::OutlinedPrinter)
                    ->url(fn (Acknowledgement $record) => route('acknowledgements.print', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('drukujZaznaczone')
                        ->label('Drukuj zaznaczone')
                        ->icon(Heroicon::OutlinedPrinter)
                        ->url(fn (Collection $records) => route('acknowledgements.print.batch', [
                            'ids' => $records->pluck('id')->implode(','),
                        ]))
                        ->openUrlInNewTab()
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
