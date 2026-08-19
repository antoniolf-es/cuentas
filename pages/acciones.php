<?php

declare(strict_types=1);

$path = Router::normalize(Router::currentPath());
$partes = explode('/', $path);

$controlador = strtolower($partes[0] ?? '');
$accion = strtolower($partes[1] ?? '');

if ($controlador === '' || $accion === '') {
    http_response_code(404);
    require ROOT_PATH . '/pages/404.php';

    return;
}

$clase = ucfirst($controlador) . 'Controller';

if (!class_exists($clase) || !method_exists($clase, $accion)) {
    http_response_code(404);
    require ROOT_PATH . '/pages/404.php';

    return;
}

$controller = new $clase();
$controller->$accion();