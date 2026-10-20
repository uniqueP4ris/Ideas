<?php

namespace App\Filament\Resources\Categorias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CategoriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    //->email()
                    -> label('Nombre de categoria')
                    -> helpertext('Ingresa el nombre de la categoria')
                    ->placeholder('Ej categoria')
                    //disable
                    ->required(),
                Textarea::make('descripcion')
                    ->label('Descripción')
                    -> helpertext('Ingrresa una descripción de la categoria')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
