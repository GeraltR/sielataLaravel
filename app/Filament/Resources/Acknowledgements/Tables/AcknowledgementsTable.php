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
use Illuminate\Support\Js;

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
                        // Uses the browser's own `selectedRecords` set (Alpine.js), evaluated
                        // at click time, instead of a PHP-rendered `url()`. Filament tracks
                        // table row selection client-side only (no request per checkbox), so
                        // a `url()` closure gets baked in at page load with an empty selection
                        // and never updates — this stayed correct regardless of what's checked.
                        //
                        // Only single quotes are used in the JS below: Filament embeds this
                        // string raw into the `x-on:click="..."` HTML attribute without
                        // HTML-escaping it, so a literal `"` here closes the attribute early
                        // and truncates the handler (confirmed by inspecting the rendered
                        // attribute value in a real browser).
                        ->alpineClickHandler(
                            'window.open('
                                . Js::from(route('acknowledgements.print.batch'))
                                . " + '?ids=' + [...selectedRecords].join(','), '_blank')"
                        ),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
