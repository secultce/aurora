<?php

declare(strict_types=1);

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'mapaculturaldesign' => [
        'version' => '5.3.6',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'mapaculturaldesign/dist/css/bootstrap.min.css' => [
        'version' => '5.3.6',
        'type' => 'css',
    ],
    'mapaculturaldesign/dist/css/custom.css' => [
        'version' => '5.3.6',
        'type' => 'css',
    ],
];
