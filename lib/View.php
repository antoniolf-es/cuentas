<?php

declare(strict_types=1);

class View
{
    private static string $path = '';

    public static function init(string $path): void
    {
        self::$path = rtrim($path, '/');
    }

    public static function render(string $view, array $data = [], bool $return = false): ?string
    {
        $file = self::$path . '/' . $view . '.php';

        if (!is_file($file)) {
            throw new RuntimeException("Vista no encontrada: {$view}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $file;
        $content = ob_get_clean();

        if ($return) {
            return $content;
        }

        echo $content;

        return null;
    }

    public static function template(string $view, array $data = []): void
    {
        $data['template'] = $view;
        $data['content']  = self::render($view, $data, true);
        self::render('plantilla', $data);
    }
}
