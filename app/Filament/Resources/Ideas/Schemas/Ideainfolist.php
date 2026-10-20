<?php

namespace App\Filament\Resources\Ideas\Schemas;

use Filament\Infolist\Components\TextEntry;
use Filament\Schemas\Schema;


class IdeaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('titulo')
                    ->label('Titulo de la Idea')
                    ]);
    }
}