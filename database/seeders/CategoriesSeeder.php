<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Categories::create(['name' => 'Entrantes', 'orden' => 1, 'comment' => 'Apertura del menú', 'visible' => true]);
        Categories::create(['name' => 'Principales', 'orden' => 2, 'comment' => 'Platos fuertes', 'visible' => true]);
        Categories::create(['name' => 'Postres', 'orden' => 3, 'comment' => 'Cierre del menú', 'visible' => true]);
        Categories::create(['name' => 'Bebidas', 'orden' => 4, 'comment' => 'Bebidas refrescantes y calientes', 'visible' => true]);
        Categories::create(['name' => 'Guarniciones', 'orden' => 5, 'comment' => 'Acompañamientos para los platos principales', 'visible' => true]);
    
    }
}
