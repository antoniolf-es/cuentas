<!-- GRAFICOS -->
<script src="<?= url('assets/js/chart.js') ?>"></script>

<div class="row">

    <div class="col-lg-7">

        <div class="card card-accent-primary card-table">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-table"></i> Resumen <?= e($anio ?? '') ?></h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="anual" class="table table-striped table-centered">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Ingresos</th>
                                <th>Gastos</th>
                                <th>Ahorro</th>
                                <th>Margen</th>
                                <th>Debe/Haber</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $g_meses_arr = array ();
                            $g_ingresos_arr = array ();
                            $g_gastos_arr = array ();
                            $g_ahorro_arr = array ();
                            $g_margen_arr = array ();
                            $media = 0;
                            $media_ingresos = 0;
                            $media_gastos = 0;
                            $media_ahorro = 0;
                            $media_margen = 0;
                            $cont = 0;
                            $total_gastos_general = 0;
                            $total_meses = count($rs);
                            $debe_haber_acum = $debe_haber;
                            foreach ($rs as $fila) {
                                $cont++;
                                $debe_haber_acum += $fila->total_ahorro;
                                $mes_txt = mes_nombre((int) $fila->mes);
                                $g_meses_arr [] = $mes_txt;
                                $g_ingresos_arr [] = $fila->total_ingresos;
                                $g_gastos_arr [] = $fila->total_gastos;
                                $g_ahorro_arr [] = $fila->total_ahorro;
                                $g_margen_arr [] = $fila->total_margen;
                                $media++;
                                $media_ingresos+= $fila->total_ingresos;
                                $media_gastos+= $fila->total_gastos;
                                $media_ahorro+= $fila->total_ahorro;
                                $media_margen+= $fila->total_margen;
                                $total_gastos_general += $fila->total_gastos;

                                //para destacar el ultimo debe haber
                                if ($cont == $total_meses){
                                    $clase = "badge badge-primary";
                                }else{
                                    $clase = "badge badge-secondary";
                                }
                                ?>
                                <tr>
                                    <td><?= $mes_txt ?></td>
                                    <td><span class="badge badge-success"><?= e((string) $fila->total_ingresos) ?> €</span></td>
                                    <td><span class="badge badge-danger"><?= e((string) $fila->total_gastos) ?> €</span></td>
                                    <td><span class="badge badge-warning"><?= e((string) $fila->total_ahorro) ?> €</span></td>
                                    <td><span class="badge badge-info"><?= e((string) $fila->total_margen) ?> €</span></td>
                                    <td><span class="<?= $clase ?>"><?= e((string) $debe_haber_acum) ?> €</span></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>Media</td>
                                <td><span class="badge badge-success"><?= $media ? round($media_ingresos/$media,2) : 0 ?> €</span></td>
                                <td><span class="badge badge-danger"><?= $media ? round($media_gastos/$media,2) : 0 ?> €</span></td>
                                <td><span class="badge badge-warning"><?= $media ? round($media_ahorro/$media,2) : 0 ?> €</span></td>
                                <td><span class="badge badge-info"><?= $media ? round($media_margen/$media,2) : 0 ?> €</span></td>
                                <td><span class="badge badge-primary"><?= e((string) round($debe_haber_acum, 2)) ?> €</span></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-5">

        <?php
        //preparamos los datos para el grafico tarta
        $arr_categoria = array ();
        $arr_valor = array ();
        $arr_color = array();
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
            $valor = round($value,2);
            $arr_valor[] = $valor;
            $arr_color[] = $a_color[$key] ?? '#000000';
            $arr_label[] = $total_gastos_general ? round(($valor * 100) / $total_gastos_general) . '%' : '0%';
        }
        ?>

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

    <!-- Grafico lineas -->
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-chart-line"></i> Evolución mensual</h2>
            </div>
            <div class="card-body">
                <div class="chart-box-lg">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas y botones -->
    <div class="col-12">
        <?php if (!empty($msg_ok)) { ?>
            <div class="alert alert-success"><?= e($msg_ok) ?></div>
        <?php } ?>
        <?php if (!empty($msg_ko)) { ?>
            <div class="alert alert-danger"><?= e($msg_ko) ?></div>
        <?php } ?>

        <div class="toolbar">
            <div class="btn-group toolbar-group" role="group" aria-label="Navegación del año">
                <button type="button" class="btn" id="menu_anterior" title="Año anterior" <?php if (!$anterior) echo "disabled";  ?>>
                    <i class="fa fa-arrow-left"></i>
                </button>
                <button type="button" class="btn" id="b_anio">
                    <i class="fa fa-table"></i> Año
                </button>
                <a href="<?= url('anual/presupuesto') ?>" class="btn" id="b_presupuesto">
                    <i class="fa fa-calculator"></i> Presupuesto
                </a>
                <button type="button" class="btn" id="menu_siguiente" title="Año siguiente" <?php if (!$posterior) echo "disabled";  ?>>
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

