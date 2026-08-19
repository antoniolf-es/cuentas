<?php

declare(strict_types=1);

class Router
{
    public static function dispatch(string $uri, array $routes): void
    {
        $uri = self::normalize($uri);

        if (isset($routes[$uri])) {
            require ROOT_PATH . '/' . $routes[$uri];
            return;
        }

        // Ruta de acción: {controlador}/{accion} → pages/acciones.php
        $partes = explode('/', $uri);

        if (count($partes) === 2 && $partes[0] !== '' && $partes[1] !== '') {
            require ROOT_PATH . '/pages/acciones.php';
            return;
        }

        http_response_code(404);
        require ROOT_PATH . '/pages/404.php';
    }

    public static function normalize(string $uri): string
    {
        $uri = strtolower(trim($uri, '/'));

        // Compatibilidad con URLs antiguas de CodeIgniter
        $legacy = [
            'inicio'         => '',
            'cuentas/actual' => 'cuentas',
            'cuentas/index'  => 'cuentas',
            'anual/actual'   => 'anual',
            'anual/index'    => 'anual',
        ];

        return $legacy[$uri] ?? $uri;
    }

    public static function currentPath(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        if ($scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        return trim($uri, '/');
    }
}
