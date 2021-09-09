<?php

return [
    'column' => [
        'name' => 'Systémový názov',
        'title' => 'Názov',
        'domain' => 'Doména',
        'localizations' => 'Lokalizácie',
        'default_localization_id' => 'Základná lokalizácia',
        'is_use_default_localization_url_path' => 'Použíť v URL slug základnej lokalizácie',
        'is_error_exception_debug_mode' => 'Debug mód',
    ],
    'field' => [
        'user_group_id' => 'Skupina používateľov',
        'name' => 'Systémový názov',
        'title' => 'Názov',
        'domain' => 'Doména',
        'localizations' => 'Lokalizácie',
        'default_localization_id' => 'Základná lokalizácia',
        'is_use_default_localization_url_path' => 'Použíť v URL slug základnej lokalizácie',
        'is_label_with_name' => 'Štítok - použiť názov',
        'is_label_with_color' => 'Štítok - použiť farbu',
        'is_label_with_flag' => 'Štítok - použiť vlajku',
        'color' => 'Farba štítku',
        'error_not_found_message' => 'Text',
        'error_exception_message' => 'Text',
        'is_error_exception_debug_mode' => 'Debug mód',
        // relations
        'userGroup' => 'Skupina používateľov',
        'frontpageSettings' => 'Nastavenia frontpage',
        'defaultLocalization' => 'Základná lokalizácia',
    ],
    'model' => [
        'title' => [
            'singular' => 'Web',
            'plural' => 'Weby',
        ],
    ],
    'tab' => [
        'frontpage-settings' => 'Frontpage nastavenia',
        'error-settings' => 'Nastavenie chybových hlášok',
    ],
    'text' => [
        'localization-data' => 'Nastavenie lokalizácie',
        'label-data' => 'Nastavenie štítku',
        'error-not-found-data' => 'Nastavenia pre "Error 404 - Stránka nenájdená"',
        'error-exception-data' => 'Nastavenia pre "Error 5xx - Chyby na strane servera"',
    ],
    'token' => [
        'title' => 'Názov',
        'domain' => 'Doména',
    ],
];