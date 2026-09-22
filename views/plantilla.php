<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="Antonio LF" />
        <title>Cuentas</title>

        <link href="<?= asset('css/bootstrap.css') ?>" rel="stylesheet" />
        <link href="<?= asset('css/bootstrap-tooltip-custom-class.min.css') ?>" rel="stylesheet" />
        <link href="<?= asset('css/font-awesome.css') ?>" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>
        <link href="<?= asset('css/style.css') ?>" rel="stylesheet" />
        <link rel="Shortcut Icon" href="<?= asset('img/favicon.png') ?>">

        <!-- JS  -->
        <script src="<?= asset('js/jquery.js') ?>"></script>
        <script src="<?= asset('js/popper.min.js') ?>"></script>
        <script src="<?= asset('js/bootstrap.js') ?>"></script>
        <script src="<?= asset('js/bootstrap-tooltip-custom-class.js') ?>"></script>
        <script src="<?= asset('js/common.js') ?>"></script>
    </head>
    <body>
        <?php
        if ($pagina === 'Inicio') {
            $titulo_icono = 'fa fa-table';
            $titulo_txt = e($mes_txt ?? '') . ' ' . e($anio ?? '');
        } elseif ($pagina === 'Anual') {
            $titulo_icono = 'fas fa-chart-bar';
            $titulo_txt = e($pagina) . ' ' . e($anio ?? '');
        } elseif ($pagina === 'Presupuesto') {
            $titulo_icono = 'fas fa-calculator';
            $titulo_txt = 'Presupuesto';
        } elseif ($pagina === 'Global') {
            $titulo_icono = 'fa fa-globe';
            $titulo_txt = e($pagina);
        } elseif ($pagina === 'Ajustes') {
            $titulo_icono = 'fas fa-cog';
            $titulo_txt = e($pagina);
        } elseif ($pagina === 'Gastos') {
            $titulo_icono = 'fa fa-columns';
            $titulo_txt = 'Informe de gastos';
        } else {
            $titulo_icono = 'fa fa-table';
            $titulo_txt = e($pagina ?? 'Cuentas');
        }

        $es_inicio = ($pagina === 'Inicio');
        $es_anual = in_array($pagina, ['Anual', 'Presupuesto'], true);
        $es_global = ($pagina === 'Global');
        $es_ajustes = ($pagina === 'Ajustes');
        ?>
        <header class="topbar">
            <div class="container">
                <div class="topbar-inner">
                    <a href="<?= url('') ?>" class="topbar-brand">
                        <span class="topbar-brand-icon"><i class="<?= $titulo_icono ?>"></i></span>
                        <span class="topbar-title"> <?= $titulo_txt ?></span>
                    </a>
                    <nav class="topbar-nav">
                        <a href="<?= url('') ?>" class="topbar-link <?= $es_inicio ? 'active' : '' ?>">
                            <i class="fa fa-table"></i>
                            <span>Inicio</span>
                        </a>
                        <a href="<?= url('anual') ?>" class="topbar-link <?= $es_anual ? 'active' : '' ?>">
                            <i class="fas fa-chart-bar"></i>
                            <span>Anual</span>
                        </a>
                        <a href="<?= url('globales') ?>" class="topbar-link <?= $es_global ? 'active' : '' ?>">
                            <i class="fa fa-globe"></i>
                            <span>Global</span>
                        </a>
                        <a href="<?= url('ajustes') ?>" class="topbar-link <?= $es_ajustes ? 'active' : '' ?>">
                            <i class="fas fa-cog"></i>
                            <span>Ajustes</span>
                        </a>
                    </nav>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <div class="container">
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container text-center">
                Antonio <span style="color: var(--primary);">LF</span> <i class="fab fa-creative-commons" title="Creative Commons"></i> <?= date('Y') ?> · Versión 3.5
            </div>
        </footer>

        <input id="id_eliminar" name="id_eliminar" type="hidden" value="" />
        <input id="id_pagina" name="id_pagina" type="hidden" value="<?= e($pagina ?? '') ?>" />

        <div id="modal_eliminar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header mh-danger">
                        <h5 class="modal-title">Eliminar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-ask">¿Realmente deseas eliminar?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger b_eliminar">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
