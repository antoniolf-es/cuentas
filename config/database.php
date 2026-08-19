<?php

return [
    'host'     => getenv('DB_HOST'),
    'dbname'   => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset'  => getenv('DB_CHARSET') ?: 'utf8mb4',
];


