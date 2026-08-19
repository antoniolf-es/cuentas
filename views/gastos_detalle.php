<style>
    th {
        text-align: center;
    }

    .alert {
        padding: 5px !important;
    }
</style>

<link href="<?= url('assets/css/datetimepicker.css') ?>" rel="stylesheet" />
<script src="<?= url('assets/js/moment.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.es.js') ?>"></script>

<div class="row">



    <div class="col-md-8">

        <h1 class="page-head-line">Informe Gastos</h1>
        <table id="ajustes" class="table table-striped" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Cat.</th>
                    <th>Cantidad</th>
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
                        <td style="text-align: center;"><span class="badge badge-primary"><?= e($fila->fecha) ?></span></td>
                        <td><span><?= e($fila->concepto) ?></span></td>
                        <td style="text-align: center;"><span><i class="<?= $icono ?>"></i></span></td>
                        <td style="text-align: center;">
                            <a href="#" class="<?= $nota ?> btn-nota" data-id="<?= $fila->id_gasto ?>" ><?= e((string) $fila->cantidad) ?>€</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfooter>
                <tr>
                    <td colspan="3" style="text-align: right;">Total estimado: </td>
                    <td style="text-align: center;"><span class="badge badge-primary"><?= e((string) $total) ?>€</span></td>
                </tr>
            </tfooter>

        </table>

    </div>

    <div class="col-md-4">
        <h1 class="page-head-line">Filtros</h1>
        <div style="border: 1px solid #2C6ABE; padding: 10px;">
            <form action="<?= url('cuentas/gastos_detalle'); ?>" method="POST">
                <div class="form-group">
                    <label>Fecha desde</label>
                    <input type="text" class="form-control" id="fecha_desde" name="fecha_desde" value="<?= e($fecha_desde) ?>" />
                </div>
                <div class="form-group">
                    <label>Fecha hasta</label>
                    <input type="text" class="form-control" id="fecha_hasta" name="fecha_hasta" value="<?= e($fecha_hasta) ?>" />
                </div>
                <div class="form-group">
                    <label>Texto</label>
                    <input type="text" class="form-control" id="concepto" name="concepto" value="<?= e($concepto) ?>" />
                </div>
                <div class="form-group">
                    <label>Categoria</label>
                    <select id="categoria" name="categoria" class="form-control">
                        <option value="0">Todas</option>
                        <?php foreach ($categorias as $fila) { ?>
                            <option value="<?= $fila->id ?>" <?php if ($categoria == $fila->id) echo "selected"; ?>><?= e($fila->nombre) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <select id="estado" name="estado" class="form-control">
                        <option value="0" <?php if ($estado == 0) echo "selected"; ?>>Valorados</option>
                        <option value="4" <?php if ($estado == 4) echo "selected"; ?>>Excelente</option>
                        <option value="1" <?php if ($estado == 1) echo "selected"; ?>>Bien</option>
                        <option value="2" <?php if ($estado == 2) echo "selected"; ?>>Regular</option>
                        <option value="3" <?php if ($estado == 3) echo "selected"; ?>>Mal</option>
                        <option value="99" <?php if ($estado == 99) echo "selected"; ?>>Todos</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;" id="filtros_guardar">Filtrar</button>
            </form>
        </div>
    </div>

</div><!-- #row -->

<!-- Modal -->
<div class="modal fade" id="estadoModal" tabindex="-1" role="dialog" aria-labelledby="estadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="estadoModalLabel">Cambiar Estado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select id="estadoSelect" class="form-control">
                    <option value="4" <?php if ($estado == 4) echo "selected"; ?>>Excelente</option>
                    <option value="1" <?php if ($estado == 1) echo "selected"; ?>>Bien</option>
                    <option value="2" <?php if ($estado == 2) echo "selected"; ?>>Regular</option>
                    <option value="3" <?php if ($estado == 3) echo "selected"; ?>>Mal</option>
                </select>
                <input type="hidden" id="id_gasto" value="" />
            </div>
            <div class="modal-footer">
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