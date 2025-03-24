<?php

declare(strict_types=1);

return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'register' => [
        'path' => './assets/js/authentication/user/register.js',
        'entrypoint' => true,
    ],
    'opportunity-create' => [
        'path' => './assets/js/opportunity/create.js',
        'entrypoint' => true,
    ],
    '@symfony/ux-translator' => [
        'path' => './vendor/symfony/ux-translator/assets/dist/translator_controller.js',
    ],
    '@app/translations' => [
        'path' => './var/translations/index.js',
    ],
    '@app/translations/configuration' => [
        'path' => './var/translations/configuration.js',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'intl-messageformat' => [
        'version' => '10.7.14',
    ],
    'tslib' => [
        'version' => '2.8.1',
    ],
    '@formatjs/fast-memoize' => [
        'version' => '2.2.6',
    ],
    '@formatjs/icu-messageformat-parser' => [
        'version' => '2.9.8',
    ],
    '@formatjs/icu-skeleton-parser' => [
        'version' => '1.8.12',
    ],
    '@iconify/iconify' => [
        'version' => '3.1.1',
    ],
    'tom-select' => [
        'version' => '2.4.3',
    ],
    '@orchidjs/sifter' => [
        'version' => '1.1.0',
    ],
    '@orchidjs/unicode-variants' => [
        'version' => '1.1.2',
    ],
    'tom-select/dist/css/tom-select.default.min.css' => [
        'version' => '2.4.3',
        'type' => 'css',
    ],
];
