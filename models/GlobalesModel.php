<?php

declare(strict_types=1);

class GlobalesModel
{
    public function getAniosRecientes(): array
    {
        return array_column(
            Database::fetchAll('SELECT DISTINCT anio FROM cue_anual ORDER BY anio DESC LIMIT 5'),
            'anio'
        );
    }

    public function getAniosAntiguos(int $ultimoAnio): array
    {
        return array_column(
            Database::fetchAll('SELECT DISTINCT anio FROM cue_anual WHERE anio < :anio ORDER BY anio DESC', ['anio' => $ultimoAnio]),
            'anio'
        );
    }

    public function getAnual(string $anio): array
    {
        return Database::fetchAll(
            'SELECT * FROM cue_anual WHERE anio = :anio ORDER BY mes',
            ['anio' => $anio]
        );
    }

    public function getInicial(string $anio): float
    {
        $row = Database::fetchOne(
            'SELECT inicial FROM cue_ajustes WHERE anio = :anio',
            ['anio' => $anio]
        );

        return $row !== null ? (float) $row->inicial : 0.0;
    }
}