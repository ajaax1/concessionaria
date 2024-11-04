<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Habilidade;
use App\Models\Categoria;
use App\Models\Marca;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        /*Habilidade::factory()->create([
            'nome' => 'CRIAR',
        ]);
        Habilidade::factory()->create([
            'nome' => 'ATUALIZAR',
        ]);
        Habilidade::factory()->create([
            'nome' => 'DELETAR',
        ]);
        Habilidade::factory()->create([
            'nome' => 'LER',
        ]);
        Habilidade::factory()->create([
            'nome' => 'ADMIN',
        ]); */
        Categoria::factory()->create([
            'nome' => 'SEM CATEGORIA',
        ]);
        Marca::factory()->create([
            'nome' => 'SEM MARCA',
        ]);
    }
}
