<?php

namespace App\Filament\Widgets;

use App\Helpers\EstadoIdea;
use App\Models\Categoria;
use App\Models\Idea;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IdeasCardsStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $conteos = Idea::query()
            ->selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $registradas = $conteos[EstadoIdea::REGISTRADA] ?? 0;
        $revision = $conteos[EstadoIdea::EN_REVISION] ?? 0;
        $aprobadas   = $conteos[EstadoIdea::APROBADA] ?? 0;
        $rechazadas  = $conteos[EstadoIdea::RECHAZADA] ?? 0;

        $detalleCategorias = Categoria::withCount('ideas')
            ->get()
            ->map(fn ($categoria) => "{$categoria->nombre}: {$categoria->ideas_count}")
            ->implode(' | ');

        return [
            Stat::make('Total de ideas', Idea::count())
                ->icon('heroicon-s-light-bulb')
                ->description("Registradas: $registradas | En revisión: $revision | Aprobadas: $aprobadas | Rechazadas: $rechazadas"),

            Stat::make('Total de categorías', Categoria::count())
                ->icon('heroicon-s-tag')
                ->description($detalleCategorias),
        ];
    }
}