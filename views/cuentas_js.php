<script type="text/javascript">
    $(document).ready(function() {

        $('#gasto_fecha').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            autoclose: true,
            pickTime: false
        });

        $('#ingreso_fecha').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            autoclose: true,
            pickTime: false
        });

        $("#menu_mes").click(function() {
            $('#modal_mes').modal('show');
        });

        $("#menu_siguiente").click(function() {

            var url = '<?= url('cuentas/mes_siguiente') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                success: function(data) {
                    location.reload();
                }
            });
        });

        $("#menu_anterior").click(function() {

            var url = '<?= url('cuentas/mes_anterior') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                success: function(data) {
                    location.reload();
                }
            });
        });

        $("#menu_mes_confirmar").click(function() {
            var mes = $("#m_mes").val();
            var anio = $("#m_anio").val();
            var datos = {
                mes: mes,
                anio: anio
            };
            var url = '<?= url('cuentas/mes_concreto') ?>';

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

        $("#archivar").click(function() {
            var mes = $("#mes_temp").val();
            var anio = $("#anio_temp").val();
            var total_ingresos = $("#total_ingresos").val();
            var total_gastos = $("#total_gastos").val();
            var total_ahorro = $("#total_ahorro").val();
            var total_margen = $("#total_margen").val();

            var datos = {
                mes: mes,
                anio: anio,
                total_ingresos: total_ingresos,
                total_gastos: total_gastos,
                total_ahorro: total_ahorro,
                total_margen: total_margen
            };
            var url = '<?= url('cuentas/archivar') ?>';

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

        $("#b_unir").click(function() {
            $('#modal_unir').modal('show');
        });

        $("#ingreso_guardar").click(function() {
            var id = $("#ingreso_id").val();
            var fecha = $("#ingreso_fecha").val();
            var concepto = $("#ingreso_concepto").val();
            var cantidad = $("#ingreso_cantidad").val();
            var comentario = $("#ingreso_comentario").val();

            var datos = {
                id: id,
                fecha: fecha,
                concepto: concepto,
                cantidad: cantidad,
                comentario: comentario
            };
            var url = '<?= url('cuentas/ingreso_guardar') ?>';

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

        $("#b_unir_guardar").click(function() {

            var ids = [];
            $(".form-check-input").each(function(index) {
                if ($(this).is(":checked")) {
                    var value = $(this).attr("id");
                    var id = value.replace("check_", "");
                    ids.push(id);
                }
            });

            var url = '<?= url('cuentas/unir') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: { ids: ids },
                success: function(data) {
                    location.reload();
                }
            });
        });

        $("#gasto_guardar").click(function() {
            var id = $("#gasto_id").val();
            var fecha = $("#gasto_fecha").val();
            var concepto = $("#gasto_concepto").val();
            var cantidad = $("#gasto_cantidad").val();
            var categoria = $("#gasto_categoria").val();
            var nota = $("#gasto_nota").val();
            var comentario = $("#gasto_comentario").val();

            var datos = {
                id: id,
                fecha: fecha,
                concepto: concepto,
                cantidad: cantidad,
                categoria: categoria,
                nota: nota,
                comentario: comentario
            };
            var url = '<?= url('cuentas/gasto_guardar') ?>';

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

        $("#plantilla_ingreso_guardar").click(function() {
            var fecha = $("#ingreso_fecha").val();
            var concepto = $("#ingreso_concepto").val();
            var cantidad = $("#ingreso_cantidad").val();
            var categoria = $("#ingreso_categoria").val();

            var datos = {
                fecha: fecha,
                concepto: concepto,
                cantidad: cantidad,
                categoria: categoria,
                tipo: 1
            };
            var url = '<?= url('cuentas/plantilla_guardar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    $("#aviso_plantilla_ingreso_guardar").show();
                }
            });
        });

        $("#plantilla_gasto_guardar").click(function() {
            var fecha = $("#gasto_fecha").val();
            var concepto = $("#gasto_concepto").val();
            var cantidad = $("#gasto_cantidad").val();
            var categoria = $("#gasto_categoria").val();

            var datos = {
                fecha: fecha,
                concepto: concepto,
                cantidad: cantidad,
                categoria: categoria,
                tipo: 0
            };
            var url = '<?= url('cuentas/plantilla_guardar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    $("#aviso_plantilla_gasto_guardar").show();
                }
            });
        });

        $(".gastos-clickable").click(function() {
            var id_gasto = $(this).attr("id");
            var id = id_gasto.replace("gastos_", "");
            $("#gastos_temp").val(id);
            if ($(this).hasClass("gastos-highlight")) {
                $(this).removeClass('gastos-highlight');
                $("#b_gastos_editar").hide();
                $("#b_gastos_eliminar").hide();
            } else {
                $(this).addClass('gastos-highlight').siblings().removeClass('gastos-highlight');
                $("#b_gastos_editar").show();
                $("#b_gastos_eliminar").show();
            }
        });

        $(".ingresos-clickable").click(function() {
            var id_ingreso = $(this).attr("id");
            var id = id_ingreso.replace("ingresos_", "");
            $("#ingresos_temp").val(id);
            if ($(this).hasClass("ingresos-highlight")) {
                $(this).removeClass('ingresos-highlight');
                $("#b_ingresos_editar").hide();
                $("#b_ingresos_eliminar").hide();
            } else {
                $(this).addClass('ingresos-highlight').siblings().removeClass('ingresos-highlight');
                $("#b_ingresos_editar").show();
                $("#b_ingresos_eliminar").show();
            }
        });

        $("#b_ingresos_nuevo").click(function() {
            $("#ingreso_id").val(0);
            $("#ingreso_concepto").val("");
            $("#ingreso_cantidad").val("");
            $('#modal_ingresos_label').text("Nuevo ingreso");
            $("#plantilla_ingreso_cargar").show();
            $("#aviso_plantilla_ingreso_guardar").hide();
            $('#modal_ingresos').modal('show');
        });

        $("#b_gastos_nuevo").click(function() {
            $("#gasto_id").val(0);
            $("#gasto_concepto").val("");
            $("#gasto_cantidad").val("");
            $('#modal_gastos_label').text("Nuevo gasto");
            $('#plantilla_gasto_cargar').show();
            $('#aviso_plantilla_gasto_guardar').hide();
            $('#modal_gastos').modal('show');
        });

        $("#b_ingresos_editar").click(function() {
            var id = $("#ingresos_temp").val();

            var datos = {
                id: id
            };
            var url = '<?= url('cuentas/get_ingreso') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var result = eval(data);
                    $("#ingreso_id").val(result[0]);
                    $("#ingreso_fecha").val(result[1]);
                    $("#ingreso_concepto").val(result[2]);
                    $("#ingreso_cantidad").val(result[3]);
                    $("#ingreso_comentario").val(result[4]);

                    $("#aviso_plantilla_ingreso_guardar").hide();
                    $("#plantilla_ingreso_cargar").hide();
                    $('#modal_ingresos_label').text("Editar ingreso");
                    $('#modal_ingresos').modal('show');
                }
            });
        });

        $("#plantilla_ingreso_cargar").click(function() {

            var datos = {};
            var url = '<?= url('cuentas/plantilla_ingreso_cargar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    $('#plantilla_ingresos').html(data);

                    $('#modal_ingresos').modal('hide');
                    $('#modal_plantilla_ingresos').modal('show');
                }
            });
        });

        $("#plantilla_gasto_cargar").click(function() {

            var datos = {};
            var url = '<?= url('cuentas/plantilla_gasto_cargar') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    $('#plantilla_gastos').html(data);

                    $('#modal_gastos').modal('hide');
                    $('#modal_plantilla_gastos').modal('show');
                }
            });
        });

        $("#plantilla_ingreso_cargar_ok").click(function() {

            var id = $("#plantilla_ingresos").val();
            var datos = {
                id: id
            };
            var url = '<?= url('cuentas/get_plantilla_ingreso') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var result = eval(data);
                    $("#ingreso_fecha").val(result[0]);
                    $("#ingreso_concepto").val(result[1]);
                    $("#ingreso_cantidad").val(result[2]);

                    $('#modal_ingresos_label').text("Nuevo ingreso");
                    $('#modal_plantilla_ingresos').modal('hide');
                    $('#modal_ingresos').modal('show');
                }
            });
        });

        $("#plantilla_gasto_cargar_ok").click(function() {

            var id = $("#plantilla_gastos").val();
            var datos = {
                id: id
            };
            var url = '<?= url('cuentas/get_plantilla_gasto') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var result = eval(data);
                    $("#gasto_fecha").val(result[0]);
                    $("#gasto_concepto").val(result[1]);
                    $("#gasto_cantidad").val(result[2]);
                    $("#gasto_categoria").val(result[3]);

                    $('#modal_gastos_label').text("Nuevo gasto");
                    $('#modal_plantilla_gastos').modal('hide');
                    $('#modal_gastos').modal('show');
                }
            });
        });

        $("#b_gastos_editar").click(function() {
            var id = $("#gastos_temp").val();

            var datos = {
                id: id
            };
            var url = '<?= url('cuentas/get_gasto') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var result = eval(data);
                    $("#gasto_id").val(result[0]);
                    $("#gasto_fecha").val(result[1]);
                    $("#gasto_concepto").val(result[2]);
                    $("#gasto_cantidad").val(result[3]);
                    $("#gasto_categoria").val(result[4]);
                    $("#gasto_nota").val(result[5]);
                    $("#gasto_comentario").val(result[6]);

                    $('#plantilla_gasto_cargar').hide();
                    $('#aviso_plantilla_gasto_guardar').hide();
                    $('#modal_gastos_label').text("Editar gasto");
                    $('#modal_gastos').modal('show');
                }
            });
        });

        $("#b_ingresos_eliminar").click(function() {
            var id = $("#ingresos_temp").val();

            var datos = {
                id: id
            };
            var url = '<?= url('cuentas/get_ingreso') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var result = eval(data);
                    $("#ingreso_eliminar_txt").text(result[2] + ": " + result[3]);
                    $('#modal_eliminar_ingreso').modal('show');
                }
            });
        });

        $("#b_gastos_eliminar").click(function() {
            var id = $("#gastos_temp").val();

            var datos = {
                id: id
            };
            var url = '<?= url('cuentas/get_gasto') ?>';

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: datos,
                success: function(data) {
                    var result = eval(data);
                    $("#gasto_eliminar_txt").text(result[2] + ": " + result[3]);
                    $('#modal_eliminar_gasto').modal('show');
                }
            });
        });

        $("#ingreso_eliminar").click(function() {
            var id = $("#ingresos_temp").val();

            var datos = {
                id: id
            };
            var url = '<?= url('cuentas/borrar_ingreso') ?>';

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

        $("#gasto_eliminar").click(function() {
            var id = $("#gastos_temp").val();

            var datos = {
                id: id
            };
            var url = '<?= url('cuentas/borrar_gasto') ?>';

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

        // para mover las modales
        $('.draggable').draggable({
            handle: '.modal-header'
        });

    });

    //GRAFICO BARRAS
    var ctx_gastos = document.getElementById("chart_gastos");
    var config_gastos = {
        type: 'bar',
        data: {
            labels: ["Ingresos", "Gastos", "Ahorro", "Margen"],
            datasets: [{
                data: [<?= $total_ingresos ?>, <?= $total_gastos ?>, <?= $total_ahorro ?>, <?= $total_margen ?>],
                backgroundColor: [
                    'rgba(124, 211, 149, 0.35)',
                    'rgba(255, 122, 135, 0.35)',
                    'rgba(255, 213, 79, 0.35)',
                    'rgba(90, 159, 255, 0.35)',
                ],
                borderColor: [
                    'rgba(124, 211, 149, 1)',
                    'rgba(255, 122, 135, 1)',
                    'rgba(255, 213, 79, 1)',
                    'rgba(90, 159, 255, 1)',
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
                labels: {
                    fontColor: '#97A0B5'
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: '#97A0B5'
                    },
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.08)',
                        zeroLineColor: 'rgba(255, 255, 255, 0.16)'
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: '#97A0B5'
                    },
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    };
    var chart_gastos = new Chart(ctx_gastos, config_gastos);

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