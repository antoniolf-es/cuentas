<?php

declare(strict_types=1);

abstract class Controller
{
    protected function json(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    protected function template(string $view, array $data = []): void
    {
        View::template($view, $data);
    }
}