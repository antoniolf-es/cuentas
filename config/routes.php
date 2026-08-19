<?php

/**
 * Mapa de rutas: 'segmento/url' => 'pages/archivo.php'
 * Las URLs son siempre en minúsculas y con guiones.
 *
 * Las rutas de acción tipo {controlador}/{accion} (p.ej. cuentas/archivar,
 * ajustes/wish_guardar, anual/importar) se resuelven automáticamente en
 * pages/acciones.php y NO es necesario listarlas aquí.
 */
return [
    ''        => 'pages/inicio.php',
    'cuentas' => 'pages/cuentas.php',
    'anual'   => 'pages/anual.php',
    'globales' => 'pages/globales.php',
    'ajustes' => 'pages/ajustes.php',

    'cuentas/gastos_detalle' => 'pages/gastos_detalle.php',
    'anual/presupuesto'      => 'pages/presupuesto.php',
];