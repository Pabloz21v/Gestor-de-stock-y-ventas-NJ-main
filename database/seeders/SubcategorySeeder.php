<?php

namespace Database\Seeders;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subcategory::create(['name' => 'Sopas', 'orden' => 1, 'comment' => 'Sopas calientes', 'categories_id' => 1, 'visible' => true]);
        Subcategory::create(['name' => 'Ensaladas', 'orden' => 2, 'comment' => 'Frescas y ligeras', 'categories_id' => 1, 'visible' => true]);
        Subcategory::create(['name' => 'Aperitivos', 'orden' => 3, 'comment' => 'Pequeños bocados', 'categories_id' => 1, 'visible' => true]);
        
        Subcategory::create(['name' => 'Carnes', 'orden' => 1, 'comment' => 'Carnes a la parrilla', 'categories_id' => 2, 'visible' => true]);
        Subcategory::create(['name' => 'Pescados', 'orden' => 2, 'comment' => 'Pescados frescos', 'categories_id' => 2, 'visible' => true]);
        Subcategory::create(['name' => 'Pasta', 'orden' => 3, 'comment' => 'Pasta hecha a mano', 'categories_id' => 2, 'visible' => true]);
        Subcategory::create(['name' => 'Vegetariano', 'orden' => 4, 'comment' => 'Platos vegetarianos', 'categories_id' => 2, 'visible' => true]);

        Subcategory::create(['name' => 'Tartas', 'orden' => 1, 'comment' => 'Tartas caseras', 'categories_id' => 3, 'visible' => true]);
        Subcategory::create(['name' => 'Helados', 'orden' => 2, 'comment' => 'Helados artesanales', 'categories_id' => 3, 'visible' => true]);
        Subcategory::create(['name' => 'Pasteles', 'orden' => 3, 'comment' => 'Pasteles deliciosos', 'categories_id' => 3, 'visible' => true]);

        Subcategory::create(['name' => 'Refrescos', 'orden' => 1, 'comment' => 'Bebidas frías', 'categories_id' => 4, 'visible' => true]);
        Subcategory::create(['name' => 'Cafés', 'orden' => 2, 'comment' => 'Cafés y tés', 'categories_id' => 4, 'visible' => true]);
        Subcategory::create(['name' => 'Jugos', 'orden' => 3, 'comment' => 'Jugos naturales', 'categories_id' => 4, 'visible' => true]);
        
        Subcategory::create(['name' => 'Papas fritas', 'orden' => 1, 'comment' => 'Papas fritas y más', 'categories_id' => 5, 'visible' => true]);
        Subcategory::create(['name' => 'Verduras', 'orden' => 2, 'comment' => 'Guarniciones de verduras', 'categories_id' => 5, 'visible' => true]);
        Subcategory::create(['name' => 'Arroz', 'orden' => 3, 'comment' => 'Diversos tipos de arroz', 'categories_id' => 5, 'visible' => true]);
    
    }
}
