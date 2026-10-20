<?php
namespace Database\Seeders;
use App\Models\Categoria;
use Illuminate\Database\Seeder;
class CategoriaSeeder extends Seeder
{
 public function run(): void
 {
 Categoria::FirstOrCreate([
 'nombre' => 'Tecnología',
 'descripcion' => 'Ideas relacionadas con tecnología y
software.'
 ]);
 Categoria::FirstOrCreate([
 'nombre' => 'Educación',
 'descripcion' => 'Ideas relacionadas con educación y
aprendizaje.'
 ]);
 Categoria::FirstOrCreate([
 'nombre' => 'Salud',
 'descripcion' => 'Ideas relacionadas con salud y
bienestar.'
 ]);
 Categoria::FirstOrCreate([
 'nombre' => 'Medio ambiente',
 'descripcion' => 'Ideas relacionadas con el cuidado
del medio ambiente.'
 ]);
 }
}