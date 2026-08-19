<?php

return [
    'env' => getenv('APP_ENV') ?: 'production',
    //'env' => getenv('APP_ENV') ?: 'development',

    // Dejar vacío para autodetectar según la URL actual
    'base_url' => '',

    'views_path' => dirname(__DIR__) . '/views',

    'timezone' => getenv('TIMEZONE') ?: 'Europe/Madrid',

    // Valoraciones de gastos (mismo formato que el antiguo config.php de CI)
    'nota_gastos' => [
        0 => 'Sin nota',
        1 => 'Bien',
        2 => 'Regular',
        3 => 'Mal',
        4 => 'Excelente',
    ],
];
