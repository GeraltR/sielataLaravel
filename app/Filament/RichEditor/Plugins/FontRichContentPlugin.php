<?php

namespace App\Filament\RichEditor\Plugins;

use App\Filament\RichEditor\Extensions\FontFamilyExtension;
use App\Filament\RichEditor\Extensions\FontSizeExtension;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\EditorCommand;
use Filament\Forms\Components\RichEditor\Plugins\Contracts\RichContentPlugin;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Icons\Heroicon;

class FontRichContentPlugin implements RichContentPlugin
{
    /**
     * @var array<string, string>
     */
    protected static array $fontFamilies = [
        'Campton, sans-serif' => 'Campton (nagłówki SieLata)',
        'Lato, sans-serif' => 'Lato (tekst SieLata)',
        'Arial, sans-serif' => 'Arial',
        'Georgia, serif' => 'Georgia',
        '"Times New Roman", serif' => 'Times New Roman',
        '"Courier New", monospace' => 'Courier New',
        'Verdana, sans-serif' => 'Verdana',
    ];

    /**
     * @var array<string, string>
     */
    protected static array $fontSizes = [
        '12px' => '12',
        '14px' => '14',
        '16px' => '16',
        '18px' => '18',
        '20px' => '20',
        '24px' => '24',
        '28px' => '28',
        '32px' => '32',
    ];

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'font';
    }

    /**
     * @return array<object>
     */
    public function getTipTapPhpExtensions(): array
    {
        return [
            app(FontFamilyExtension::class),
            app(FontSizeExtension::class),
        ];
    }

    /**
     * @return array<string>
     */
    public function getTipTapJsExtensions(): array
    {
        return [
            FilamentAsset::getScriptSrc('rich-content-plugins/font-family'),
            FilamentAsset::getScriptSrc('rich-content-plugins/font-size'),
        ];
    }

    /**
     * @return array<RichEditorTool>
     */
    public function getEditorTools(): array
    {
        return [
            RichEditorTool::make('fontFamily')
                ->label('Czcionka')
                ->icon(Heroicon::OutlinedLanguage)
                ->action(arguments: '{ fontFamily: $getEditor()?.getAttributes(\'fontFamily\')?.[\'data-font-family\'] ?? null }'),
            RichEditorTool::make('fontSize')
                ->label('Rozmiar czcionki')
                ->icon(Heroicon::OutlinedArrowsUpDown)
                ->action(arguments: '{ fontSize: $getEditor()?.getAttributes(\'fontSize\')?.[\'data-font-size\'] ?? null }'),
        ];
    }

    /**
     * @return array<Action>
     */
    public function getEditorActions(): array
    {
        return [
            Action::make('fontFamily')
                ->modalWidth(Width::Small)
                ->modalHeading('Czcionka')
                ->fillForm(fn (array $arguments): array => [
                    'fontFamily' => $arguments['fontFamily'] ?? null,
                ])
                ->schema([
                    Select::make('fontFamily')
                        ->label('Czcionka')
                        ->options(static::$fontFamilies)
                        ->native(false)
                        ->placeholder('Domyślna'),
                ])
                ->action(function (array $arguments, array $data, RichEditor $component): void {
                    $component->runCommands(
                        [
                            EditorCommand::make('setFontFamily', arguments: [[
                                'fontFamily' => $data['fontFamily'] ?? null,
                            ]]),
                        ],
                        editorSelection: $arguments['editorSelection'] ?? null,
                    );
                }),
            Action::make('fontSize')
                ->modalWidth(Width::Small)
                ->modalHeading('Rozmiar czcionki')
                ->fillForm(fn (array $arguments): array => [
                    'fontSize' => $arguments['fontSize'] ?? null,
                ])
                ->schema([
                    Select::make('fontSize')
                        ->label('Rozmiar czcionki')
                        ->options(static::$fontSizes)
                        ->native(false)
                        ->placeholder('Domyślny'),
                ])
                ->action(function (array $arguments, array $data, RichEditor $component): void {
                    $component->runCommands(
                        [
                            EditorCommand::make('setFontSize', arguments: [[
                                'fontSize' => $data['fontSize'] ?? null,
                            ]]),
                        ],
                        editorSelection: $arguments['editorSelection'] ?? null,
                    );
                }),
        ];
    }
}
