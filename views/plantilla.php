<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="author" content="Antonio LF" />
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
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
        <!-- LOGO HEADER END-->
        <section class="menu-section">
            <div class="container">
                <div class="row">
                    <?php
                    if ($pagina === 'Inicio') {
                        $titulo = '<i class="fa fa-table" aria-hidden="true"></i> ' . e($mes_txt ?? '') . ' ' . e($anio ?? '');
                    } elseif ($pagina === 'Anual') {
                        $titulo = '<i class="fas fa-chart-bar" aria-hidden="true"></i> ' . e($pagina) . ' ' . e($anio ?? '');
                    } elseif ($pagina === 'Presupuesto') {
                        $titulo = '<i class="fas fa-calculator" aria-hidden="true"></i> Presupuesto';
                    } elseif ($pagina === 'Global') {
                        $titulo = '<i class="fa fa-globe" aria-hidden="true"></i> ' . e($pagina);
                    } elseif ($pagina === 'Ajustes') {
                        $titulo = '<i class="fas fa-cog" aria-hidden="true"></i> ' . e($pagina);
                    } else {
                        $titulo = '<i class="fa fa-table" aria-hidden="true"></i> ' . e($pagina ?? 'Cuentas');
                    }
                    ?>
                    <div class="col-md-5">
                            <span class="title"><?= $titulo ?></span>
                    </div>

                    <div class="col-md-7">
                        <div class="modern-menu-group float-right">
                            <a href="<?= url('') ?>" class="modern-menu-btn" data-tooltip="Ir al inicio">
                                <i class="fa fa-table"></i>
                                <span>Inicio</span>
                            </a>
                            <a href="<?= url('anual') ?>" class="modern-menu-btn" data-tooltip="Ver resumen anual">
                                <i class="fas fa-chart-bar"></i>
                                <span>Anual</span>
                            </a>
                            <a href="<?= url('globales') ?>" class="modern-menu-btn" data-tooltip="Vista global">
                                <i class="fa fa-globe"></i>
                                <span>Global</span>
                            </a>
                            <a href="<?= url('ajustes') ?>" class="modern-menu-btn" data-tooltip="Configuración">
                                <i class="fas fa-cog"></i>
                                <span>Ajustes</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <?= $content ?>
            </div><!-- #container -->
        </div><!-- #content -->

        <!-- CONTENT-WRAPPER SECTION END-->
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="text-align: center;">
                        Antonio LF <i class="fab fa-creative-commons" title="Creative Commons"></i>  <?= date('Y') ?>  | Version 3.0
                    </div>
                </div>
            </div>
        </div>

        <!-- VAR JS  -->
        <input id="id_eliminar" name="id_eliminar" type="hidden" value="" />
        <input id="id_pagina" name="id_pagina" type="hidden" value="<?= e($pagina ?? '') ?>" />

        <!-- ELIMINAR  -->
        <div id="modal_eliminar" class="modal fade">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-x-20 bg-danger">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" style="color: #fff;">Eliminar</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pd-20">
                        <p class="mg-b-5">¿Realmente deseas eliminar?</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger b_eliminar">Eliminar</button>
                    </div>
                </div>
            </div><!-- modal-dialog -->
        </div><!-- modal -->

    </body>
</html>