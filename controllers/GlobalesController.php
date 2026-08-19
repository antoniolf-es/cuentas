<?php

declare(strict_types=1);

class GlobalesController extends Controller
{
    private GlobalesModel $globales;

    public function __construct()
    {
        $this->globales = new GlobalesModel();
    }

    public function index(): void
    {
        $meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
        ];

        $global_arr_new = [];
        $global_arr_old = [];
        $iniciales = [];
        $ultimo_anio = null;

        // años recientes
        foreach ($this->globales->getAniosRecientes() as $anio) {
            $inicial = $this->globales->getInicial((string) $anio);
            $iniciales[$anio] = $inicial;

            foreach ($this->globales->getAnual((string) $anio) as $fila) {
                $inicial += (float) $fila->total_ahorro;
                $global_arr_new[$anio][$fila->mes] = $inicial;
            }

            $ultimo_anio = $anio;
        }

        // años antiguos
        if ($ultimo_anio !== null) {
            foreach ($this->globales->getAniosAntiguos((int) $ultimo_anio) as $anio) {
                $inicial = $this->globales->getInicial((string) $anio);
                $iniciales[$anio] = $inicial;

                foreach ($this->globales->getAnual((string) $anio) as $fila) {
                    $inicial += (float) $fila->total_ahorro;
                    $global_arr_old[$anio][$fila->mes] = $inicial;
                }
            }
        }

        $this->template('globales', [
            'pagina'         => 'Global',
            'meses'          => $meses,
            'global_arr_new' => $global_arr_new,
            'global_arr_old' => $global_arr_old,
            'iniciales'      => $iniciales,
        ]);
    }
}