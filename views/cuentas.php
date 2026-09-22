<!-- DATETIME -->
<link href="<?= url('assets/css/datetimepicker.css') ?>" rel="stylesheet" />
<link href="<?= url('assets/css/jquery-ui.css') ?>" rel="stylesheet" />

<script src="<?= url('assets/js/moment.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.es.js') ?>"></script>
<script src="<?= url('assets/js/jquery-ui.js') ?>"></script>

<!-- GRAFICOS -->
<script src="<?= url('assets/js/chart.js') ?>"></script>

<?php if (!empty($msg_ok)) { ?>
    <div class="alert alert-success"><?= e($msg_ok) ?></div>
<?php } ?>
<?php if (!empty($msg_ko)) { ?>
    <div class="alert alert-danger"><?= e($msg_ko) ?></div>
<?php } ?>

<div class="row">

    <div class="col-lg-8">

        <!-- INGRESOS -->
        <div class="card card-accent-success card-table">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-sign-in-alt text-success"></i> Ingresos</h2>
                <div class="card-actions">
                    <a href="#" class="icon-btn tint-success" style="display: none;" id="b_ingresos_eliminar" title="Eliminar ingreso">
                        <i class="far fa-trash-alt"></i>
                    </a>
                    <a href="#" class="icon-btn tint-success" style="display: none;" id="b_ingresos_editar" title="Editar ingreso">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="#" class="icon-btn solid-success" id="b_ingresos_nuevo" title="Nuevo ingreso">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ingresos" class="table ingresos">
                        <thead>
                            <tr>
                                <th class="col-fecha">Fecha</th>
                                <th>Concepto</th>
                                <th class="col-cantidad num">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ingresos_arr as $value) { ?>
                                <tr class="ingresos-clickable" id="ingresos_<?= $value['id'] ?>">
                                    <td class="num"><?= e($value['fecha']) ?></td>
                                    <td>
                                        <?= e($value['concepto']) ?>
                                        <?php if ($value['comentario'] != '') {  ?>
                                            <span class="custom_tooltip"
                                                data-toggle="tooltip" data-placement="right" data-custom-class="tooltip-primary" data-html="true" data-original-title="<?= e($value['comentario']) ?>">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td class="num"><?= e((string) $value['cantidad']) ?> €</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="table-total num"><?= e((string) $total_ingresos) ?> €</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
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

        <div class="card card-accent-danger card-table">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-sign-out-alt text-danger"></i> Gastos
                    <?php if (count($rec_mes) > 0) { ?>
                        <span class="custom_tooltip"
                            data-toggle="tooltip" data-placement="right" data-custom-class="tooltip-danger" data-html="true" data-original-title="<?= $aviso_este ?>">
                            <i class="fa fa-exclamation-triangle text-danger"></i>
                        </span>
                    <?php } ?>
                    <?php if (count($rec_mes_sig) > 0) {  ?>
                        <span class="custom_tooltip"
                            data-toggle="tooltip" data-placement="right" data-custom-class="tooltip-warning" data-html="true" data-original-title="<?= $aviso_sig ?>">
                            <i class="fa fa-exclamation-triangle text-warning"></i>
                        </span>
                    <?php } ?>
                </h2>
                <div class="card-actions">
                    <a href="#" class="icon-btn" id="b_unir" title="Unir gastos">
                        <i class="fas fa-biohazard"></i>
                    </a>
                    <a href="#" class="icon-btn tint-danger" style="display: none;" id="b_gastos_eliminar" title="Eliminar gasto">
                        <i class="far fa-trash-alt"></i>
                    </a>
                    <a href="#" class="icon-btn tint-danger" style="display: none;" id="b_gastos_editar" title="Editar gasto">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="#" class="icon-btn solid-danger" id="b_gastos_nuevo" title="Nuevo gasto">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="gastos" class="table gastos">
                        <thead>
                            <tr>
                                <th class="col-fecha">Fecha</th>
                                <th>Concepto</th>
                                <th class="col-cantidad num">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gastos_arr as $value) { ?>
                                <?php
                                $icono = $a_icono[$value['categoria']] ?? '';
                                switch ($value['nota']) {
                                    case 1:
                                        $nota = 'nota-1';
                                        break;
                                    case 2:
                                        $nota = 'nota-2';
                                        break;
                                    case 3:
                                        $nota = 'nota-3';
                                        break;
                                    case 4:
                                        $nota = 'nota-4';
                                        break;
                                    default:
                                        $nota = '';
                                        break;
                                }
                                ?>
                                <tr class="gastos-clickable" id="gastos_<?= $value['id'] ?>">
                                    <td class="num"><?= e($value['fecha']) ?></td>
                                    <td>
                                        <?= e($value['concepto']) ?>
                                        <?php if ($value['comentario'] != '') {  ?>
                                            <span class="custom_tooltip"
                                                data-toggle="tooltip" data-placement="right" data-custom-class="tooltip-primary" data-html="true" data-original-title="<?= e($value['comentario']) ?>">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                        <?php } ?>
                                        <i class="<?= $icono ?> cat-icon <?= $nota ?>"></i>
                                    </td>
                                    <td class="num"><?= e((string) $value['cantidad']) ?> €</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="table-total num"><?= e((string) $total_gastos) ?> €</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <?php
        //preparamos los datos para el grafico TARTA
        $arr_categoria = array();
        $arr_valor = array();
        $arr_color = array();
        $arr_porcentaje = array();
        $arr_label = array();
        $arr_nombre = array();
        $a_nombre = array();
        foreach ($categorias as $c) {
            $a_nombre[(int) $c->id] = $c->nombre;
        }
        // ordenamos gastos_cat_arr por valor descendente
        arsort($gastos_cat_arr);

        foreach ($gastos_cat_arr as $key => $value) {
            $arr_categoria[] = $key;
            $arr_nombre[] = $a_nombre[$key] ?? $key;
            $valor = round($value, 2);
            $arr_valor[] = $valor;
            $arr_color[] = $a_color[$key] ?? '#000000';
            $arr_label[] = $total_gastos ? round(($valor * 100) / $total_gastos) . '%' : '0%';
        }
        ?>

        <!-- BOTONES -->
        <div class="toolbar">
            <div class="btn-group toolbar-group" role="group" aria-label="Navegación del mes">
                <button type="button" class="btn" id="menu_anterior" title="Mes anterior">
                    <i class="fa fa-arrow-left"></i>
                </button>
                <button type="button" class="btn" id="menu_mes">
                    <i class="fa fa-table"></i> Mes
                </button>
                <button type="button" class="btn" id="archivar">
                    <i class="fa fa-save"></i> Archivar
                </button>
                <a href="<?= url('cuentas/gastos_detalle') ?>" class="btn" id="importar">
                    <i class="fa fa-columns"></i> Informe
                </a>
                <button type="button" class="btn" id="menu_siguiente" title="Mes siguiente">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
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

    <div class="col-lg-4">

        <!-- AVISOS CANTIDADES -->
        <div class="stat-grid">
            <div class="stat-tile stat-success">
                <span class="stat-icon"><i class="fas fa-sign-in-alt"></i></span>
                <span>
                    <span class="stat-label">Ingresos</span>
                    <span class="stat-value num"><?= e((string) $total_ingresos) ?> €</span>
                </span>
            </div>
            <div class="stat-tile stat-danger">
                <span class="stat-icon"><i class="fas fa-sign-out-alt"></i></span>
                <span>
                    <span class="stat-label">Gastos</span>
                    <span class="stat-value num"><?= e((string) $total_gastos) ?> €</span>
                </span>
            </div>
            <div class="stat-tile stat-warning">
                <span class="stat-icon"><i class="fas fa-piggy-bank"></i></span>
                <span>
                    <span class="stat-label">Ahorro</span>
                    <span class="stat-value num"><?= e((string) $total_ahorro) ?> €</span>
                </span>
            </div>
            <div class="stat-tile stat-info">
                <span class="stat-icon"><i class="fas fa-chart-line"></i></span>
                <span>
                    <span class="stat-label">Margen</span>
                    <span class="stat-value num"><?= e((string) round($total_margen, 2)) ?> €</span>
                </span>
            </div>
        </div>

        <!-- GRAFICO BARRAS -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-chart-bar"></i> Resumen del mes</h2>
            </div>
            <div class="card-body">
                <div class="chart-box">
                    <canvas id="chart_gastos"></canvas>
                </div>
            </div>
        </div>

        <!-- GRAFICO CATEGORIAS -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-chart-pie"></i> Gastos por categoría</h2>
            </div>
            <div class="card-body">
                <div class="cat-chart">
                    <canvas id="chart_categorias" width="250" height="250"></canvas>
                    <div class="cat-legend">
                        <?php foreach ($arr_color as $key => $value) {
                            $icono = $a_icono_color[$value] ?? '';
                        ?>
                            <span class="cat-chip" style="--chip: <?= $value ?>" title="<?= e($arr_nombre[$key] ?? '') ?>">
                                <i class="<?= $icono ?>"></i>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div><!-- #row -->

<!-- Modals -->
<div id="modal_ingresos" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-wide" role="document">
        <div class="modal-content">
            <div class="modal-header mh-success">
                <h5 class="modal-title" id="modal_ingresos_label"></h5>
                <div class="modal-tools">
                    <a href="#/" id="plantilla_ingreso_guardar" class="modal-tool" title="Guardar como plantilla">
                        <i class="fas fa-save"></i>
                    </a>
                    <a href="#/" id="plantilla_ingreso_cargar" class="modal-tool" title="Cargar plantilla">
                        <i class="fas fa-upload"></i>
                    </a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" style="display: none;" id="aviso_plantilla_ingreso_guardar">Plantilla de ingreso guardada correctamente</div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend" title="Fecha">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="ingreso_fecha" name="ingreso_fecha" value="<?= e($fecha_hoy) ?>" />
                </div>
                <div class="form-row mb-3">
                    <div class="form-group col-sm-8 mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Concepto">
                                <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="ingreso_concepto" name="ingreso_concepto" />
                        </div>
                    </div>
                    <div class="form-group col-sm-4 mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Precio">
                                <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
                            </div>
                            <input type="text" class="form-control" id="ingreso_cantidad" name="ingreso_cantidad" />
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend" title="Comentario">
                        <span class="input-group-text"><i class="far fa-comment-dots"></i></span>
                    </div>
                    <input type="text" class="form-control" id="ingreso_comentario" name="ingreso_comentario" placeholder="Comentario" />
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
    <div class="modal-dialog modal-dialog-wide" role="document">
        <div class="modal-content">
            <div class="modal-header mh-danger">
                <h5 class="modal-title" id="modal_gastos_label"></h5>
                <div class="modal-tools">
                    <a href="#/" id="plantilla_gasto_guardar" class="modal-tool" title="Guardar como plantilla">
                        <i class="fas fa-save"></i>
                    </a>
                    <a href="#/" id="plantilla_gasto_cargar" class="modal-tool" title="Cargar plantilla">
                        <i class="fas fa-upload"></i>
                    </a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" style="display: none;" id="aviso_plantilla_gasto_guardar">Plantilla de gasto guardada correctamente</div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend" title="Fecha">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="gasto_fecha" name="gasto_fecha" value="<?= e($fecha_hoy) ?>" />
                </div>
                <div class="form-row mb-3">
                    <div class="form-group col-sm-8 mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Concepto">
                                <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" id="gasto_concepto" name="gasto_concepto" />
                        </div>
                    </div>
                    <div class="form-group col-sm-4 mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Precio">
                                <span class="input-group-text"><i class="fas fa-euro-sign"></i></span>
                            </div>
                            <input type="text" class="form-control" id="gasto_cantidad" name="gasto_cantidad" />
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Categoría">
                                <span class="input-group-text"><i class="far fa-folder"></i></span>
                            </div>
                            <select class="form-control" id="gasto_categoria" name="gasto_categoria">
                                <?php foreach ($categorias as $fila) { ?>
                                    <option value="<?= $fila->id ?>"><?= e($fila->nombre) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-prepend" title="Valoración">
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
                <div class="input-group">
                    <div class="input-group-prepend" title="Comentario">
                        <span class="input-group-text"><i class="far fa-comment-dots"></i></span>
                    </div>
                    <input type="text" class="form-control" id="gasto_comentario" name="gasto_comentario" placeholder="Comentario" />
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header mh-success">
                <h5 class="modal-title">Cargar plantilla ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="plantilla_ingresos">Plantillas ingresos</label>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header mh-danger">
                <h5 class="modal-title">Cargar plantilla gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="plantilla_gastos">Plantillas gastos</label>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header mh-success">
                <h5 class="modal-title">Eliminar ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-ask">¿Realmente desea eliminar el ingreso?</p>
                <p class="modal-target"><span id="ingreso_eliminar_txt"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="ingreso_eliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_eliminar_gasto" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header mh-danger">
                <h5 class="modal-title">Eliminar gasto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="modal-ask">¿Realmente desea eliminar el gasto?</p>
                <p class="modal-target"><span id="gasto_eliminar_txt"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="gasto_eliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_mes" class="modal fade draggable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header mh-primary">
                <h5 class="modal-title">Escoger mes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="m_anio">Año</label>
                    <select class="form-control" id="m_anio" name="m_anio">
                        <?php foreach ($anios as $fila) { ?>
                            <option value="<?= e($fila) ?>"><?= e($fila) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="m_mes">Mes</label>
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
    <div class="modal-dialog modal-dialog-wide" role="document">
        <div class="modal-content">
            <div class="modal-header mh-primary">
                <h5 class="modal-title">Unir seleccionados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table">
                        <?php foreach ($gastos_arr as $value) { ?>
                            <tr>
                                <td class="col-check">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="" id="check_<?= $value['id'] ?>" name="check_<?= $value['id'] ?>" />
                                    </div>
                                </td>
                                <td class="num"><?= e($value['fecha']) ?></td>
                                <td><?= e($value['concepto']) ?></td>
                                <td class="num"><span class="badge badge-danger"><b><?= e((string) $value['cantidad']) ?></b></span></td>
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
