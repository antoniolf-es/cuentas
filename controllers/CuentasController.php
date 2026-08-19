<?php

declare(strict_types=1);

class CuentasController extends Controller
{
    private CuentasModel $cuentas;

    public function __construct()
    {
        $this->cuentas = new CuentasModel();
    }

    public function index(): void
    {
        $this->actual();
    }

    public function actual(): void
    {
        // revisamos si hay fecha establecida
        $mes = Session::get('mes');

        if ($mes === null || $mes === '') {
            Session::set('mes', date('m'));
            Session::set('anio', date('Y'));
        }

        $mes = (string) Session::get('mes', date('m'));
        $anio = (string) Session::get('anio', date('Y'));
        $mes_sig = ($mes == 12) ? 1 : $mes + 1;

        $fecha_hoy = $anio . '-' . $mes . '-01';
        $fecha_desde = $anio . '-' . $mes . '-01';
        $fecha_hasta = $anio . '-' . $mes . '-31';
        $mes_txt = mes_nombre((int) $mes);

        // ingresos
        $ingresos_arr = [];
        $total_ingresos = 0;

        foreach ($this->cuentas->getIngresos($fecha_desde, $fecha_hasta) as $f) {
            $ingresos_arr[] = [
                'id'        => $f->id,
                'fecha'     => $f->fecha,
                'concepto'  => $f->concepto,
                'cantidad'  => $f->cantidad,
                'comentario'=> $f->comentario,
            ];
            $total_ingresos += (float) $f->cantidad;
        }

        // gastos
        $gastos_arr = [];
        $gastos_cat_arr = [];
        $total_gastos = 0;

        foreach ($this->cuentas->getGastos($fecha_desde, $fecha_hasta) as $g) {
            $gastos_arr[] = [
                'id'        => $g->id,
                'fecha'     => $g->fecha,
                'concepto'  => $g->concepto,
                'cantidad'  => $g->cantidad,
                'categoria' => $g->categoria,
                'nota'      => $g->nota,
                'comentario'=> $g->comentario,
            ];
            $gastos_cat_arr[$g->categoria] = ($gastos_cat_arr[$g->categoria] ?? 0) + (float) $g->cantidad;
            $total_gastos += (float) $g->cantidad;
        }

        $margen = $this->cuentas->getMargen($anio);

        $total_ahorro = $total_ingresos - $total_gastos;
        $total_margen = $total_ahorro - $margen;

        $anios = $this->cuentas->getAnios();

        $categorias = $this->cuentas->getCategorias();
        $a_icono = [];
        $a_color = [];
        $a_icono_color = [];

        foreach ($categorias as $c) {
            $a_icono[(int) $c->id] = $c->icono;
            $a_color[(int) $c->id] = $c->color;
            $a_icono_color[$c->color] = $c->icono;
        }

        $rec_mes = $this->cuentas->getRecordatorios((int) $mes);
        $rec_mes_sig = $this->cuentas->getRecordatorios((int) $mes_sig);

        $this->template('cuentas', [
            'pagina'         => 'Inicio',
            'mes'            => $mes,
            'anio'           => $anio,
            'mes_txt'        => $mes_txt,
            'fecha_hoy'      => $fecha_hoy,
            'ingresos_arr'   => $ingresos_arr,
            'gastos_arr'     => $gastos_arr,
            'total_ingresos' => $total_ingresos,
            'total_gastos'   => $total_gastos,
            'total_ahorro'   => $total_ahorro,
            'total_margen'   => $total_margen,
            'anios'          => $anios,
            'categorias'     => $categorias,
            'rec_mes'        => $rec_mes,
            'rec_mes_sig'    => $rec_mes_sig,
            'gastos_cat_arr' => $gastos_cat_arr,
            'nota_arr'       => config_item('nota_gastos', []),
            'a_icono'        => $a_icono,
            'a_color'        => $a_color,
            'a_icono_color'  => $a_icono_color,
            'msg_ok'         => flash_get('msg_ok'),
            'msg_ko'         => flash_get('msg_ko'),
        ]);
    }

    public function archivar(): void
    {
        $this->cuentas->archivar(
            (string) post('mes'),
            (string) post('anio'),
            [
                'total_ingresos' => post('total_ingresos'),
                'total_gastos'   => post('total_gastos'),
                'total_ahorro'   => post('total_ahorro'),
                'total_margen'   => post('total_margen'),
            ]
        );
    }

    public function ingreso_guardar(): void
    {
        $cantidad = str_replace([',', '-'], ['.', ''], (string) post('cantidad'));
        $cantidad = round((float) $cantidad, 2);

        $this->cuentas->guardarIngreso(
            [
                'fecha'      => (string) post('fecha'),
                'concepto'   => (string) post('concepto'),
                'cantidad'   => $cantidad,
                'comentario' => (string) post('comentario'),
            ],
            (int) post('id', 0)
        );
    }

    public function gasto_guardar(): void
    {
        $cantidad = str_replace([',', '-'], ['.', ''], (string) post('cantidad'));
        $cantidad = round((float) $cantidad, 2);

        $this->cuentas->guardarGasto(
            [
                'fecha'      => (string) post('fecha'),
                'concepto'   => (string) post('concepto'),
                'cantidad'   => $cantidad,
                'categoria'  => (string) post('categoria'),
                'nota'       => (string) post('nota'),
                'comentario' => (string) post('comentario'),
            ],
            (int) post('id', 0)
        );
    }

