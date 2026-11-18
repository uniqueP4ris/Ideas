<?php

use App\Models\Categoria;
use App\Models\Idea;

Use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

use Illuminate\Database\QueryException;

test('modificar una idea', function () {

    $categoria = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias'
    ]);

    $idea = Idea::create([
        'titulo' => 'Robot',
        'descripcion' => 'Crear un robot funcional',
        'estado' => 'aprobada',
        'observacion'=> 'Revisar de nuevo',
        'autor' => 'Paris',
        'categoria_id' => $categoria->id
    ]);

    $idea->update([
        'estado' => 'en revision',
    ]);

    $this->assertDatabaseHas('ideas', [
        'idIdea' => $idea->idIdea,
        'estado' => 'en revision'
    ]);
});

test('cambiar la categoría de una idea', function () {

    $categoria1 = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias'
    ]);

    $categoria2 = Categoria::create([
        'nombre' => 'Tecnologia',
        'descripcion' => 'Ideas de tecnologias'
    ]);

    $idea = Idea::create([
        'titulo' => 'Robot',
        'descripcion' => 'Crear un robot funcional',
        'estado' => 'en revision',
        'autor' => 'Paris',
        'categoria_id' => $categoria1->id
    ]);

    $idea->update([
        'categoria_id' => $categoria2->id,
    ]);

    $this->assertDatabaseHas('ideas', [
        'idIdea' => $idea->idIdea,
        'categoria_id' => $categoria2->id
    ]);
});

test('eliminar lógicamente una idea ', function () {

    $categoria = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias'
    ]);

    $idea = Idea::create([
        'titulo' => 'Robot',
        'descripcion' => 'Crear un robot funcional',
        'estado' => 'aprobada',
        'observacion'=> 'Revisar de nuevo',
        'autor' => 'Paris',
        'categoria_id' => $categoria->id
    ]);

    $idea->delete();

    $this->assertSoftDeleted('ideas', [
        'idIdea' => $idea->idIdea,
    ]);
});

test('registrar una idea con una categoría inexistente ', function () {

    $categoria = Categoria::create([
        'nombre' => 'Ciencia',
        'descripcion' => 'Ideas de ciencias'
    ]);

    $idea = Idea::create([
        'titulo' => 'Robot',
        'descripcion' => 'Crear un robot funcional',
        'estado' => 'aprobada',
        'observacion'=> 'Revisar de nuevo',
        'autor' => 'Paris',
        'categoria_id' => $categoria->id
    ]);

    $seRechazo = false;
    try{
        $idea->update([
        'categoria_id' => 9999,
    ]);
    }catch(QueryException $e){
        $seRechazo = true;
    }

    expect($seRechazo)->toBeTrue();

    $this->assertDatabaseHas('ideas', [
        'idIdea' => $idea->idIdea,
    ]);
});