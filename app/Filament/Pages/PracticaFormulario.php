<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;

class PracticaFormulario extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.practica-formulario';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Nombre del Proyecto')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre del alumno')
                            ->required(),
                    ]),
                Section::make('Temas')
                    ->schema([
                        Select::make('temas')
                            ->label('Temas')
                            ->options([
                                'tecnologia'      => 'Tecnología',
                                'educacion'       => 'Educación',
                                'salud'           => 'Salud',
                                'medioA'          => 'Medio Ambiente',
                                'entretenimiento' => 'Entretenimiento',
                            ])
                            ->required(),
                    ]),
                Section::make('Prioridad')
                    ->schema([
                        Radio::make('prioridad')
                        ->label('Prioridad')
                        ->options([
                            'baja'   => 'Baja',
                            'media'  => 'Media',
                            'alta'   => 'Alta',
                        ])
                    ]),
                
                    Section::make('Proyecto Activo')
                    ->schema([
                        Toggle::make('activo')
                        ->label('Proyecto Activo')
                        ->default(true)
                    ]),

                    Section::make('Fecha de entrega')
                    ->schema([
                        DateTimePicker::make('fecha_entrega')
                        ->label('Fecha de entrega')
                        ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function guardar(): void
    {
        $datos = $this->form->getState();
    }
}