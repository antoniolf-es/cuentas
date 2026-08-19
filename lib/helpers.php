<?php

declare(strict_types=1);

function url(string $path = ''): string
{
    $base = rtrim(BASE_URL, '/');

    if ($path === '') {
        return $base . '/';
    }

    return $base . '/' . ltrim($path, '/');
}

function redirect(string $path, int $code = 302): never
{
    header('Location: ' . url($path), true, $code);
    exit;
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function fecha_esp(string $fecha): string
{
    $partes = explode('-', $fecha);

    if (count($partes) !== 3) {
        return $fecha;
    }

    return $partes[2] . '/' . $partes[1] . '/' . $partes[0];
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function post(string $key, mixed $default = null): mixed
{
    return $_POST[$key] ?? $default;
}

function get(string $key, mixed $default = null): mixed
{
    return $_GET[$key] ?? $default;
}

function cifrar(string $pwd): string
{
    $contrasenia = 'alf';

    return sha1($pwd . $contrasenia);
}

function config_item(string $key, mixed $default = null): mixed
{
    static $config = null;

    if ($config === null) {
        $config = require ROOT_PATH . '/config/app.php';
    }

    return $config[$key] ?? $default;
}

function flash_set(string $key, mixed $value): void
{
    Session::set($key, $value);
}

function flash_get(string $key): mixed
{
    $value = Session::get($key);
    Session::remove($key);

    return $value;
}

function mes_nombre(int $mes): string
{
    $meses = [
        1  => 'Enero',
        2  => 'Febrero',
        3  => 'Marzo',
        4  => 'Abril',
        5  => 'Mayo',
        6  => 'Junio',
        7  => 'Julio',
        8  => 'Agosto',
        9  => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];

    return $meses[$mes] ?? '';
}

function detect_base_url(): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));

    if ($script === '/') {
        $script = '';
    }

    return $scheme . '://' . $host . $script;
}
