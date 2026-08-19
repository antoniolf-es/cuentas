<?php

declare(strict_types=1);

class AnualController extends Controller
{
    private AnualModel $anual;

    public function __construct()
    {
        $this->anual = new AnualModel();
    }

    public function index(): void
    {
        $this->actual();
    }

    public function actual(): void
    {
        $anio = (string) Session::get('anual', date('Y'));

        if ($anio === '') {
            $anio = date('Y');
            Session::set('anual', $anio);
        }

        $fecha_desde = $anio . '-01-01';
        $fecha_hasta = $anio . '-12-31';

        $debe_haber = $this->anual->getInicial($anio);
        $rs = $this->anual->getAnual($anio);

        // actualizamos el debe/haber final en la configuración (como hacía la vista original)
        $debe_haber_final = $debe_haber;

        foreach ($rs as $fila) {
            $debe_haber_final += (float) $fila->total_ahorro;
        }

        if ($rs !== []) {
            $this->anual->actualizarDebeHaber($debe_haber_final);
        }

        $anios = $this->anual->getAnios();
        $anterior = in_array($anio - 1, $anios, true);
        $posterior = in_array($anio + 1, $anios, true);

        $categorias = $this->anual->getCategorias();
        $a_color = [];
        $a_icono_color = [];

        foreach ($categorias as $c) {
            $a_color[(int) $c->id] = $c->color;
            $a_icono_color[$c->color] = $c->icono;
        }

        // gastos por categoría del año
        $gastos_cat_arr = [];

        foreach ($this->anual->getGastosAnual($fecha_desde, $fecha_hasta) as $g) {
            $gastos_cat_arr[$g->categoria] = ($gastos_cat_arr[$g->categoria] ?? 0) + (float) $g->cantidad;
        }

        $this->template('anual', [
            'pagina'         => 'Anual',
            'rs'             => $rs,
            'debe_haber'     => $debe_haber,
            'anio'           => $anio,
            'anios'          => $anios,
            'categorias'     => $categorias,
            'gastos_cat_arr' => $gastos_cat_arr,
            'a_color'        => $a_color,
            'a_icono_color'  => $a_icono_color,
            'anterior'       => $anterior,
            'posterior'      => $posterior,
            'msg_ok'         => flash_get('msg_ok'),
            'msg_ko'         => flash_get('msg_ko'),
        ]);
    }

    public function importar(): void
    {
        flash_set('msg_ko', 'La importación CSV está deshabilitada de momento.');

        redirect('anual');
    }

    public function anio_siguiente(): void
    {
        $anio = (int) Session::get('anual', date('Y'));
        $anio++;
        Session::set('anual', (string) $anio);
    }

    public function anio_anterior(): void
    {
        $anio = (int) Session::get('anual', date('Y'));
        $anio--;
        Session::set('anual', (string) $anio);
    }

    public function anio_concreto(): void
    {
        Session::set('anual', (string) post('anio'));
    }

    public function presupuesto(): void
    {
        $this->template('presupuesto', [
            'pagina'    => 'Presupuesto',
            'f_inicial' => date('Y-m-d'),
            'f_objetivo'=> date('Y-m-d'),
            'c_inicial' => 0,
            'c_objetivo'=> 0,
            'c_mensual' => 0,
            'enviado'   => 'no',
            'resultados'=> [],
        ]);
    }

    public function presupuesto_nuevo(): void
    {
        $f_inicial = (string) post('f_inicial');
        $f_objetivo = (string) post('f_objetivo');
        $c_inicial = (float) post('c_inicial');
        $c_objetivo = (float) post('c_objetivo');
        $c_mensual = (float) post('c_mensual');

        // calculamos meses entre fechas
        $d1 = new DateTime($f_objetivo);
        $d2 = new DateTime($f_inicial);
        $months = $d2->diff($d1);
        $total_meses = ($months->y * 12) + $months->m;

        // si no hay mensual la calculamos
        if ($c_mensual == 0) {
            $c_mensual = round(($c_objetivo - $c_inicial) / $total_meses, 2);
        }

        $c_actual = $c_inicial;

        $f_inicial_arr = explode('-', $f_inicial);
        $m_actual = (int) ($f_inicial_arr[1] ?? 1);
        $a_actual = (int) ($f_inicial_arr[0] ?? date('Y'));

        $resultados = [];

        for ($i = 0; $i <= $total_meses; $i++) {
            $resultados[] = [
                'fecha'   => $m_actual . '-' . $a_actual,
                'cantidad'=> $c_actual,
            ];

            $c_actual += $c_mensual;
            $m_actual++;

            if ($m_actual == 13) {
                $m_actual = 1;
                $a_actual++;
            }
        }

        $this->template('presupuesto', [
            'pagina'    => 'Presupuesto',
            'resultados'=> $resultados,
            'f_inicial' => $f_inicial,
            'f_objetivo'=> $f_objetivo,
            'c_inicial' => $c_inicial,
            'c_objetivo'=> $c_objetivo,
            'c_mensual' => $c_mensual,
            'enviado'   => 'si',
        ]);
    }
}