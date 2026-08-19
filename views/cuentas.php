<!-- DATETIME -->
<link href="<?= url('assets/css/datetimepicker.css') ?>" rel="stylesheet" />
<link href="<?= url('assets/css/jquery-ui.css') ?>" rel="stylesheet" />

<script src="<?= url('assets/js/moment.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.es.js') ?>"></script>
<script src="<?= url('assets/js/jquery-ui.js') ?>"></script>

<!-- GRAFICOS -->
<script src="<?= url('assets/js/chart.js') ?>"></script>


<div class="row">

    <div class="col-md-8">

        <!-- INGRESOS -->
        <div class="row">

            <h1 class="page-head-line-ingresos">Ingresos
                <a href="#" class="btn btn-success" style="float: right; margin-left: 10px; display: none;" id="b_ingresos_eliminar" title="Eliminar ingreso">
                    <i class="far fa-trash-alt"></i>
                </a>
                <a href="#" class="btn btn-success" style="float: right; margin-left: 10px; display: none;" id="b_ingresos_editar" title="Editar ingreso">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="#" class="btn btn-success" style="float: right;" id="b_ingresos_nuevo" title="Nuevo ingreso">
                    <i class="fa fa-plus-circle"></i>
                </a>
            </h1>

            <table id="ingresos" class="table ingresos" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 20%;">Fecha</th>
                        <th style="width: 60%;">Concepto</th>
                        <th style="width: 20%; text-align: right">Cantidad</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($ingresos_arr as $value) { ?>
                        <tr class="ingresos-clickable" id="ingresos_<?= $value['id'] ?>">
                            <td><?= e($value['fecha']) ?></td>
                            <td>
                                <?= e($value['concepto']) ?>
                                <?php if ($value['comentario'] != '') {  ?>
                                    <span class="custom_tooltip"
                                        data-toggle="tooltip" data-placement="right" data-custom-class="tooltip-primary" data-html="true" data-original-title="<?= e($value['comentario']) ?>">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                <?php } ?>
                            </td>

                            <td style="text-align: right;"><?= e((string) $value['cantidad']) ?> €</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <thead>
                    <tr>
                        <th colspan="3" style="text-align: right"><?= e((string) $total_ingresos) ?> €</th>
                    </tr>
                </thead>
            </table>

        </div>

        <!-- GASTOS -->
        <?php
        // aviso este mes
        $aviso_este = "";
        if (count($rec_mes) > 0) {
            $aviso_este = "Este mes se cargan:";
            foreach ($rec_mes as $fila) {
                $aviso_este .= "<br> - " . $fila->descripcion . " de: <b>" . $fila->cantidad . "€</b>";
            }
        }

        // aviso proximo mes
        $aviso_sig = "";
        if (count($rec_mes_sig) > 0) {
            $aviso_sig = "El proximo mes se cargan:";
            foreach ($rec_mes_sig as $fila) {
                $aviso_sig .= "<br> - " . $fila->descripcion . " de: <b>" . $fila->cantidad . "€</b>";
            }
        }
        ?>

        <div class="row">

            <h1 class="page-head-line-gastos">Gastos
                <?php if (count($rec_mes) > 0) { ?>
                    <span class="custom_tooltip"
                        data-toggle="tooltip" data-placement="right" data-custom-class="tooltip-danger" data-html="true" data-original-title="<?= $aviso_este ?>">
                        <i class="fa fa-exclamation-triangle" style="color: #DC3545; cursor: pointer;"></i>
                    </span>
                <?php } ?>
                <?php if (count($rec_mes_sig) > 0) {  ?>
                    <span class="custom_tooltip"
                        data-toggle="tooltip" data-placement="right" data-custom-class="tooltip-warning" data-html="true" data-original-title="<?= $aviso_sig ?>">
                        <i class="fa fa-exclamation-triangle" style="color: #FFC107; cursor: pointer; margin-left: 5px;"></i>
                    </span>
                <?php } ?>
                <a href="#" class="btn btn-danger" style="float: right; margin-left: 10px; display: none;" id="b_gastos_eliminar" title="Eliminar gasto">
                    <i class="far fa-trash-alt"></i>
                </a>
                <a href="#" class="btn btn-danger" style="float: right; margin-left: 10px; display: none;" id="b_gastos_editar" title="Editar gasto">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="#" class="btn btn-danger" style="float: right; margin-left: 10px;" id="b_gastos_nuevo" title="Nuevo gasto">
                    <i class="fa fa-plus-circle"></i>
                </a>
                <a href="#" class="btn btn-danger" style="float: right; margin-left: 10px;" id="b_unir" title="Unir gastos">
                    <i class="fas fa-biohazard"></i>
                </a>
            </h1>


            <table id="gastos" class="table gastos" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 20%;">Fecha</th>
                        <th style="width: 50%;">Concepto</th>
                        <th style="width: 20%; text-align: right">Cantidad</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($gastos_arr as $value) { ?>
                        <tr class="gastos-clickable" id="gastos_<?= $value['id'] ?>">
                            <td><span><?= e($value['fecha']) ?></span></td>
                            <td>
                                <?= e($value['concepto']) ?>
                                <?php if ($value['comentario'] != '') {  ?>
                                    <span class="custom_tooltip"
                                        data-toggle="tooltip" data-placement="right" data-custom-class="tooltip-primary" data-html="true" data-original-title="<?= e($value['comentario']) ?>">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                <?php } ?>
                                <?php
                                $icono = $a_icono[$value['categoria']] ?? '';
                                $nota = '';
                                switch ($value['nota']) {
                                    case 1:
                                        $nota = '#38A657';
                                        break;
                                    case 2:
                                        $nota = '#FFC107';
                                        break;
                                    case 3:
                                        $nota = '#E25F6B';
                                        break;
                                    case 4:
                                        $nota = '#5afc03';
                                        break;
                                    default:
                                        $nota = "";
                                        break;
                                }
                                ?>
                                <i class="<?= $icono ?>" style="float: right; color: <?= $nota ?>"></i>
                            </td>
                            <td style="text-align: right;"><?= e((string) $value['cantidad']) ?> €</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <thead>
                    <tr>
                        <th colspan="3" style="text-align: right"><?= e((string) $total_gastos) ?> €</th>
                    </tr>
                </thead>
            </table>


            <?php
            //preparamos los datos para el grafico TARTA
            $arr_categoria = array();
            $arr_valor = array();
            $arr_color = array();
            $arr_porcentaje = array();
            $arr_label = array();
            // ordenamos gastos_cat_arr por valor descendente
            arsort($gastos_cat_arr);

            foreach ($gastos_cat_arr as $key => $value) {
                $arr_categoria[] = $key;
                $valor = round($value, 2);
                $arr_valor[] = $valor;
                $arr_color[] = $a_color[$key] ?? '#000000';
                $arr_label[] = $total_gastos ? round(($valor * 100) / $total_gastos) . '%' : '0%';
            }
            ?>
        </div>

        <!-- BOTONES -->
        <div style="text-align: center;">
            <button type="button" class="btn btn-primary" id="menu_anterior">
                <i class="fa fa-arrow-left fa-2x"></i>
            </button>
            <button type="button" class="btn btn-primary" style="margin-left: 15px;" id="menu_mes">
                <i class="fa fa-table"></i> Mes
            </button>
            <button type="button" class="btn btn-primary" style="margin-left: 15px;" id="archivar">
                <i class="fa fa-save"></i> Archivar
            </button>
            <a href="<?= url('cuentas/gastos_detalle') ?>" class="btn btn-primary" style="margin-left: 15px;" id="importar">
                <i class="fa fa-columns"></i> Informe
            </a>
            <button type="button" class="btn btn-primary" style="margin-left: 15px;" id="menu_siguiente">
                <i class="fa fa-arrow-right fa-2x"></i>
            </button>
        </div>

        <!-- HIDDENS -->
        <input type="hidden" id="mes_temp" value="<?= e($mes) ?>" />
        <input type="hidden" id="anio_temp" value="<?= e($anio) ?>" />
        <input type="hidden" id="total_ingresos" value="<?= e((string) $total_ingresos) ?>" />
        <input type="hidden" id="total_gastos" value="<?= e((string) $total_gastos) ?>" />
        <input type="hidden" id="total_ahorro" value="<?= e((string) $total_ahorro) ?>" />
        <input type="hidden" id="total_margen" value="<?= e((string) $total_margen) ?>" />
        <input type="hidden" id="ingresos_temp" />
        <input type="hidden" id="gastos_temp" />

    </div>

    <div class="col-md-4">

        <!-- AVISOS CANTIDADES -->
        <div class="alert alert-success">
            Total Ingresos: <span class="badge badge-success" style="float: right; font-size: 13px; margin-top: 5px;"><?= e((string) $total_ingresos) ?> €</span>
        </div>
        <div class="alert alert-danger">
            Total Gastos: <span class="badge badge-danger" style="float: right; font-size: 13px; margin-top: 5px;"><?= e((string) $total_gastos) ?> €</span>
        </div>
        <div class="alert alert-warning">
            Total Ahorro: <span class="badge badge-warning" style="float: right; font-size: 13px; margin-top: 5px;"><?= e((string) $total_ahorro) ?> €</span>
        </div>
        <div class="alert alert-info">
            Total Margen: <span class="badge badge-info" style="float: right; font-size: 13px; margin-top: 5px;"><?= e((string) round($total_margen, 2)) ?> €</span>
        </div>

        <!-- GRAFICO BARRAS -->
        <canvas id="chart_gastos" style="margin-top: 25px;" height="175px;"></canvas>

        <!-- GRAFICO CATEGORIAS -->
        <div id="container" style="margin-top: 25px;">
            <div id="left" style="float: left; width: 15%; text-align: left;">
                <?php foreach ($arr_color as $key => $value) {
                    $icono = $a_icono_color[$value] ?? '';
                ?>
                    <i class="<?= $icono ?>" style="color: <?= $value ?>; border-left: 10px solid <?= $value ?>; padding: 3px; margin: 5px;"></i><br>
                <?php } ?>
            </div>
            <div id="right" style="float: right; width: 85%; text-align: left;">
                <canvas id="chart_categorias" width="250" height="250"></canvas>
            </div>
        </div>

    </div>

    <!-- Mensajes -->
    <?php if (!empty($msg_ok)) { ?>
        <div class="alert alert-success" style="width: 100%;"><?= e($msg_ok) ?></div>
    <?php } ?>
    <?php if (!empty($msg_ko)) { ?>
        <div class="alert alert-danger" style="width: 100%;"><?= e($msg_ko) ?></div>
    <?php } ?>


</div><!-- #row -->

<!-- Modals -->
<div id="modal_ingresos" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="min-width: 640px;">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modal_ingresos_label" style="color: #fff;"></h5>
                <a href="#/" id="plantilla_ingreso_guardar">
                    <span style="cursor: pointer; margin-left: 12px; color: #fff;"><i class="fas fa-save fa-2x" title="Guardar como Plantilla"></i></span>
                </a>
                <a href="#/" id="plantilla_ingreso_cargar">
                    <span style="cursor: pointer; margin-left: 12px; color: #fff;"><i class="fas fa-upload fa-2x" title="Cargar Plantilla"></i></span>
                </a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" style="display: none;" id="aviso_plantilla_ingreso_guardar">Plantilla de ingreso guardada correctamente</div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend" title="Fecha">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="ingreso_fecha" name="ingreso_fecha" value="<?= e($fecha_hoy) ?>" />
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Concepto">
                                <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="ingreso_concepto" name="ingreso_concepto" />
                        </div>
                    </div>
                    <div class="col-sm-4" style="padding-left: 5px;">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Precio">
                                <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
                            </div>
                            <input type="text" class="form-control" id="ingreso_cantidad" name="ingreso_cantidad" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend" title="Comentario">
                            <span class="input-group-text"><i class="far fa-comment-dots"></i></span>
                        </div>
                        <input type="text" class="form-control" id="ingreso_comentario" name="ingreso_comentario" placeholder="Comentario" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" class="form-control" id="ingreso_id" name="ingreso_id" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="ingreso_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_gastos" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="min-width: 640px;">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="modal_gastos_label" style="color: #fff;"></h5>
                <a href="#/" id="plantilla_gasto_guardar">
                    <span style="cursor: pointer; margin-left: 15px; color: #fff;"><i class="fas fa-save fa-2x" title="Guardar como Plantilla"></i></span>
                </a>
                <a href="#/" id="plantilla_gasto_cargar">
                    <span style="cursor: pointer;  margin-left: 15px; color: #fff;"><i class="fas fa-upload fa-2x" title="Cargar Plantilla"></i></span>
                </a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" style="display: none;" id="aviso_plantilla_gasto_guardar">Plantilla de gasto guardada correctamente</div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend" title="Fecha">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="gasto_fecha" name="gasto_fecha" value="<?= e($fecha_hoy) ?>" />
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Concepto">
                                <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="gasto_concepto" name="gasto_concepto" />
                        </div>
                    </div>
                    <div class="col-sm-4" style="padding-left: 5px;">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Precio">
                                <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
                            </div>
                            <input type="text" class="form-control" id="gasto_cantidad" name="gasto_cantidad" />
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Categoria">
                                <span class="input-group-text"><i class="far fa-folder"></i></span>
                            </div>
                            <select class="form-control" id="gasto_categoria" name="gasto_categoria">
                                <?php foreach ($categorias as $fila) { ?>
                                    <option value="<?= $fila->id ?>"><?= e($fila->nombre) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 5px;">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Valoracion">
                                <span class="input-group-text"><i class="far fa-star"></i></span>
                            </div>
                            <select class="form-control" id="gasto_nota" name="gasto_nota">
                                <?php foreach ($nota_arr as $key => $value) { ?>
                                    <option value="<?= $key ?>"><?= e($value) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend" title="Comentario">
                            <span class="input-group-text"><i class="far fa-comment-dots"></i></span>
                        </div>
                        <input type="text" class="form-control" id="gasto_comentario" name="gasto_comentario" placeholder="Comentario" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="gasto_id" name="gasto_id" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="gasto_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_plantilla_ingresos" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" style="color: #fff; cursor: move;">Cargar plantilla ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Plantillas ingresos</label>
                    <select id="plantilla_ingresos" name="plantilla_ingresos" class="form-control"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="plantilla_ingreso_cargar_ok">Cargar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_plantilla_gastos" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" style="color: #fff;">Cargar plantilla gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Plantillas gastos</label>
                    <select id="plantilla_gastos" name="plantilla_gastos" class="form-control"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="plantilla_gasto_cargar_ok">Cargar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_eliminar_ingreso" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" style="color: #fff;">Eliminar ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>¿Realmente desea eliminar el ingreso?</h3>
                <strong><span id="ingreso_eliminar_txt"></span></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="ingreso_eliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_eliminar_gasto" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" style="color: #fff;">Eliminar gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>¿Realmente desea eliminar el gasto?</h3>
                <strong><span id="gasto_eliminar_txt"></span></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="gasto_eliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_mes" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" style="color: #fff;">Escoge Mes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Año</label>
                    <select class="form-control" id="m_anio" name="m_anio">
                        <?php foreach ($anios as $fila) { ?>
                            <option value="<?= e($fila) ?>"><?= e($fila) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Mes</label>
                    <select class="form-control" id="m_mes" name="m_mes">
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="menu_mes_confirmar">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_unir" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" style="color: #fff;">Unir Seleccionados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="form-group">
                        <table class="table" style="padding: 5px;">
                        <?php foreach ($gastos_arr as $value) { ?>
                            <tr>
                                <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="check_<?= $value['id'] ?>" name="check_<?= $value['id'] ?>" />
                                </td>
                                <td><?= e($value['fecha']) ?></td>
                                <td><?= e($value['concepto']) ?></td>
                                <td style="text-align: right;">
                                    <span class="badge badge-danger" style="text-align: right"><b><?= e((string) $value['cantidad']) ?></b></span>
                                </td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="b_unir_guardar">Unir</button>
                </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/cuentas_js.php'; ?>