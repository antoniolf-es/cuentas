<?php

declare(strict_types=1);

class AnualModel
{
    public function getInicial(string $anio): float
    {
        $row = Database::fetchOne(
            'SELECT inicial FROM cue_ajustes WHERE anio = :anio',
            ['anio' => $anio]
        );

        return $row !== null ? (float) $row->inicial : 0.0;
    }

    public function getAnual(string $anio): array
    {
        return Database::fetchAll(
            'SELECT * FROM cue_anual WHERE anio = :anio ORDER BY mes',
            ['anio' => $anio]
        );
    }

    public function getAnios(): array
    {
        return array_column(
            Database::fetchAll('SELECT DISTINCT anio FROM cue_anual ORDER BY anio DESC'),
            'anio'
        );
    }

    public function getGastosAnual(string $desde, string $hasta): array
    {
        return Database::fetchAll(
            'SELECT categoria, cantidad FROM cue_gastos WHERE fecha BETWEEN :desde AND :hasta ORDER BY fecha',
            ['desde' => $desde, 'hasta' => $hasta]
        );
    }

    public function actualizarDebeHaber(float $debeHaber): void
    {
        Database::query(
            'UPDATE cue_configuracion SET debe_haber = :debe_haber WHERE id = 1',
            ['debe_haber' => $debeHaber]
        );
    }

    public function getCategorias(): array
    {
        return Database::fetchAll('SELECT id_gasto_categoria AS id, nombre, icono, color FROM cue_gastos_categoria ORDER BY nombre');
    }

    public function insertAnual(array $data): void
    {
        Database::query(
            'INSERT INTO cue_anual (mes, anio, total_ingresos, total_gastos, total_ahorro, total_margen)
             VALUES (:mes, :anio, :total_ingresos, :total_gastos, :total_ahorro, :total_margen)',
            $data
        );
    }
}