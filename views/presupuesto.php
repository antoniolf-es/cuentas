<link href="<?= url('assets/css/datetimepicker.css') ?>" rel="stylesheet" />
<script src="<?= url('assets/js/moment.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= url('assets/js/bootstrap-datetimepicker.es.js') ?>"></script>

<div class="row">

    <div class="col-lg-5">
        <div class="card card-accent-primary">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-calculator"></i> Presupuesto</h2>
            </div>
            <div class="card-body">
                <form action="<?= url('anual/presupuesto_nuevo') ?>" method="POST">
                    <div class="form-group">
                        <label for="f_inicial">Fecha inicial</label>
                        <input type="text" class="form-control d_fecha" id="f_inicial" name="f_inicial" value="<?= e((string) $f_inicial) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="f_objetivo">Fecha objetivo</label>
                        <input type="text" class="form-control d_fecha" id="f_objetivo" name="f_objetivo" value="<?= e((string) $f_objetivo) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="c_inicial">Cantidad inicial</label>
                        <input type="text" class="form-control" id="c_inicial" name="c_inicial" value="<?= e((string) $c_inicial) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="c_objetivo">Cantidad objetivo</label>
                        <input type="text" class="form-control" id="c_objetivo" name="c_objetivo" value="<?= e((string) $c_objetivo) ?>" />
                    </div>
                    <div class="form-group">
                        <label for="c_mensual">Cantidad mensual (cero calcula automático)</label>
                        <input type="text" class="form-control" id="c_mensual" name="c_mensual" value="<?= e((string) $c_mensual) ?>" />
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" id="b_presupuesto" name="b_presupuesto" value="Calcular" />
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">

        <?php if ($enviado == "si"){ ?>

        <div class="card card-table">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-chart-line"></i> Tu presupuesto</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="presupuesto" class="table table-striped table-centered">
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
                </div>
            </div>
        </div>

        <?php } ?>

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