</div><!-- #row -->

<!-- MODALS -->
<div class="modal fade" id="modal_anio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header mh-primary">
                <h5 class="modal-title">Escoger año</h5>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="m_anio_confirmar">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#b_anio").click(function () {
            $('#modal_anio').modal('show');
        });

        $("#m_anio_confirmar").click(function () {
            var anio = $("#m_anio").val();
            var datos = {anio: anio};
            var url = '<?= url('anual/anio_concreto') ?>';

            $.ajax({
                url: url, type: 'post', cache: false, data: datos,
                success: function (data) {
                    location.reload();
                }
            });
        });

        $("#menu_siguiente").click(function () {

            var url = '<?= url('anual/anio_siguiente') ?>';

            $.ajax({
                url: url, type: 'post', cache: false,
                success: function (data) {
                    location.reload();
                }
            });
        });

        $("#menu_anterior").click(function () {

            var url = '<?= url('anual/anio_anterior') ?>';

            $.ajax({
                url: url, type: 'post', cache: false,
                success: function (data) {
                    location.reload();
                }
            });
        });

    });

    //GRAFICO LINEAS
    var ctx = document.getElementById("myChart");
    var meses_arr = <?= json_encode($g_meses_arr) ?>;
    var ingresos_arr = <?= json_encode($g_ingresos_arr) ?>;
    var gastos_arr = <?= json_encode($g_gastos_arr) ?>;
    var ahorro_arr = <?= json_encode($g_ahorro_arr) ?>;
    var margen_arr = <?= json_encode($g_margen_arr) ?>;

    var config = {
        type: 'line',
        data: {
            labels: meses_arr,
            datasets: [
                {
                    label: 'Ingresos',
                    backgroundColor: 'rgba(124, 211, 149, 1)',
                    borderColor: 'rgba(124, 211, 149, 1)',
                    data: ingresos_arr,
                    fill: false,
                }, {
                    label: 'Gastos',
                    backgroundColor: 'rgba(255, 122, 135, 1)',
                    borderColor: 'rgba(255, 122, 135, 1)',
                    data: gastos_arr,
                    fill: false,
                }, {
                    label: 'Ahorro',
                    backgroundColor: 'rgba(255, 213, 79, 1)',
                    borderColor: 'rgba(255, 213, 79, 1)',
                    data: ahorro_arr,
                    fill: false,
                }, {
                    label: 'Margen',
                    backgroundColor: 'rgba(90, 159, 255, 1)',
                    borderColor: 'rgba(90, 159, 255, 1)',
                    data: margen_arr,
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: false,
                fontColor: '#97A0B5'
            },
            legend: {
                labels: {
                    fontColor: '#97A0B5'
                }
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                bodyFontColor: '#E0E0E0',
                titleFontColor: '#E0E0E0'
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            fontColor: '#97A0B5'
                        },
                        ticks: {
                            fontColor: '#97A0B5'
                        },
                        gridLines: {
                            color: 'rgba(255, 255, 255, 0.08)'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            fontColor: '#97A0B5'
                        },
                        ticks: {
                            fontColor: '#97A0B5'
                        },
                        gridLines: {
                            color: 'rgba(255, 255, 255, 0.08)',
                            zeroLineColor: 'rgba(255, 255, 255, 0.16)'
                        }
                    }]
            }
        }
    };

    var myChart = new Chart(ctx, config);

    //GRAFICO TARTA
    var ctx_categorias = document.getElementById("chart_categorias");
    var arr_valor = <?= json_encode($arr_valor) ?>;
    var arr_color = <?= json_encode($arr_color) ?>;
    var arr_label = <?= json_encode($arr_label) ?>;
    var config_categorias = {
        type: 'pie',
        data: {
            datasets: [{
                    data: arr_valor,
                    backgroundColor: arr_color,
                    label: ''
                }],
            labels: arr_label
        },
        options: {
            responsive: false,
            legend: {
                display: false,
                labels: {
                    fontColor: '#97A0B5'
                }
            },
            tooltips: {
                enabled: true,
                bodyFontColor: '#E0E0E0',
                titleFontColor: '#E0E0E0'
            }
        }
    };
    var chart_categorias = new Chart(ctx_categorias, config_categorias);

</script>
