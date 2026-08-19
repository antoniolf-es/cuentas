<?php

declare(strict_types=1);

$controller = new AnualController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->presupuesto_nuevo();
} else {
    $controller->presupuesto();
}