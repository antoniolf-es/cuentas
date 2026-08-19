<?php

declare(strict_types=1);

class AjustesController extends Controller
{
    private AjustesModel $ajustes;

    public function __construct()
    {
        $this->ajustes = new AjustesModel();
    }

    public function index(): void
    {
        $config = $this->ajustes->getConfig();

        $this->template('ajustes', [
            'pagina'            => 'Ajustes',
            'rs_ajustes'        => $this->ajustes->getAjustes(),
            'rs_nomenclatura'   => $this->ajustes->getNomenclatura(),
            'rs_categorias'     => $this->ajustes->getCategorias(),
            'rs_notas_general'  => $this->ajustes->getNotas(0),
            'rs_notas_ingresos' => $this->ajustes->getNotas(1),
            'rs_notas_gastos'   => $this->ajustes->getNotas(2),
            'rs_plantillas_ing' => $this->ajustes->getPlantillas(1),
            'rs_plantillas_gto' => $this->ajustes->getPlantillas(0),
            'rs_wishlist'       => $this->ajustes->getWishlist(),
            'rs_recordatorio'   => $this->ajustes->getRecordatorios(),
            'debe_haber'        => $config->debe_haber ?? 0,
            'liber'             => $config->liber ?? 0,
        ]);
    }

    public function wish_guardar(): void
    {
        $this->ajustes->wishGuardar(
            [
                'nombre'       => (string) post('nombre'),
                'fecha_aprox'  => (string) post('fecha_aprox'),
                'fecha_final'  => (string) post('fecha_final'),
                'precio_aprox' => (string) post('precio_aprox'),
                'precio_final' => (string) post('precio_final'),
                'nota'         => (string) post('nota'),
                'estado'       => (string) post('estado'),
            ],
            (string) post('accion'),
            (int) post('wish_id')
        );
    }

    public function wish_editar(): void
    {
        $fila = $this->ajustes->wishEditar((int) post('wish_id'));

        if ($fila === null) {
            $this->json([]);

            return;
        }

        $this->json([
            'nombre'       => $fila->nombre,
            'fecha_aprox'  => $fila->fecha_aprox,
            'fecha_final'  => $fila->fecha_final,
            'precio_aprox' => $fila->precio_aprox,
            'precio_final' => $fila->precio_final,
            'nota'         => $fila->nota,
            'estado'       => $fila->estado,
            'wish_id'      => $fila->id_wishlist,
        ]);
    }

    public function wish_eliminar(): void
    {
        $this->ajustes->wishEliminar((int) post('id'));
    }

    public function categorias_editar(): void
    {
        $fila = $this->ajustes->categoriasEditar((int) post('categorias_id'));

        if ($fila === null) {
            $this->json([]);

            return;
        }

        $this->json([
            'nombre'         => $fila->nombre,
            'icono'          => $fila->icono,
            'color'          => $fila->color,
            'categorias_id'  => $fila->id_gasto_categoria,
        ]);
    }

    public function categorias_guardar(): void
    {
        $this->ajustes->categoriasGuardar(
            [
                'nombre' => (string) post('nombre'),
                'icono'  => (string) post('icono'),
                'color'  => (string) post('color'),
            ],
            (string) post('accion'),
            (int) post('categorias_id')
        );
    }

    public function categorias_eliminar(): void
    {
        $this->ajustes->categoriasEliminar((int) post('id'));
    }

    public function aj_anual_guardar(): void
    {
        $this->ajustes->ajAnualGuardar((float) post('aj_anual'));
    }

    public function nota_guardar(): void
    {
        $tipo = str_replace('tipo_', '', (string) post('tipo'));

        $this->ajustes->notaGuardar([
            'fecha' => (string) post('fecha'),
            'texto' => (string) post('texto'),
            'tipo'  => $tipo,
        ]);
    }

    public function nota_eliminar(): void
    {
        $this->ajustes->notaEliminar((int) post('id'));
    }

    public function recordatorio_guardar(): void
    {
        $tipo = str_replace('tipo_', '', (string) post('tipo'));

        $this->ajustes->recordatorioGuardar([
            'mes'         => (string) post('mes'),
            'cantidad'    => (string) post('cantidad'),
            'descripcion' => (string) post('descripcion'),
            'tipo'        => $tipo,
        ]);
    }

    public function recordatorio_eliminar(): void
    {
        $this->ajustes->recordatorioEliminar((int) post('id'));
    }

    public function plantilla_eliminar(): void
    {
        $this->ajustes->plantillaEliminar((int) post('id'));
    }

    public function cambiar_margen(): void
    {
        $this->ajustes->cambiarMargen((float) post('margen'), (string) post('anio'));
    }

    public function cambiar_inicial(): void
    {
        $this->ajustes->cambiarInicial((float) post('inicial'), (string) post('anio'));
    }

    public function estado_gasto(): void
    {
        $this->ajustes->estadoGasto((int) post('id'), (int) post('estado'));
    }

    public function nomenclatura_guardar(): void
    {
        $this->ajustes->nomenclaturaGuardar(
            [
                'codigo' => (string) post('codigo'),
                'texto'  => (string) post('texto'),
            ],
            (string) post('accion'),
            (int) post('nomenclatura_id')
        );
    }

    public function nomenclatura_editar(): void
    {
        $fila = $this->ajustes->nomenclaturaEditar((int) post('nomenclatura_id'));

        if ($fila === null) {
            $this->json([]);

            return;
        }

        $this->json([
            'codigo'          => $fila->codigo,
            'texto'           => $fila->texto,
            'nomenclatura_id' => $fila->id,
        ]);
    }

    public function nomenclatura_eliminar(): void
    {
        $this->ajustes->nomenclaturaEliminar((int) post('id'));
    }
}