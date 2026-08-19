<style>
    td, th {
        text-align: center !important;
    }
</style>

<link href="<?= url('assets/css/datetimepicker.css') ?>" rel="stylesheet" />
<script src="<?= url('assets/js/moment.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.es.js') ?>"></script>

<div class="row">



    <div class="col-md-4">
        <form action="<?= url('anual/presupuesto_nuevo') ?>" method="POST" >
            <h1 class="page-head-line-ingresos">
                PRESUPUESTO
            </h1>
            <div class="form-group">
                <label>Fecha Inicial</label>
                <input type="text" class="form-control d_fecha" id="f_inicial" name="f_inicial" value="<?= e((string) $f_inicial) ?>" />
                <label>Fecha Objetivo</label>
                <input type="text" class="form-control d_fecha" id="f_objetivo" name="f_objetivo" value="<?= e((string) $f_objetivo) ?>" />
            </div>
            <div class="form-group">
                <label>Cantidad Inicial</label>
                <input  type="text" class="form-control" id="c_inicial" name="c_inicial" value="<?= e((string) $c_inicial) ?>" />
                <label>Cantidad Objetivo</label>
                <input  type="text" class="form-control" id="c_objetivo" name="c_objetivo" value="<?= e((string) $c_objetivo) ?>" />
                <label>Cantidad Mensual (Cero calculo automatico)</label>
                <input  type="text" class="form-control" id="c_mensual" name="c_mensual" value="<?= e((string) $c_mensual) ?>" />
            </div>
            <div class="form-group">
                <input  type="submit" class="btn btn-primary" id="b_presupuesto" name="b_presupuesto">
            </div>
        </form>

    </div>

    <div class="col-md-1"></div>

    <div class="col-md-7" style="margin-bottom: 20px;">

        <div class="row">

            <?php if ($enviado == "si"){ ?>

            <h1 class="page-head-line">Tu presupuesto</h1>
            <table id="presupuesto" class="table table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $total = count($resultados);
                    $cont = 1;
                    $clase = "badge badge-info";
                    foreach ($resultados as $resultado) {
                        $fecha_arr = explode("-", $resultado['fecha']);
                        $mes_txt = mes_nombre((int) $fecha_arr[0]);
                        $anio_txt = $fecha_arr[1];

                        if ($total == $cont) {//el ultimo
                            if ($resultado['cantidad'] >= $c_objetivo) {
                                $clase = "badge badge-success";
                            } else {
                                $clase = "badge badge-danger";
                            }
                        }
                    ?>
                    <tr>
                        <td><?= $mes_txt ?> <?= e($anio_txt) ?></td>
                        <td><span class="<?= $clase ?>"><?= e((string) $resultado['cantidad']) ?> €</span></td>
                    </tr>
                    <?php
                        $cont++;
                    }
                     ?>
                </tbody>

            </table>

            <?php } ?>

        </div>

    </div>




    
</div><!-- #row -->



<script type="text/javascript">
    $(document).ready(function () {

        $('.d_fecha').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            autoclose: true,
            pickTime: false
        });

    });

   
</script>