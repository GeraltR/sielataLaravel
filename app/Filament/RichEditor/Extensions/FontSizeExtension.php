<?php

namespace App\Filament\RichEditor\Extensions;

use Tiptap\Core\Mark;

class FontSizeExtension extends Mark
{
    public static $name = 'fontSize';

    public function parseHTML()
    {
        return [
            [
                'tag' => 'span',
                'getAttrs' => fn ($DOMNode): bool => in_array('font-size', explode(' ', (string) $DOMNode->getAttribute('class'))),
            ],
        ];
    }

    public function addAttributes()
    {
        return [
            'data-font-size' => [
                'parseHTML' => fn ($DOMNode) => $DOMNode->getAttribute('data-font-size') ?: null,
                'renderHTML' => function ($attributes) {
                    $value = is_array($attributes)
                        ? ($attributes['data-font-size'] ?? null)
                        : ($attributes->{'data-font-size'} ?? null);

                    return [
                        'data-font-size' => $value,
                    ];
                },
            ],
        ];
    }

    public function renderHTML($mark, $HTMLAttributes = [])
    {
        $existingClass = isset($HTMLAttributes['class']) ? (string) $HTMLAttributes['class'] : '';
        $HTMLAttributes['class'] = trim(implode(' ', array_filter(['font-size', $existingClass])));

        $fontSize = $HTMLAttributes['data-font-size'] ?? null;

        if (filled($fontSize)) {
            $existingStyle = isset($HTMLAttributes['style']) ? (string) $HTMLAttributes['style'] : '';
            $style = "font-size: {$fontSize}";
            $HTMLAttributes['style'] = $existingStyle !== '' ? ($style . '; ' . $existingStyle) : $style;
        }

        return [
            'span',
            $HTMLAttributes,
            0,
        ];
    }
}
