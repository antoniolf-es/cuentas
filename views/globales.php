<!-- GRAFICOS -->
<script src="<?= url('assets/js/chart.js') ?>"></script>
<script src="<?= url('assets/js/utils.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {

    });

    //GRAFICO
    var ctx_old = document.getElementById("myChart_old");
    var ctx_new = document.getElementById("myChart_new");
    var meses_arr = <?= json_encode($meses) ?>;

    var config_old = {
        type: 'line',
        data: {
            labels: meses_arr,
            datasets: []
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

    var config_new = {
        type: 'line',
        data: {
            labels: meses_arr,
            datasets: []
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

    window.onload = function() {
        var ctx_old = document.getElementById('myChart_old').getContext('2d');
        window.myLine = new Chart(ctx_old, config_old);
        var ctx_new = document.getElementById('myChart_new').getContext('2d');
        window.myLine = new Chart(ctx_new, config_new);
    };

    var colorNames = Object.keys(window.chartColors);
    function addDataset_old (name, data) {
        var colorName = colorNames[config_old.data.datasets.length % colorNames.length];
        var newColor = window.chartColors[colorName];
        var newDataset = {
            label: name,
            backgroundColor: newColor,
            borderColor: newColor,
            data: [],
            fill: false
        };

        var arr = Object.values(data);
        for (var i= 0; i < arr.length; i++) {
            newDataset.data.push(arr[i].toFixed(2));
        }
        config_old.data.datasets.push(newDataset);
    }
    function addDataset_new (name, data) {
        var colorName = colorNames[config_new.data.datasets.length % colorNames.length];
        var newColor = window.chartColors[colorName];
        var newDataset = {
            label: name,
            backgroundColor: newColor,
            borderColor: newColor,
            data: [],
            fill: false
        };

        var arr = Object.values(data);
        for (var i= 0; i < arr.length; i++) {
            newDataset.data.push(arr[i].toFixed(2));
        }
        config_new.data.datasets.push(newDataset);
    }

</script>

<div class="row">

    <div class="col-lg-4">
        <div class="card card-accent-primary card-table">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-table"></i> Años recientes</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="comparacion_recientes" class="table table-centered">
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Inicial</th>
                                <th>Final</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($global_arr_new AS $key => $row) {
                            $inicial = $iniciales[$key] ?? 0;
                            if ($inicial < $row[12]) {
                                $tipo = "badge badge-success";
                            } else {
                                $tipo = "badge badge-danger";
                            }
                        ?>
                            <tr>
                                <td><?= e((string) $key) ?></td>
                                <td><span class="badge badge-primary"><?= e((string) $inicial) ?> €</span></td>
                                <td><span class="<?= $tipo ?>"><?= e((string) $row[12]) ?> €</span></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-chart-line"></i> Evolución · Años recientes</h2>
            </div>
            <div class="card-body">
                <div class="chart-box-lg">
                    <canvas id="myChart_new"></canvas>
                </div>
            </div>
        </div>
    </div>

</div><!-- #row -->

<div class="row mt-4">

    <div class="col-lg-4">
        <div class="card card-table">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-table"></i> Años anteriores</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="comparacion_anteriores" class="table table-centered">
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Inicial</th>
                                <th>Final</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($global_arr_old AS $key => $row) {
                            $inicial = $iniciales[$key] ?? 0;
                            if ($inicial < $row[12]) {
                                $tipo = "badge badge-success";
                            } else {
                                $tipo = "badge badge-danger";
                            }
                        ?>
                            <tr>
                                <td><?= e((string) $key) ?></td>
                                <td><span class="badge badge-primary"><?= e((string) $inicial) ?> €</span></td>
                                <td><span class="<?= $tipo ?>"><?= e((string) $row[12]) ?> €</span></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-chart-line"></i> Evolución · Años anteriores</h2>
            </div>
            <div class="card-body">
                <div class="chart-box-lg">
                    <canvas id="myChart_old"></canvas>
                </div>
            </div>
        </div>
    </div>

</div><!-- #row -->

<?php foreach ($global_arr_new AS $key => $row) { ?>
<script>
addDataset_new(<?= $key ?>,<?= json_encode($row) ?>);
</script>
<?php } ?>

<?php foreach ($global_arr_old AS $key => $row) { ?>
<script>
addDataset_old(<?= $key ?>,<?= json_encode($row) ?>);
</script>
<?php } ?>
