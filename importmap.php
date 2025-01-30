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
    'aurora-user-interface' => [
        'version' => '5.3.22',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'aurora-user-interface/dist/css/bootstrap.min.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/js/bootstrap.min.js' => [
        'version' => '5.3.22',
    ],
    'aurora-user-interface/dist/css/colors.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/custom.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/layout.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/card.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/accordion.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/faq.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/forms.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/navigation.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/timeline.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/side-filter.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/editor.css' => [
        'version' => '5.3.22',
        'type' => 'css',
    ],
    'aurora-user-interface/dist/css/snackbar.css' => [
        'version' => '5.3.22',
        'type' => 'css',
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
];
