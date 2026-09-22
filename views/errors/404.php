<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'Error') ?> — Cuentas</title>
    <link href="<?= asset('css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/font-awesome.css') ?>" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <main class="error-page">
        <div class="error-box">
            <div class="error-code">404</div>
            <p class="lead">La página que buscas no existe.</p>
            <a href="<?= url('cuentas') ?>" class="btn btn-primary">
                <i class="fa fa-table"></i> Volver al inicio
            </a>
        </div>
    </main>
</body>
</html>
