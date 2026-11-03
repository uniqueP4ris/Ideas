<?php

namespace App\Helpers;

class EstadoIdea
{
    public const REGISTRADA  = 'registrada';
    public const EN_REVISION = 'en revisión';
    public const APROBADA    = 'aprobada';
    public const RECHAZADA   = 'rechazada';

    public static function opciones(): array
    {
        return [
            self::REGISTRADA  => 'Registrada',
            self::EN_REVISION => 'En revisión',
            self::APROBADA    => 'Aprobada',
            self::RECHAZADA   => 'Rechazada',
        ];
    }

    // Solo las claves: ['registrada', 'en revisión', ...]
    public static function claves(): array
    {
        return array_keys(self::opciones());
    }

    // Texto legible de un estado; si no existe, devuelve el valor tal cual
    public static function etiqueta(?string $estado): string
    {
        return self::opciones()[$estado] ?? ($estado ?? '');
    }

    public static function existe(?string $estado): bool
    {
        return in_array($estado, self::claves(), true);
    }

    // Clases de Tailwind para mostrar un "badge" de color en las vistas
    public static function color(?string $estado): string
    {
        return match ($estado) {
            self::REGISTRADA  => 'bg-gray-100 text-gray-800',
            self::EN_REVISION => 'bg-yellow-100 text-yellow-800',
            self::APROBADA    => 'bg-green-100 text-green-800',
            self::RECHAZADA   => 'bg-red-100 text-red-800',
            default           => 'bg-gray-100 text-gray-800',
        };
    }
}