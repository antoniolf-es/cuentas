<link href="<?= url('assets/css/datetimepicker.css') ?>" rel="stylesheet" />
<script src="<?= url('assets/js/moment.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.es.js') ?>"></script>

<div class="row">

    <div class="col-lg-8">

        <div class="card card-accent-primary card-table">
            <div class="card-header">
                <h2 class="card-title"><i class="fa fa-columns"></i> Informe de gastos</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="informe" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="col-fecha">Fecha</th>
                                <th>Concepto</th>
                                <th class="text-center">Cat.</th>
                                <th class="col-cantidad num">Cantidad</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($gastos as $fila) {
                                $icono = $a_icono[$fila->categoria] ?? '';
                                switch ($fila->nota) {
                                    case 1: case 4:
                                        $nota = 'badge badge-success';
                                        break;
                                    case 2:
                                        $nota = 'badge badge-warning';
                                        break;
                                    case 3:
                                        $nota = 'badge badge-danger';
                                        break;
                                    default:
                                        $nota = "";
                                        break;
                                }
                                $total+= $fila->cantidad;
                            ?>
                                <tr>
                                    <td class="num"><span class="badge badge-primary"><?= e($fila->fecha) ?></span></td>
                                    <td><span><?= e($fila->concepto) ?></span></td>
                                    <td class="text-center"><span><i class="<?= $icono ?>"></i></span></td>
                                    <td class="num">
                                        <a href="#" class="<?= $nota ?> btn-nota" data-id="<?= $fila->id_gasto ?>" ><?= e((string) $fila->cantidad) ?>€</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="table-total">Total estimado</td>
                                <td class="table-total num"><span class="badge badge-primary"><?= e((string) $total) ?>€</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-4">

        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-filter"></i> Filtros</h2>
            </div>
            <div class="card-body">
                <form action="<?= url('cuentas/gastos_detalle'); ?>" method="POST">
                    <div class="form-group">
                        <label for="fecha_desde">Fecha desde</label>
                        <input type="text" class="form-control" id="fecha_desde" name="fecha_desde" value="<?= e($fecha_desde) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="fecha_hasta">Fecha hasta</label>
                        <input type="text" class="form-control" id="fecha_hasta" name="fecha_hasta" value="<?= e($fecha_hasta) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="concepto">Texto</label>
                        <input type="text" class="form-control" id="concepto" name="concepto" value="<?= e($concepto) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select id="categoria" name="categoria" class="form-control">
                            <option value="0">Todas</option>
                            <?php foreach ($categorias as $fila) { ?>
                                <option value="<?= $fila->id ?>" <?php if ($categoria == $fila->id) echo "selected"; ?>><?= e($fila->nombre) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control">
                            <option value="0" <?php if ($estado == 0) echo "selected"; ?>>Valorados</option>
                            <option value="4" <?php if ($estado == 4) echo "selected"; ?>>Excelente</option>
                            <option value="1" <?php if ($estado == 1) echo "selected"; ?>>Bien</option>
                            <option value="2" <?php if ($estado == 2) echo "selected"; ?>>Regular</option>
                            <option value="3" <?php if ($estado == 3) echo "selected"; ?>>Mal</option>
                            <option value="99" <?php if ($estado == 99) echo "selected"; ?>>Todos</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" id="filtros_guardar">Filtrar</button>
                </form>
            </div>
        </div>

    </div>

</div><!-- #row -->

<!-- Modal -->
<div class="modal fade" id="estadoModal" tabindex="-1" role="dialog" aria-labelledby="estadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="estadoModalLabel">Cambiar Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="estadoSelect">Estado</label>
                    <select id="estadoSelect" class="form-control">
                        <option value="4" <?php if ($estado == 4) echo "selected"; ?>>Excelente</option>
                        <option value="1" <?php if ($estado == 1) echo "selected"; ?>>Bien</option>
                        <option value="2" <?php if ($estado == 2) echo "selected"; ?>>Regular</option>
                        <option value="3" <?php if ($estado == 3) echo "selected"; ?>>Mal</option>
                    </select>
                </div>
                <input type="hidden" id="id_gasto" value="" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="b_estado">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#fecha_desde').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            autoclose: true,
            pickTime: false
        });
        $('#fecha_hasta').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            autoclose: true,
            pickTime: false
        });

        $(".btn-nota").click(function() {
            var id = $(this).attr("data-id");
            $("#estadoModal").modal("show");
            $("#id_gasto").val(id);
        });

        $("#b_estado").click(function() {
            var id = $("#id_gasto").val();
            var estado = $("#estadoSelect").val();

            var datos = {
                id: id,
                estado: estado
            };

            var url = '<?= url('ajustes/estado_gasto') ?>';

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


    });
</script>
