<?php

use App\Models\User;
use App\Models\Idea;
use App\Models\Categoria;
use App\Filament\Resources\Ideas\Pages\EditIdea;
use App\Filament\Resources\Ideas\Pages\ListIdeas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Filament\Actions\Testing\TestAction;

uses(RefreshDatabase::class);

beforeEach(function(){

    $this->usuario = User::factory()->create([
        'rol'=>'admin'
        ]);

    $this->actingAs($this->usuario);

    $this->categoria = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias'
    ]);

    $this->idea = Idea::create([
        'titulo' => 'Robot',
        'descripcion' => 'Crear un robot funcional',
        'estado' => 'registrada',
        'observacion'=> 'Revisar de nuevo',
        'autor' => 'Paris',
        'categoria_id' => $this->categoria->id,

    ]);

});


test('editar una idea', function(){
    Livewire::test(EditIdea::class, [
        'record' => 1
    ])
    ->assertSuccessful()
    /*->assertFormSet()([
        'titulo' => 'Robot',
        'descripcion' => 'Crear un robot funcional'
    ]);*/
    ->fillForm([
        'titulo' => 'Robot',
        'descripcion' => 'Crear un robot funcional'
    ])

    ->call('save')
    ->assertHasNoFormErrors()
    ->assertNotified();
});

test('editar una idea  sin descripcion', function(){
    Livewire::test(EditIdea::class, [
        'record' => 1
    ])

    ->fillForm([
        'titulo' => 'Robot',
        'descripcion' => ''
    ])

    ->call('save')
    ->assertHasFormErrors([
        'descripcion' => 'required'
    ]);
    
    $this->assertDatabaseHas('ideas', [
        'titulo' => 'Robot',
        'descripcion' => 'Crear un robot funcional'
    ]);
});

test('probar una idea', function(){
    Livewire::test(listIdeas::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$this->idea])
        ->assertActionVisible(TestAction::make('aprobar')->table($this->idea))
        ->callAction(TestAction::make('aprobar')->table($this->idea));
        $this->assertDatabaseHas('ideas',
        ['idIdea' => $this->idea->idIdea,
           'estado' => 'aprobada',
        ]);
});

test('rechazar una idea', function(){
    Livewire::test(listIdeas::class)
        ->assertSuccessful()
        ->assertCanSeeTableRecords([$this->idea])
        ->assertActionVisible(TestAction::make('rechazar')->table($this->idea))
        ->callAction(TestAction::make('rechazar')->table($this->idea),
            data:['observacion' => 'La idea necesita más información']);
        $this->assertDatabaseHas('ideas',
        ['idIdea' => $this->idea->idIdea,
           'estado' => 'rechazado',
           'observacion' => 'La idea necesita más información'
        ]);
});
