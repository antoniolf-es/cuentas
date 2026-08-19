<style>
    td, th {
        text-align: center !important;
    }
</style>

<!-- GRAFICOS -->
<script src="<?= url('assets/js/chart.js') ?>"></script>

<div class="row">

    <div class="col-md-7">

        <div class="row">

            <table id="anual" class="table table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 15%;">Mes</th>
                        <th style="width: 15%;">Ingresos</th>
                        <th style="width: 15%;">Gastos</th>
                        <th style="width: 15%;">Ahorro</th>
                        <th style="width: 15%;">Margen</th>
                        <th style="width: 25%;">Debe/Haber</th>
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

                <thead>
                    <tr>
                        <th>Media</th>
                        <th>
                            <span class="badge badge-secondary" style="background-color:rgb(19, 94, 36)" ><?= $media ? round($media_ingresos/$media,2) : 0 ?> €</span>
                        </th>
                        <th>
                            <span class="badge badge-secondary" style="background-color: rgb(172, 28, 28)"><?= $media ? round($media_gastos/$media,2) : 0 ?> €</span>
                        </th>
                        <th>
                            <span class="badge badge-secondary" style="background-color: rgb(161, 118, 23)"><?= $media ? round($media_ahorro/$media,2) : 0 ?> €</span>
                        </th>
                        <th>
                            <span class="badge badge-secondary" style="background-color:rgb(25, 116, 168)"><?= $media ? round($media_margen/$media,2) : 0 ?> €</span>
                        </th>
                        <th>
                            <span class="badge badge-dark" style="background-color: rgb(36, 19, 94)"><?= e((string) round($debe_haber_acum, 2)) ?> €</span>
                        </th>
                        <th></th>
                    </tr>
                </thead>

            </table>

        </div>

    </div>

    <div class="col-md-5">

        <?php
        //preparamos los datos para el grafico tarta
        $arr_categoria = array ();
        $arr_valor = array ();
        $arr_color = array();
        $arr_label = array();
        // ordenamos gastos_cat_arr por valor descendente
        arsort($gastos_cat_arr);

        foreach ($gastos_cat_arr as $key => $value) {
            $arr_categoria[] = $key;
            $valor = round($value,2);
            $arr_valor[] = $valor;
            $arr_color[] = $a_color[$key] ?? '#000000';
            $arr_label[] = $total_gastos_general ? round(($valor * 100) / $total_gastos_general) . '%' : '0%';
        }
        ?>

        <div id="container" style="margin-top: 10px; margin-left: 15px;">
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

    <!-- Grafico lineas -->
    <div class="col-md-8" style="width:100%;">
        <canvas id="myChart"></canvas>
    </div>

    <!-- Alertas y botones -->
    <div class="col-md-12" style="margin: 0 auto; text-align: center; padding-top: 20px;">
        <?php if (!empty($msg_ok)) { ?>
            <div class="alert alert-success" style="width: 100%;"><?= e($msg_ok) ?></div>
        <?php } ?>
        <?php if (!empty($msg_ko)) { ?>
            <div class="alert alert-danger" style="width: 100%;"><?= e($msg_ko) ?></div>
        <?php } ?>

        <button type="button" class="btn btn-primary" id="menu_anterior" <?php if (!$anterior) echo "disabled";  ?>>
            <i class="fa fa-arrow-left fa-2x"></i>
        </button>

        <button type="button" class="btn btn-primary" style="margin-left: 25px" id="b_anio" >
            <i class="fa fa-table"></i> Año
        </button>
        <a href="<?= url('anual/presupuesto') ?>" class="btn btn-primary" style="margin-left: 15px;" id="b_presupuesto" >
            <i class="fa fa-calculator"></i> Presupuesto
        </a>
        <button type="button" class="btn btn-primary" style="margin-left: 25px;" id="menu_siguiente" <?php if (!$posterior) echo "disabled";  ?> >
            <i class="fa fa-arrow-right fa-2x"></i>
        </button>
    </div>


</div><!-- #row -->

<!-- MODALS -->
<div class="modal fade" id="modal_anio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" style="color: #fff;">Escoge Año</h5>
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
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    data: ingresos_arr,
                    fill: false,
                }, {
                    label: 'Gastos',
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    data: gastos_arr,
                    fill: false,
                }, {
                    label: 'Ahorro',
                    backgroundColor: 'rgba(255, 206, 86, 1)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    data: ahorro_arr,
                    fill: false,
                }, {
                    label: 'Margen',
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    data: margen_arr,
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                fontColor: '#E0E0E0'
            },
            legend: {
                labels: {
                    fontColor: '#E0E0E0'
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
                            fontColor: '#E0E0E0'
                        },
                        ticks: {
                            fontColor: '#E0E0E0'
                        },
                        gridLines: {
                            color: '#555555'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false,
                            fontColor: '#E0E0E0'
                        },
                        ticks: {
                            fontColor: '#E0E0E0'
                        },
                        gridLines: {
                            color: '#555555',
                            zeroLineColor: '#555555'
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
                    fontColor: '#E0E0E0'
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