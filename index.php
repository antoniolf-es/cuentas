<?php

declare(strict_types=1);

require __DIR__ . '/lib/bootstrap.php';

$routes = require ROOT_PATH . '/config/routes.php';
$path   = Router::currentPath();

Router::dispatch($path, $routes);
