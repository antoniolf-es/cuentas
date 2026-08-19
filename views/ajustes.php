<style>
    td,
    th {
        text-align: center !important;
    }

    .nav-item :hover {
        cursor: pointer;
    }

    .nav-tabs .active {
        background-color: #2C6ABE !important;
        color: #fff !important;
    }

    #modal_wish {
        margin-top: -100px;
    }
</style>

<link href="<?= url('assets/css/datetimepicker.css') ?>" rel="stylesheet" />
<script src="<?= url('assets/js/moment.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.es.js') ?>"></script>

<div class="row">

    <div class="col-md-12">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab_general" data-toggle="tab" data-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                    <i class="fas fa-cog"></i> General
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab_categorias" data-toggle="tab" data-target="#categorias" type="button" role="tab" aria-controls="plantillas" aria-selected="false">
                    <i class="fas fa-code-branch"></i> Categorias
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab_wishlist" data-toggle="tab" data-target="#wishlist" type="button" role="tab" aria-controls="wishlist" aria-selected="false">
                    <i class="far fa-grin-stars"></i> Wishlist
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab_notas" data-toggle="tab" data-target="#notas" type="button" role="tab" aria-controls="notas" aria-selected="false">
                    <i class="far fa-sticky-note"></i> Notas
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab_plantillas" data-toggle="tab" data-target="#plantillas" type="button" role="tab" aria-controls="plantillas" aria-selected="false">
                    <i class="far fa-newspaper"></i> Plantillas
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab_recordatorio" data-toggle="tab" data-target="#recordatorio" type="button" role="tab" aria-controls="recordatorio" aria-selected="false">
                    <i class="far fa-calendar-check"></i> Recordatorios
                </a>
            </li>
        </ul>
    </div>

    <div class="col-md-12 mt-3">
        <div class="tab-content" id="myTabContent">

            <!-- TAB GENERAL-->
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="tab_general">
                <div class="col-md-5">

                    <div class="row">

                        <h1 class="page-head-line">
                            Ajuste anual
                            <a href="#" class="btn btn-primary" id="b_aj_anual" style="float: right; padding: 4px;" data-bind="tipo_0">
                                <i class="fas fa-pen"></i>
                            </a>
                        </h1>
                        <table id="ajustes" class="table table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Año</th>
                                    <th>Margen</th>
                                    <th>Debe/Haber</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($rs_ajustes as $fila) { ?>
                                    <tr>
                                        <td><span class="badge badge-primary"><?= e($fila->anio) ?> </span></td>
                                        <td>
                                            <input type="text" class="form-control" id="margen_<?= e($fila->anio) ?>" value="<?= e((string) $fila->margen) ?>" onchange="cambiar_margen(<?= e($fila->anio) ?>)" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="inicial_<?= e($fila->anio) ?>" value="<?= e((string) $fila->inicial) ?>" onchange="cambiar_inicial(<?= e($fila->anio) ?>)" />
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="col-md-5">

                    <div class="row">

                        <h1 class="page-head-line">
                            Nomenclatura
                            <a href="#" class="btn btn-primary" style="float: right;" id="b_nomenclatura_nuevo">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </h1>
                        <table id="t_nomenclatura" class="table table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Texto</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($rs_nomenclatura as $fila) { ?>
                                    <tr>
                                        <td><span class="badge badge-info"><?= e($fila->codigo) ?></span></td>
                                        <td style="text-align: left !important;"><span><?= e($fila->texto) ?> </span></td>
                                        <td>
                                            <a href="<?= url('ajustes/nomenclatura_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id ?>">
                                                <i class="fas fa-trash-alt" style="float: right; margin-left: 10px;" title="eliminar"></i>
                                            </a>
                                            <a href="" class="nomenclatura_editar" data-bind="<?= $fila->id ?>">
                                                <i class="fas fa-pen" style="float: right;" title="editar"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

            <!-- TAB CATEGORIAS-->
            <div class="tab-pane fade" id="categorias" role="tabpanel" aria-labelledby="tab_categorias">
                <div class="col-md-6">

                    <div class="row">

                        <h1 class="page-head-line">
                            Categorias
                            <a href="#" class="btn btn-primary" style="float: right;" id="b_categorias_nuevo">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </h1>
                        <table id="t_categorias" class="table table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Icono</th>
                                    <th>Color hex</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($rs_categorias as $fila) { ?>
                                    <tr>
                                        <td style="text-align: left !important; "><span><?= e($fila->nombre) ?> </span></td>
                                        <td><span><i class="<?= e($fila->icono) ?>"></i></span></td>
                                        <td><span class="badge" style="background-color: <?= e($fila->color) ?> ;"><?= e($fila->color) ?></span></td>
                                        <td>
                                            <a href="<?= url('ajustes/categorias_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id_gasto_categoria ?>">
                                                <i class="fas fa-trash-alt" style="float: right; margin-left: 10px;" title="eliminar"></i>
                                            </a>
                                            <a href="" class="categorias_editar" data-bind="<?= $fila->id_gasto_categoria ?>">
                                                <i class="fas fa-pen" style="float: right;" title="editar"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

            <!-- TAB WISHLIST-->
            <div class="tab-pane fade" id="wishlist" role="tabpanel" aria-labelledby="tab_wishlist">
                <div class="col-md-12">

                    <div class="row">

                        <h1 class="page-head-line">
                            Wishlist
                            <a href="#" class="btn btn-primary" style="float: right;" id="b_wish_nuevo">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </h1>
                        <table id="ajustes" class="table table-striped" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha Aprox.</th>
                                    <th>Fecha Final</th>
                                    <th>Precio Aprox.</th>
                                    <th>Precio Final</th>
                                    <th>Nota</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($rs_wishlist as $fila) {
                                    switch ($fila->estado) {
                                        case 1:
                                            $clase = "#FFF3CD";
                                            break; //pospuesto
                                        case 2:
                                            $clase = "#F8D7DA";
                                            break; //descartada
                                        case 3:
                                            $clase = "#D4EDDA";
                                            break; //hecho
                                        default:
                                            $clase = "#D1ECF1";
                                            break; //pdte
                                    }
                                ?>
                                    <tr style="background-color: <?= $clase ?> !important; color: #3E3E3E !important;">
                                        <td style="text-align: left !important;"><span><?= e($fila->nombre) ?> </span></td>
                                        <td><span class="badge badge-warning"><?= e($fila->fecha_aprox) ?></span></td>
                                        <td><span class="badge badge-primary"><?= e($fila->fecha_final) ?></span></td>
                                        <td><span class="badge badge-warning"><?= e((string) $fila->precio_aprox) ?> €</span></td>
                                        <td><span class="badge badge-primary"><?= e((string) $fila->precio_final) ?> €</span></td>
                                        <td style="text-align: left !important;">
                                            <span><?= e($fila->nota) ?></span>
                                            <a href="<?= url('ajustes/wish_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id_wishlist ?>">
                                                <i class="fas fa-trash-alt" style="float: right; margin-left: 10px;" title="eliminar"></i>
                                            </a>
                                            <a href="" class="wish_editar" data-bind="<?= $fila->id_wishlist ?>">
                                                <i class="fas fa-pen" style="float: right;" title="editar"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

            <!-- TAB NOTAS -->
            <div class="tab-pane fade" id="notas" role="tabpanel" aria-labelledby="tab_notas">

                <div class="row">

                    <div class="col-md-4">
                        <h1 class="page-head-line">
                            NOTAS GENERAL
                            <a href="#" class="btn btn-primary b_nota_nuevo" style="float: right; padding: 2px;" data-bind="tipo_0">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </h1>
                        <?php foreach ($rs_notas_general as $fila) { ?>
                            <div class="alert alert-info" style="width: 100%;">
                                <span class="badge badge-info" style="margin-right: 15px;"><?= e($fila->fecha) ?></span>
                                <span><?= e($fila->texto) ?></span>
                                <span><a href="<?= url('ajustes/nota_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id_nota ?>">
                                        <i class="fas fa-trash-alt" style="float: right;" title="eliminar"></i>
                                    </a></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-4">
                        <h1 class="page-head-line-ingresos">
                            NOTAS INGRESOS
                            <a href="#" class="btn btn-success b_nota_nuevo" style="float: right; padding: 2px;" data-bind="tipo_1">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </h1>
                        <?php foreach ($rs_notas_ingresos as $fila) { ?>
                            <div class="alert alert-success" style="width: 100%;">
                                <span class="badge badge-success" style="margin-right: 15px;"><?= e($fila->fecha) ?></span>
                                <span><?= e($fila->texto) ?></span>
                                <span><a href="<?= url('ajustes/nota_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id_nota ?>">
                                        <i class="fas fa-trash-alt" style="float: right;" title="eliminar"></i>
                                    </a></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-4">
                        <h1 class="page-head-line-gastos">
                            NOTAS GASTOS
                            <a href="#" class="btn btn-danger b_nota_nuevo" style="float: right; padding: 2px;" data-bind="tipo_2">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </h1>
                        <?php foreach ($rs_notas_gastos as $fila) { ?>
                            <div class="alert alert-danger" style="width: 100%;">
                                <span class="badge badge-danger" style="margin-right: 15px;"><?= e($fila->fecha) ?></span>
                                <span><?= e($fila->texto) ?></span>
                                <span><a href="<?= url('ajustes/nota_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id_nota ?>">
                                        <i class="fas fa-trash-alt" style="float: right;" title="eliminar"></i>
                                    </a></span>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>

            <!-- TAB PLANTILLAS -->
            <div class="tab-pane fade" id="plantillas" role="tabpanel" aria-labelledby="tab_plantillas">

                    <div class="row">

                        <div class="col-md-6">
                            <h1 class="page-head-line-ingresos">
                                PLANTILLAS INGRESOS
                            </h1>
                            <?php foreach ($rs_plantillas_ing as $fila) { ?>
                                <div class="alert alert-success" style="width: 100%;">
                                    <span class="badge badge-success" style="margin-right: 15px;">Dia <?= e((string) $fila->dia) ?> - <?= e((string) $fila->cantidad) ?> €</span>
                                    <span><?= e($fila->concepto) ?></span>
                                    <span><a href="<?= url('ajustes/plantilla_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id_plantilla ?>">
                                            <i class="fas fa-trash-alt" style="float: right;" title="eliminar"></i>
                                        </a></span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="col-md-6">
                            <h1 class="page-head-line-gastos">
                                PLANTILLAS GASTOS
                            </h1>
                            <?php foreach ($rs_plantillas_gto as $fila) { ?>
                                <div class="alert alert-danger" style="width: 100%;">
                                    <span class="badge badge-danger" style="margin-right: 15px;">Dia <?= e((string) $fila->dia) ?> - <?= e((string) $fila->cantidad) ?> €</span>
                                    <span><?= e($fila->concepto) ?></span>
                                    <span><a href="<?= url('ajustes/plantilla_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id_plantilla ?>">
                                            <i class="fas fa-trash-alt" style="float: right;" title="eliminar"></i>
                                        </a></span>
                                </div>
                            <?php } ?>
                        </div>

                    </div>

            </div>

            <!-- TAB RECORDATORIO -->
            <div class="tab-pane fade" id="recordatorio" role="tabpanel" aria-labelledby="tab_recordatorio">

                    <div class="row">

                        <div class="col-md-6">
                            <h1 class="page-head-line-gastos">
                                RECORDATORIOS
                                <a href="#" class="btn btn-danger b_recordatorio_nuevo" style="float: right; padding: 2px;" data-bind="tipo_0">
                                <i class="fa fa-plus-circle"></i>
                                </a>
                            </h1>
                            <?php foreach ($rs_recordatorio as $fila) { ?>
                                <div class="alert alert-danger" style="width: 100%;">
                                    <span class="badge badge-danger" style="margin-right: 15px;">Mes <?= e((string) $fila->mes) ?> - <?= e((string) $fila->cantidad) ?> €</span>
                                    <span><?= e($fila->descripcion) ?></span>
                                    <span><a href="<?= url('ajustes/recordatorio_eliminar') ?>" class="e_eliminar" data-bind="<?= $fila->id_recordatorio ?>">
                                            <i class="fas fa-trash-alt" style="float: right;" title="eliminar"></i>
                                        </a></span>
                                </div>
                            <?php } ?>
                        </div>

                    </div>

            </div>


        </div>
    </div><!-- div tabs -->


</div><!-- #row -->


<!-- MODAL WISHLIST -->
<div class="modal fade" id="modal_wish" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="h_wishlist" style="color: #fff;">Nuevo Wishlist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="wish_nombre" name="wish_nombre" />
                </div>
                <div class="form-group">
                    <label>Fecha aprox.</label>
                    <input type="text" class="form-control d_picker" id="wish_fecha_aprox" name="wish_fecha_aprox" value="<?= date('Y-m-d') ?>" />
                </div>
                <div class="form-group" id="capa_f_final">
                    <label>Fecha final</label>
                    <input type="text" class="form-control d_picker" id="wish_fecha_final" name="wish_fecha_final" value="<?= date('Y-m-d') ?>" />
                </div>
                <div class="form-group">
                    <label>Precio aprox.</label>
                    <input type="text" class="form-control" id="wish_precio_aprox" name="wish_precio_aprox" />
                </div>
                <div class="form-group" id="capa_p_final">
                    <label>Precio final</label>
                    <input type="text" class="form-control" id="wish_precio_final" name="wish_precio_final" />
                </div>
                <div class="form-group">
                    <label>Nota</label>
                    <textarea class="form-control" id="wish_nota" name="wish_nota"></textarea>
                </div>
                <div class="form-group" id="capa_estado">
                    <label>Estado</label>
                    <select class="form-control" id="wish_estado" name="wish_estado">
                        <option value="0">Pendiente</option>
                        <option value="1">Pospuesta</option>
                        <option value="2">Descartada</option>
                        <option value="3">Hecho</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="wish_accion" name="wish_accion" value="nuevo" />
                <input type="hidden" id="wish_id" name="wish_id" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="wish_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL NOTAS -->
<div class="modal fade" id="modal_nota" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Fecha</label>
                    <input type="text" class="form-control" id="nota_fecha" name="nota_fecha" value="<?= date('Y-m-d') ?>" />
                </div>
                <div class="form-group">
                    <label>Nota</label>
                    <textarea class="form-control" id="nota_texto" name="nota_texto"></textarea>
                </div>
                <input type="hidden" id="nota_tipo" name="nota_tipo" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="nota_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL categorias -->
<div class="modal fade" id="modal_categorias" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" id="categorias_nombre" name="categorias_nombre" />
                </div>
                <div class="form-group">
                    <label>Icono</label>
                    <input type="text" class="form-control" id="categorias_icono" name="categorias_icono" />
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" class="form-control" id="categorias_color" name="categorias_color" />
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="categorias_id" name="categorias_id" />
                <input type="hidden" id="categorias_accion" name="categorias_accion" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="categorias_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PLANTILLAS -->
<div class="modal fade" id="modal_plantilla" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Plantilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Dia</label>
                    <input type="text" class="form-control" id="plantilla_dia" name="plantilla_dia" />
                </div>
                <div class="form-group">
                    <label>Cantidad</label>
                    <input type="text" class="form-control" id="plantilla_cantidad" name="plantilla_cantidad" />
                </div>
                <div class="form-group">
                    <label>Concepto</label>
                    <textarea class="form-control" id="plantilla_concepto" name="plantilla_concepto"></textarea>
                </div>
                <input type="hidden" id="plantilla_tipo" name="plantilla_tipo" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="plantilla_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL recordatorios -->
<div class="modal fade" id="modal_recordatorio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo recordatorio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Mes</label>
                    <input type="text" class="form-control" id="recordatorio_mes" name="recordatorio_mes" />
                </div>
                <div class="form-group">
                    <label>Cantidad</label>
                    <input type="text" class="form-control" id="recordatorio_cantidad" name="recordatorio_cantidad" />
                </div>
                <div class="form-group">
                    <label>Descripcion</label>
                    <textarea class="form-control" id="recordatorio_descripcion" name="recordatorio_descripcion"></textarea>
                </div>
                <input type="hidden" id="recordatorio_tipo" name="recordatorio_tipo" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="recordatorio_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AJUSTE -->
<div class="modal fade" id="modal_aj_anual" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajuste anual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Cantidad Margen</label>
                    <input type="text" class="form-control" id="aj_anual" name="aj_anual" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="aj_anual_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL NOMENCLATURA -->
<div class="modal fade" id="modal_nomenclatura" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nomenclatura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Código</label>
                    <input type="text" class="form-control" id="nomenclatura_codigo" name="nomenclatura_codigo" maxlength="2" />
                </div>
                <div class="form-group">
                    <label>Texto</label>
                    <input type="text" class="form-control" id="nomenclatura_texto" name="nomenclatura_texto" maxlength="50" />
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="nomenclatura_id" name="nomenclatura_id" />
                <input type="hidden" id="nomenclatura_accion" name="nomenclatura_accion" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="nomenclatura_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- JQUERY -->
<script type="text/javascript">
    $(document).ready(function() {

        //whislist
        $('#wish_fecha').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            autoclose: true,
            pickTime: false
        });

        $("#b_wish_nuevo").click(function() {
            $("#capa_f_final").hide();
            $("#capa_p_final").hide();
            $("#capa_estado").hide();
            $('#modal_wish').modal('show');
        });

        $(".wish_editar").click(function(e) {
            e.preventDefault();
            var wish_id = $(this).attr('data-bind');
            $("#capa_f_final").show();
            $("#capa_p_final").show();
            $("#capa_estado").show();

            var datos = {
                wish_id: wish_id
            };
            var url = '<?= url('ajustes/wish_editar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var datos = JSON.parse(data);

                    $("#wish_nombre").val(datos.nombre);
                    $("#wish_fecha_aprox").val(datos.fecha_aprox);
                    $("#wish_fecha_final").val(datos.fecha_final);
                    $("#wish_precio_aprox").val(datos.precio_aprox);
                    $("#wish_precio_final").val(datos.precio_final);
                    $("#wish_nota").val(datos.nota);
                    $("#wish_estado").val(datos.estado);
                    $("#wish_id").val(datos.wish_id);
                    $("#wish_accion").val("editar");

                    $('#modal_wish').modal('show');
                }
            });

        });

        $("#wish_guardar").click(function() {
            var nombre = $("#wish_nombre").val();
            var fecha_aprox = $("#wish_fecha_aprox").val();
            var fecha_final = $("#wish_fecha_final").val();
            var precio_aprox = $("#wish_precio_aprox").val();
            var precio_final = $("#wish_precio_final").val();
            var nota = $("#wish_nota").val();
            var estado = $("#wish_estado").val();
            var accion = $("#wish_accion").val();
            var wish_id = $("#wish_id").val();

            var datos = {
                nombre: nombre,
                fecha_aprox: fecha_aprox,
                fecha_final: fecha_final,
                precio_aprox: precio_aprox,
                precio_final: precio_final,
                nota: nota,
                estado: estado,
                accion: accion,
                wish_id: wish_id
            };
            var url = '<?= url('ajustes/wish_guardar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    location.reload();
                }
            });
        });

        //categorias
        $("#b_categorias_nuevo").click(function() {
            $('#categorias_accion').val("nuevo");
            $('#modal_categorias').modal('show');
        });

        $(".categorias_editar").click(function(e) {
            e.preventDefault();
            var categorias_id = $(this).attr('data-bind');

            var datos = {
                categorias_id: categorias_id
            };
            var url = '<?= url('ajustes/categorias_editar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var datos = JSON.parse(data);

                    $("#categorias_nombre").val(datos.nombre);
                    $("#categorias_icono").val(datos.icono);
                    $("#categorias_color").val(datos.color);
                    $("#categorias_id").val(datos.categorias_id);
                    $('#categorias_accion').val("editar");

                    $('#modal_categorias').modal('show');
                }
            });

        });

        $("#categorias_guardar").click(function() {
            var nombre = $("#categorias_nombre").val();
            var icono = $("#categorias_icono").val();
            var color = $("#categorias_color").val();
            var accion = $("#categorias_accion").val();
            var categorias_id = $("#categorias_id").val();

            var datos = {
                nombre: nombre,
                icono: icono,
                color: color,
                accion: accion,
                categorias_id: categorias_id,
            };
            var url = '<?= url('ajustes/categorias_guardar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    location.reload();
                }
            });
        });

        //notas
        $('.d_picker').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            autoclose: true,
            pickTime: false
        });

        $(".b_nota_nuevo").click(function() {
            var nota_tipo = $(this).attr('data-bind');
            $("#nota_tipo").val(nota_tipo);
            $('#modal_nota').modal('show');
        });

        $("#nota_guardar").click(function() {
            var fecha = $("#nota_fecha").val();
            var texto = $("#nota_texto").val();
            var tipo = $("#nota_tipo").val();

            var datos = {
                fecha: fecha,
                texto: texto,
                tipo: tipo
            };
            var url = '<?= url('ajustes/nota_guardar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    location.reload();
                }
            });
        });

        //recordatorios
        $(".b_recordatorio_nuevo").click(function() {
            var recordatorio_tipo = $(this).attr('data-bind');
            $("#recordatorio_tipo").val(recordatorio_tipo);
            $('#modal_recordatorio').modal('show');
        });

        $("#recordatorio_guardar").click(function() {
            var mes = $("#recordatorio_mes").val();
            var cantidad = $("#recordatorio_cantidad").val();
            var descripcion = $("#recordatorio_descripcion").val();
            var tipo = $("#recordatorio_tipo").val();

            var datos = {
                mes: mes,
                cantidad: cantidad,
                descripcion: descripcion,
                tipo: tipo
            };
            var url = '<?= url('ajustes/recordatorio_guardar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    location.reload();
                }
            });
        });

        //ajuste anual
        $("#b_aj_anual").click(function() {
            $('#modal_aj_anual').modal('show');
        });

        $("#aj_anual_guardar").click(function() {
            var aj_anual = $("#aj_anual").val();

            var datos = {
                aj_anual: aj_anual
            };
            var url = '<?= url('ajustes/aj_anual_guardar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    location.reload();
                }
            });
        });

        // guardar tab actual al refrescar
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('lastTab', $(this).attr('data-target'));
        });
        var lastTab = localStorage.getItem('lastTab');

        if (lastTab) {
            $('[data-target="' + lastTab + '"]').tab('show');
        }

        //nomenclatura
        $("#b_nomenclatura_nuevo").click(function() {
            $('#nomenclatura_accion').val("nuevo");
            $('#nomenclatura_codigo').val('');
            $('#nomenclatura_texto').val('');
            $('#modal_nomenclatura').modal('show');
        });

        $(".nomenclatura_editar").click(function(e) {
            e.preventDefault();
            var nomenclatura_id = $(this).attr('data-bind');

            var datos = {
                nomenclatura_id: nomenclatura_id
            };
            var url = '<?= url('ajustes/nomenclatura_editar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var item = JSON.parse(data);
                    $('#nomenclatura_codigo').val(item.codigo);
                    $('#nomenclatura_texto').val(item.texto);
                    $('#nomenclatura_id').val(item.nomenclatura_id);
                    $('#nomenclatura_accion').val("editar");
                    $('#modal_nomenclatura').modal('show');
                }
            });

        });

        $("#nomenclatura_guardar").click(function() {
            var codigo = $("#nomenclatura_codigo").val();
            var texto = $("#nomenclatura_texto").val();
            var accion = $("#nomenclatura_accion").val();
            var nomenclatura_id = $("#nomenclatura_id").val();

            var datos = {
                codigo: codigo,
                texto: texto,
                accion: accion,
                nomenclatura_id: nomenclatura_id,
            };
            var url = '<?= url('ajustes/nomenclatura_guardar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    location.reload();
                }
            });
        });

    }); //ready

    function cambiar_margen(anio) {

        final_id = "#margen_" + anio;
        margen = $(final_id).val();

        var datos = {
            margen: margen,
            anio: anio
        };
        var url = '<?= url('ajustes/cambiar_margen') ?>';

        $.ajax({
            url: url,
            type: 'post',
            cache: false,
            data: datos
        });
    }

    function cambiar_inicial(inicial, anio) {

        final_id = "#inicial_" + anio;
        inicial = $(final_id).val();

        var datos = {
            inicial: inicial,
            anio: anio
        };
        var url = '<?= url('ajustes/cambiar_inicial') ?>';

        $.ajax({
            url: url,
            type: 'post',
            cache: false,
            data: datos
        });
    }
</script>