<?php

declare(strict_types=1);

class CuentasModel
{
    public function getIngresos(string $desde, string $hasta): array
    {
        return Database::fetchAll(
            'SELECT id_ingreso AS id, fecha, concepto, cantidad, comentario
             FROM cue_ingresos
             WHERE fecha BETWEEN :desde AND :hasta
             ORDER BY fecha',
            ['desde' => $desde, 'hasta' => $hasta]
        );
    }

    public function getGastos(string $desde, string $hasta): array
    {
        return Database::fetchAll(
            'SELECT id_gasto AS id, fecha, concepto, cantidad, categoria, nota, comentario
             FROM cue_gastos
             WHERE fecha BETWEEN :desde AND :hasta
             ORDER BY fecha',
            ['desde' => $desde, 'hasta' => $hasta]
        );
    }

    public function getMargen(string $anio): float
    {
        $row = Database::fetchOne(
            'SELECT margen FROM cue_ajustes WHERE anio = :anio',
            ['anio' => $anio]
        );

        return $row !== null ? (float) $row->margen : 0.0;
    }

    public function getAnios(): array
    {
        return array_column(
            Database::fetchAll('SELECT DISTINCT anio FROM cue_anual ORDER BY anio DESC'),
            'anio'
        );
    }

    public function getCategorias(): array
    {
        return Database::fetchAll('SELECT id_gasto_categoria AS id, nombre, icono, color FROM cue_gastos_categoria ORDER BY nombre');
    }

    public function getRecordatorios(int $mes): array
    {
        return Database::fetchAll(
            'SELECT * FROM cue_recordatorio WHERE mes = :mes',
            ['mes' => $mes]
        );
    }

    public function guardarIngreso(array $data, int $id): void
    {
        if ($id === 0) {
            Database::query(
                'INSERT INTO cue_ingresos (fecha, concepto, cantidad, comentario)
                 VALUES (:fecha, :concepto, :cantidad, :comentario)',
                $data
            );

            return;
        }

        Database::query(
            'UPDATE cue_ingresos SET fecha = :fecha, concepto = :concepto, cantidad = :cantidad, comentario = :comentario
             WHERE id_ingreso = :id',
            $data + ['id' => $id]
        );
    }

    public function guardarGasto(array $data, int $id): void
    {
        if ($id === 0) {
            Database::query(
                'INSERT INTO cue_gastos (fecha, concepto, cantidad, categoria, nota, comentario)
                 VALUES (:fecha, :concepto, :cantidad, :categoria, :nota, :comentario)',
                $data
            );

            return;
        }

        Database::query(
            'UPDATE cue_gastos SET fecha = :fecha, concepto = :concepto, cantidad = :cantidad,
                    categoria = :categoria, nota = :nota, comentario = :comentario
             WHERE id_gasto = :id',
            $data + ['id' => $id]
        );
    }

    public function borrarIngreso(int $id): void
    {
        Database::query('DELETE FROM cue_ingresos WHERE id_ingreso = :id', ['id' => $id]);
    }

    public function borrarGasto(int $id): void
    {
        Database::query('DELETE FROM cue_gastos WHERE id_gasto = :id', ['id' => $id]);
    }

    public function getIngreso(int $id): ?object
    {
        return Database::fetchOne(
            'SELECT id_ingreso AS id, fecha, concepto, cantidad, comentario FROM cue_ingresos WHERE id_ingreso = :id',
            ['id' => $id]
        );
    }

    public function getGasto(int $id): ?object
    {
        return Database::fetchOne(
            'SELECT id_gasto AS id, fecha, concepto, cantidad, categoria, nota, comentario FROM cue_gastos WHERE id_gasto = :id',
            ['id' => $id]
        );
    }

    public function guardarPlantilla(array $data): void
    {
        Database::query(
            'INSERT INTO cue_plantilla (dia, concepto, cantidad, categoria, tipo)
             VALUES (:dia, :concepto, :cantidad, :categoria, :tipo)',
            $data
        );
    }

    public function getPlantillas(int $tipo): array
    {
        return Database::fetchAll(
            'SELECT * FROM cue_plantilla WHERE tipo = :tipo ORDER BY dia',
            ['tipo' => $tipo]
        );
    }

