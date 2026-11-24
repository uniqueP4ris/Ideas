<?php

use App\Models\User;
use App\Models\Idea;
use App\Models\Categoria;
use App\Filament\Resources\Ideas\Pages\EditIdea;
use App\Filament\Resources\Ideas\Pages\ListIdeas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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