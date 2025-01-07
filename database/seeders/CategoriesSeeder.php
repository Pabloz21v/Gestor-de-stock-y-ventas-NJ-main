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

        Categories::create(['name' => 'Electrónica', 'orden' => 1, 'comment' => 'de lo mejor', 'visible' => true]);
        Categories::create(['name' => 'Ropa y Accesorios', 'orden' => 2, 'comment' => 'fashion', 'visible' => true]);
        Categories::create(['name' => 'Hogar y Jardín', 'orden' => 3, 'comment' => 'momento de decorar', 'visible' => true]);
        Categories::create(['name' => 'Deportes y Fitness', 'orden' => 4, 'comment' => 'salud es vida', 'visible' => true]);
        Categories::create(['name' => 'Belleza y Cuidado Personal', 'orden' => 5, 'comment' => 'quererte mas', 'visible' => true]);
        Categories::create(['name' => 'Juguetes y Juegos', 'orden' => 6, 'comment' => 'momento de diversion', 'visible' => true]);
        Categories::create(['name' => 'Libros y Entretenimiento', 'orden' => 7, 'comment' => 'pasatiempos', 'visible' => true]);
        Categories::create(['name' => 'Alimentos y Bebidas', 'orden' => 8, 'comment' => 'gran variedad', 'visible' => true]);
    }



    







}
