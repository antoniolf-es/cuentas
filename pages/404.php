<?php

declare(strict_types=1);

http_response_code(404);

View::render('errors/404', [
    'titulo' => 'Página no encontrada',
]);
