<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
 CategoriaSeeder::class,
            IdeaSeeder::class,
        ]);
        User::firstOrCreate(
            ['email' => 'paris00him@gmail.com'],
            [
                'name' => 'Paris',
            'password' => Hash::make('1'),
            ]
        );
        User::updateOrCreate(
            ['email' => 'coordinador@ideas'],
            [
                'name' => 'Coordinador',
            'password' => Hash::make('12345'),
            ]
        );
        User::updateOrCreate(
            ['email' => 'asistente@ideas'],
            [
                'name' => 'Asistente',
            'password' => Hash::make('12345'),
            ]
        );
    }
}
