<?php

use Kirby\Cms\Block;
use Kirby\Cms\File;
use Kirby\Content\Field;

return [
    // Define which fields in which blocks should be resolved
    'files' => [
        'cover-image' => ['image'],
        'image' => ['image'],
    ],

    // Your resolvers
    'resolvers' => [
        'text:text' => function (Field $field, Block $block) {
            return $field->kt()->value();
        },
        'cover-image:subheading' => function (Field $field, Block $block) {
            return $field->kt()->value();
        },
        'team-structure:team' => function (Field $field, Block $block) {
            $structure = $field->toStructure();

            return $structure->map(function ($item) {
                $image = $item->image()->toFile();

                return [
                    'name' => $item->name()->value(),
                    'image' => $image ? [
                        'url' => $image->url(),
                        'width' => $image->width(),
                        'height' => $image->height(),
                        'srcset' => $image->srcset(),
                        'alt' => $image->alt()->value()
                    ] : null,
                    'link' => $item->link()->toPage()?->uri()
                ];
            })->values();
        }
    ],

    // Default resolvers for files
    'defaultResolvers' => [
        'files' => fn(File $image) => [
            'url' => $image->url(),
            'width' => $image->width(),
            'height' => $image->height(),
            'srcset' => $image->srcset(),
            'alt' => $image->alt()->value()
        ]
    ]
];