    public function plantilla_guardar(): void
    {
        $cantidad = str_replace([',', '-'], ['.', ''], (string) post('cantidad'));
        $cantidad = round((float) $cantidad, 2);

        $fecha_arr = explode('-', (string) post('fecha'));

        $this->cuentas->guardarPlantilla([
            'dia'       => $fecha_arr[2] ?? '',
            'concepto'  => (string) post('concepto'),
            'cantidad'  => $cantidad,
            'categoria' => (string) post('categoria'),
            'tipo'      => (string) post('tipo'),
        ]);
    }

    public function get_ingreso(): void
    {
        $fila = $this->cuentas->getIngreso((int) post('id'));

        if ($fila === null) {
            $this->json([]);

            return;
        }

        $this->json([
            0 => $fila->id,
            1 => $fila->fecha,
            2 => $fila->concepto,
            3 => $fila->cantidad,
            4 => $fila->comentario,
        ]);
    }

    public function get_gasto(): void
    {
        $fila = $this->cuentas->getGasto((int) post('id'));

        if ($fila === null) {
            $this->json([]);

            return;
        }

        $this->json([
            0 => $fila->id,
            1 => $fila->fecha,
            2 => $fila->concepto,
            3 => $fila->cantidad,
            4 => $fila->categoria,
            5 => $fila->nota,
            6 => $fila->comentario,
        ]);
    }

    public function get_plantilla_ingreso(): void
    {
        $fila = $this->cuentas->getPlantilla((int) post('id'));

        if ($fila === null) {
            $this->json([]);

            return;
        }

        $fecha = date('Y-m-' . $fila->dia);

        $this->json([
            0 => $fecha,
            1 => $fila->concepto,
            2 => $fila->cantidad,
        ]);
    }

    public function get_plantilla_gasto(): void
    {
        $fila = $this->cuentas->getPlantilla((int) post('id'));

        if ($fila === null) {
            $this->json([]);

            return;
        }

        $fecha = date('Y-m-' . $fila->dia);

        $this->json([
            0 => $fecha,
            1 => $fila->concepto,
            2 => $fila->cantidad,
            3 => $fila->categoria,
        ]);
    }

    public function plantilla_ingreso_cargar(): void
    {
        $this->echoPlantillas(1);
    }

    public function plantilla_gasto_cargar(): void
    {
        $this->echoPlantillas(0);
    }

    private function echoPlantillas(int $tipo): void
    {
        $return = '';

        foreach ($this->cuentas->getPlantillas($tipo) as $fila) {
            $desc = $fila->dia . ' - ' . $fila->concepto . ' | ' . $fila->cantidad;
            $return .= "<option value='{$fila->id_plantilla}'>{$desc}</option>";
        }

        echo $return;
    }

    public function borrar_ingreso(): void
    {
        $this->cuentas->borrarIngreso((int) post('id'));
    }

    public function borrar_gasto(): void
    {
        $this->cuentas->borrarGasto((int) post('id'));
    }

    public function mes_siguiente(): void
    {
        $mes = (int) Session::get('mes');
        $anio = (int) Session::get('anio');

        $mes++;

        if ($mes == 13) {
            $mes = 1;
            $anio++;
        }

        Session::set('mes', (string) $mes);
        Session::set('anio', (string) $anio);
    }

    public function mes_anterior(): void
    {
        $mes = (int) Session::get('mes');
        $anio = (int) Session::get('anio');

        $mes--;

        if ($mes == 0) {
            $mes = 12;
            $anio--;
        }

        Session::set('mes', (string) $mes);
        Session::set('anio', (string) $anio);
    }

    public function mes_concreto(): void
    {
        Session::set('mes', (string) post('mes'));
        Session::set('anio', (string) post('anio'));
    }

    public function gastos_detalle(): void
    {
        $fecha_desde = (string) post('fecha_desde');
        $fecha_hasta = (string) post('fecha_hasta');
        $categoria = post('categoria');
        $estado = post('estado');
        $concepto = (string) post('concepto');

        if ($fecha_desde === '') {
            $fecha_desde = date('Y-m-01');
        }

        if ($fecha_hasta === '') {
            $fecha_hasta = date('Y-m-31');
        }

        $gastos = $this->cuentas->getGastosDetalle([
            'fecha_desde' => $fecha_desde,
            'fecha_hasta' => $fecha_hasta,
            'categoria'   => $categoria,
            'estado'      => $estado,
            'concepto'    => $concepto,
        ]);

        $categorias = $this->cuentas->getCategorias();
        $a_icono = [];

        foreach ($categorias as $c) {
            $a_icono[(int) $c->id] = $c->icono;
        }

        $this->template('gastos_detalle', [
            'pagina'       => 'Gastos',
            'gastos'       => $gastos,
            'categorias'   => $categorias,
            'a_icono'      => $a_icono,
            'fecha_desde'  => $fecha_desde,
            'fecha_hasta'  => $fecha_hasta,
            'categoria'    => $categoria,
            'estado'       => $estado,
            'concepto'     => $concepto,
            'msg_ok'       => flash_get('msg_ok'),
            'msg_ko'       => flash_get('msg_ko'),
        ]);
    }

    public function unir(): void
    {
        $ids = (array) post('ids', []);

        if ($ids !== []) {
            $this->cuentas->unirGastos($ids);
        }
    }

    public function importar(): void
    {
        flash_set('msg_ko', 'La importación CSV está deshabilitada de momento.');

        $this->actual();
    }
}