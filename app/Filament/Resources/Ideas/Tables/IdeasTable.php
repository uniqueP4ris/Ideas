<?php
//Autorx: Paris Mendoza 
namespace App\Filament\Resources\Ideas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\Action;
use app\Models\Idea;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;

class IdeasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                ->rowIndex()
                ->label('#'),
                TextColumn::make('titulo')
                    ->label('Idea')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('descripcion')
                    ->label('Descripcion')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('estado')
                    ->label('Estado')
                    ->searchable(),
                TextColumn::make('observacion')
                    ->label('Observaciones')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('autor')
                    ->label('Autor')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: True),
                TextColumn::make('categoria.nombre')
                    ->label('Categoria')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: True),
                TextColumn::make('Creada el')
                    ->label('Creada el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: True),
                TextColumn::make('Actualizada el')
                    ->label('Actualizada el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: True),
            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    'revisada' => 'Revisada',
                    'en revision' => 'En revision',
                    'aprobada' => 'Aprobada',
                    'rechazada' => 'Rechazada',
                ]),
                trashedFilter::make()
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
                Action::make('aprobar')
                    ->requiresConfirmation()
                    ->label('Aprobar')
                    ->color('Success')
                    ->modalheading('¿Deseas aprobar esta idea?')
                    ->action(function(Idea $record){
                        $record->update(['estado'=>'aprobada']);
                        notification::make()
                            ->title('Idea aprobada correctamente')
                            ->success()
                            ->send();
                    })
                    ->visible(fn(Idea $record) => $record->estado !== 'aprobada'),
                Action::make('rechazar')
                    ->requiresConfirmation()
                    ->label('Rechazar')
                    ->color('Denied')
                    ->modalheading('¿Deseas rechazar esta idea?')
                    ->schema([
                            TextArea::make('motivoRechazo')
                            ->label('Motico de rechazo')
                            ->required(),
                    ])
                    ->action(function (array $data, Idea $record): void {
                        $record->rechazar()->associate($data['rechazar']);
                        $record->save();
                    })
                    ->visible(fn(Idea $record)=>$record->estado !=='aprobada' && $record->estado !=='rechazado'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