    public function getPlantilla(int $id): ?object
    {
        return Database::fetchOne(
            'SELECT * FROM cue_plantilla WHERE id_plantilla = :id',
            ['id' => $id]
        );
    }

    public function archivar(string $mes, string $anio, array $totales): void
    {
        $existe = Database::fetchOne(
            'SELECT id FROM cue_anual WHERE mes = :mes AND anio = :anio',
            ['mes' => $mes, 'anio' => $anio]
        );

        if ($existe !== null) {
            Database::query(
                'UPDATE cue_anual SET total_ingresos = :total_ingresos, total_gastos = :total_gastos,
                        total_ahorro = :total_ahorro, total_margen = :total_margen
                 WHERE mes = :mes AND anio = :anio',
                $totales + ['mes' => $mes, 'anio' => $anio]
            );

            return;
        }

        Database::query(
            'INSERT INTO cue_anual (mes, anio, total_ingresos, total_gastos, total_ahorro, total_margen)
             VALUES (:mes, :anio, :total_ingresos, :total_gastos, :total_ahorro, :total_margen)',
            $totales + ['mes' => $mes, 'anio' => $anio]
        );
    }

    public function getGastosDetalle(array $filtros): array
    {
        $sql = 'SELECT g.id_gasto, g.fecha, g.concepto, g.cantidad, g.nota, g.categoria
                FROM cue_gastos g
                WHERE g.fecha BETWEEN :desde AND :hasta';

        $params = [
            'desde' => $filtros['fecha_desde'],
            'hasta' => $filtros['fecha_hasta'],
        ];

        if ($filtros['categoria'] !== 0 && $filtros['categoria'] !== '') {
            $sql .= ' AND g.categoria = :categoria';
            $params['categoria'] = $filtros['categoria'];
        }

        if ($filtros['estado'] === 0 || $filtros['estado'] === '') {
            $sql .= ' AND g.nota > 0';
        } elseif ($filtros['estado'] !== 99) {
            $sql .= ' AND g.nota = :estado';
            $params['estado'] = $filtros['estado'];
        }

        if ($filtros['concepto'] !== '') {
            $sql .= ' AND g.concepto LIKE :concepto';
            $params['concepto'] = '%' . $filtros['concepto'] . '%';
        }

        $sql .= ' ORDER BY g.fecha';

        return Database::fetchAll($sql, $params);
    }

    public function unirGastos(array $ids): void
    {
        $fecha = '';
        $concepto = '';
        $cantidad = 0;
        $categoria = 0;
        $comentario = '';

        foreach ($ids as $id) {
            $fila = $this->getGasto((int) $id);

            if ($fila === null) {
                continue;
            }

            $fecha = $fila->fecha;
            $concepto .= $fila->concepto . ' + ';
            $cantidad += (float) $fila->cantidad;
            $categoria = $fila->categoria;
            $comentario .= ($fila->comentario) ? $fila->comentario . ' ' : '';

            Database::query('DELETE FROM cue_gastos WHERE id_gasto = :id', ['id' => $id]);
        }

        Database::query(
            'INSERT INTO cue_gastos (fecha, concepto, cantidad, categoria, comentario)
             VALUES (:fecha, :concepto, :cantidad, :categoria, :comentario)',
            [
                'fecha'      => $fecha,
                'concepto'   => substr($concepto, 0, -3),
                'cantidad'   => $cantidad,
                'categoria'  => $categoria,
                'comentario' => $comentario,
            ]
        );
    }

    public function guardarRegistroCsv(array $data, bool $ingreso): void
    {
        if ($ingreso) {
            Database::query(
                'INSERT INTO cue_ingresos (fecha, concepto, cantidad) VALUES (:fecha, :concepto, :cantidad)',
                $data
            );

            return;
        }

        $data['cantidad'] = abs((float) $data['cantidad']);
        Database::query(
            'INSERT INTO cue_gastos (fecha, concepto, cantidad) VALUES (:fecha, :concepto, :cantidad)',
            $data
        );
    }

    public function guardarAnualCsv(array $data): void
    {
        Database::query(
            'INSERT INTO cue_anual (mes, anio, total_ingresos, total_gastos, total_ahorro, total_margen)
             VALUES (:mes, :anio, :total_ingresos, :total_gastos, :total_ahorro, :total_margen)',
            $data
        );
    }
}