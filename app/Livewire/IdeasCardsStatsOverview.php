<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use app\model\Idea;
use app\model\Categoria;

class IdeasCardsStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {

        $registradas = Idea::where('estado', 'registrada')->count();
        $revision= Idea::where('estado', 'en revision')->count();
        $aprobadas = Idea::where('estado', 'aprobada')->count();
        $rechazadas = Idea::where('estado', 'rechazada')->count();

        return [
            Stat::make('ToTtal de ideas', Idea::count())->icon('heroicon-s-light-bulb')
                ->description("Registradas: $registradas | " . "En revision:  $revision | " . "Aprobadas: $aprobadas | " . "Rechazadas: $rechazadas |")
            Stat::make('Total de categorías', Categoria::count())->icon('heroicon-s-tag')
        ];
    }
}
