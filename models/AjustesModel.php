<?php

declare(strict_types=1);

class AjustesModel
{
    public function getAjustes(): array
    {
        return Database::fetchAll('SELECT * FROM cue_ajustes ORDER BY anio DESC LIMIT 5');
    }

    public function getNomenclatura(): array
    {
        return Database::fetchAll('SELECT * FROM cue_nomenclatura ORDER BY codigo');
    }

    public function getCategorias(): array
    {
        return Database::fetchAll('SELECT * FROM cue_gastos_categoria ORDER BY nombre');
    }

    public function getNotas(int $tipo): array
    {
        return Database::fetchAll(
            'SELECT * FROM cue_notas WHERE tipo = :tipo ORDER BY fecha DESC',
            ['tipo' => $tipo]
        );
    }

    public function getPlantillas(int $tipo): array
    {
        return Database::fetchAll(
            'SELECT * FROM cue_plantilla WHERE tipo = :tipo ORDER BY id_plantilla DESC',
            ['tipo' => $tipo]
        );
    }

    public function getWishlist(): array
    {
        return Database::fetchAll('SELECT * FROM cue_wishlist ORDER BY estado ASC, fecha_aprox DESC');
    }

    public function getRecordatorios(): array
    {
        return Database::fetchAll('SELECT * FROM cue_recordatorio ORDER BY mes ASC');
    }

    public function getConfig(): object
    {
        return Database::fetchOne('SELECT debe_haber, liber FROM cue_configuracion WHERE id = 1');
    }

    public function wishGuardar(array $data, string $accion, int $id): void
    {
        if ($accion === 'nuevo') {
            Database::query(
                'INSERT INTO cue_wishlist (nombre, fecha_aprox, fecha_final, precio_aprox, precio_final, nota, estado)
                 VALUES (:nombre, :fecha_aprox, :fecha_final, :precio_aprox, :precio_final, :nota, :estado)',
                $data
            );

            return;
        }

        Database::query(
            'UPDATE cue_wishlist SET nombre = :nombre, fecha_aprox = :fecha_aprox, fecha_final = :fecha_final,
                    precio_aprox = :precio_aprox, precio_final = :precio_final, nota = :nota, estado = :estado
             WHERE id_wishlist = :id',
            $data + ['id' => $id]
        );
    }

    public function wishEditar(int $id): ?object
    {
        return Database::fetchOne('SELECT * FROM cue_wishlist WHERE id_wishlist = :id', ['id' => $id]);
    }

    public function wishEliminar(int $id): void
    {
        Database::query('DELETE FROM cue_wishlist WHERE id_wishlist = :id', ['id' => $id]);
    }

    public function categoriasGuardar(array $data, string $accion, int $id): void
    {
        if ($accion === 'nuevo') {
            Database::query(
                'INSERT INTO cue_gastos_categoria (nombre, icono, color) VALUES (:nombre, :icono, :color)',
                $data
            );

            return;
        }

        Database::query(
            'UPDATE cue_gastos_categoria SET nombre = :nombre, icono = :icono, color = :color
             WHERE id_gasto_categoria = :id',
            $data + ['id' => $id]
        );
    }

    public function categoriasEditar(int $id): ?object
    {
        return Database::fetchOne('SELECT * FROM cue_gastos_categoria WHERE id_gasto_categoria = :id', ['id' => $id]);
    }

    public function categoriasEliminar(int $id): void
    {
        Database::query('DELETE FROM cue_gastos_categoria WHERE id_gasto_categoria = :id', ['id' => $id]);
    }

    public function notaGuardar(array $data): void
    {
        Database::query(
            'INSERT INTO cue_notas (fecha, texto, tipo) VALUES (:fecha, :texto, :tipo)',
            $data
        );
    }

    public function notaEliminar(int $id): void
    {
        Database::query('DELETE FROM cue_notas WHERE id_nota = :id', ['id' => $id]);
    }

    public function recordatorioGuardar(array $data): void
    {
        Database::query(
            'INSERT INTO cue_recordatorio (mes, cantidad, descripcion, tipo) VALUES (:mes, :cantidad, :descripcion, :tipo)',
            $data
        );
    }

    public function recordatorioEliminar(int $id): void
    {
        Database::query('DELETE FROM cue_recordatorio WHERE id_recordatorio = :id', ['id' => $id]);
    }

    public function plantillaEliminar(int $id): void
    {
        Database::query('DELETE FROM cue_plantilla WHERE id_plantilla = :id', ['id' => $id]);
    }

    public function cambiarMargen(float $margen, string $anio): void
    {
        Database::query(
            'UPDATE cue_ajustes SET margen = :margen WHERE anio = :anio',
            ['margen' => $margen, 'anio' => $anio]
        );
    }

    public function cambiarInicial(float $inicial, string $anio): void
    {
        Database::query(
            'UPDATE cue_ajustes SET inicial = :inicial WHERE anio = :anio',
            ['inicial' => $inicial, 'anio' => $anio]
        );
    }

    public function ajAnualGuardar(float $margen): void
    {
        $anio = date('Y');
        Database::query(
            'UPDATE cue_ajustes SET margen = :margen WHERE anio = :anio',
            ['margen' => $margen, 'anio' => (string) $anio]
        );
    }

    public function estadoGasto(int $id, int $estado): void
    {
        Database::query(
            'UPDATE cue_gastos SET nota = :estado WHERE id_gasto = :id',
            ['estado' => $estado, 'id' => $id]
        );
    }

    public function nomenclaturaGuardar(array $data, string $accion, int $id): void
    {
        if ($accion === 'nuevo') {
            Database::query(
                'INSERT INTO cue_nomenclatura (codigo, texto) VALUES (:codigo, :texto)',
                $data
            );

            return;
        }

        Database::query(
            'UPDATE cue_nomenclatura SET codigo = :codigo, texto = :texto WHERE id = :id',
            $data + ['id' => $id]
        );
    }

    public function nomenclaturaEditar(int $id): ?object
    {
        return Database::fetchOne('SELECT * FROM cue_nomenclatura WHERE id = :id', ['id' => $id]);
    }

    public function nomenclaturaEliminar(int $id): void
    {
        Database::query('DELETE FROM cue_nomenclatura WHERE id = :id', ['id' => $id]);
    }
}