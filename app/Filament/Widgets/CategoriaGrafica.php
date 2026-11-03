<?php

namespace App\Filament\Widgets;

use App\Models\Categoria;
use Filament\Widgets\ChartWidget;

class CategoriaGrafica extends ChartWidget
{
    protected ?string $heading = 'Ideas por categoría';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $categorias = Categoria::withCount('ideas')
            ->orderBy('nombre')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de ideas',
                    'data' => $categorias->pluck('ideas_count')->toArray(),
                    'backgroundColor' => [
                        '#60A5FA',
                        '#F87171',
                        '#FBBF24',
                        '#34D399',
                        '#A78BFA',
                        '#F472B6',
                        '#22D3EE',
                        '#FB923C',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $categorias->pluck('nombre')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}