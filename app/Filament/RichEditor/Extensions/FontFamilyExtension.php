<?php

namespace App\Filament\RichEditor\Extensions;

use Tiptap\Core\Mark;

class FontFamilyExtension extends Mark
{
    public static $name = 'fontFamily';

    public function parseHTML()
    {
        return [
            [
                'tag' => 'span',
                'getAttrs' => fn ($DOMNode): bool => in_array('font-family', explode(' ', (string) $DOMNode->getAttribute('class'))),
            ],
        ];
    }

    public function addAttributes()
    {
        return [
            'data-font-family' => [
                'parseHTML' => fn ($DOMNode) => $DOMNode->getAttribute('data-font-family') ?: null,
                'renderHTML' => function ($attributes) {
                    $value = is_array($attributes)
                        ? ($attributes['data-font-family'] ?? null)
                        : ($attributes->{'data-font-family'} ?? null);

                    return [
                        'data-font-family' => $value,
                    ];
                },
            ],
        ];
    }

    public function renderHTML($mark, $HTMLAttributes = [])
    {
        $existingClass = isset($HTMLAttributes['class']) ? (string) $HTMLAttributes['class'] : '';
        $HTMLAttributes['class'] = trim(implode(' ', array_filter(['font-family', $existingClass])));

        $fontFamily = $HTMLAttributes['data-font-family'] ?? null;

        if (filled($fontFamily)) {
            $existingStyle = isset($HTMLAttributes['style']) ? (string) $HTMLAttributes['style'] : '';
            $style = "font-family: {$fontFamily}";
            $HTMLAttributes['style'] = $existingStyle !== '' ? ($style . '; ' . $existingStyle) : $style;
        }

        return [
            'span',
            $HTMLAttributes,
            0,
        ];
    }
}
