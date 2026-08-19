<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'Error') ?> — Cuentas</title>
    <link href="<?= asset('css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1>404</h1>
        <p class="lead">La página que buscas no existe.</p>
        <a href="<?= url('cuentas') ?>" class="btn btn-primary">Volver al inicio</a>
    </div>
</body>
</html>