<?php

declare(strict_types=1);

/**
 * Cargador de variables de entorno desde un archivo .env
 */
final class Env
{
    private static bool $loaded = false;

    /**
     * Carga las variables del archivo .env en el entorno.
     * No sobrescribe variables ya definidas en el entorno real.
     */
    public static function load(string $path): void
    {
        if (self::$loaded) {
            return;
        }

        if (!is_file($path) || !is_readable($path)) {
            self::$loaded = true;
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            self::$loaded = true;
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignorar comentarios y líneas vacías
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            // Solo procesar líneas con formato CLAVE=valor
            if (!str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);

            $key   = trim($key);
            $value = trim($value);

            // Quitar comillas simples o dobles si las hay
            if (strlen($value) >= 2) {
                $first = $value[0];
                $last  = $value[strlen($value) - 1];

                if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                    $value = substr($value, 1, -1);
                }
            }

            // No sobrescribir variables ya definidas en el entorno real
            if (getenv($key) === false) {
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
            }
        }

        self::$loaded = true;
    }
}