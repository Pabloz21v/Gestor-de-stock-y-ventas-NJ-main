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
        Subcategory::create(['name' => 'Smartphones', 'orden' => 1, 'comment' => 'Sopas calientes', 'categories_id' => 1, 'visible' => true]);
        Subcategory::create(['name' => 'Computadoras y Laptops', 'orden' => 2, 'comment' => 'Frescas y ligeras', 'categories_id' => 1, 'visible' => true]);
        Subcategory::create(['name' => 'Televisores', 'orden' => 3, 'comment' => 'Pequeños bocados', 'categories_id' => 1, 'visible' => true]);

        Subcategory::create(['name' => 'Ropa de Hombre', 'orden' => 1, 'comment' => 'Carnes a la parrilla', 'categories_id' => 2, 'visible' => true]);
        Subcategory::create(['name' => 'Ropa de Mujer', 'orden' => 2, 'comment' => 'Pescados frescos', 'categories_id' => 2, 'visible' => true]);
        Subcategory::create(['name' => 'Calzado', 'orden' => 3, 'comment' => 'Pasta hecha a mano', 'categories_id' => 2, 'visible' => true]);
        Subcategory::create(['name' => 'Accesorios', 'orden' => 4, 'comment' => 'Productos vegetarianos', 'categories_id' => 2, 'visible' => true]);

        Subcategory::create(['name' => 'Muebles', 'orden' => 1, 'comment' => 'Tartas caseras', 'categories_id' => 3, 'visible' => true]);
        Subcategory::create(['name' => 'Decoración', 'orden' => 2, 'comment' => 'Helados artesanales', 'categories_id' => 3, 'visible' => true]);
        Subcategory::create(['name' => 'Jardinería', 'orden' => 3, 'comment' => 'Pasteles deliciosos', 'categories_id' => 3, 'visible' => true]);
        Subcategory::create(['name' => 'Electrodomésticos', 'orden' => 3, 'comment' => 'Pasteles deliciosos', 'categories_id' => 3, 'visible' => true]);

        Subcategory::create(['name' => 'Equipos de Gimnasio', 'orden' => 1, 'comment' => 'Bebidas frías', 'categories_id' => 4, 'visible' => true]);
        Subcategory::create(['name' => 'Ropa Deportiva', 'orden' => 2, 'comment' => 'Cafés y tés', 'categories_id' => 4, 'visible' => true]);
        Subcategory::create(['name' => 'Accesorios Deportivos', 'orden' => 3, 'comment' => 'Jugos naturales', 'categories_id' => 4, 'visible' => true]);

        Subcategory::create(['name' => 'Maquillaje', 'orden' => 1, 'comment' => 'Papas fritas y más', 'categories_id' => 5, 'visible' => true]);
        Subcategory::create(['name' => 'Cuidado de la Piel', 'orden' => 2, 'comment' => 'Guarniciones de verduras', 'categories_id' => 5, 'visible' => true]);
        Subcategory::create(['name' => 'Cuidado del Cabello', 'orden' => 3, 'comment' => 'Diversos tipos de arroz', 'categories_id' => 5, 'visible' => true]);

        Subcategory::create(['name' => 'Juguetes Educativos', 'orden' => 1, 'comment' => 'Papas fritas y más', 'categories_id' => 6, 'visible' => true]);
        Subcategory::create(['name' => 'Juegos de Mesa', 'orden' => 2, 'comment' => 'Guarniciones de verduras', 'categories_id' => 6, 'visible' => true]);
        Subcategory::create(['name' => 'Juguetes de Peluche', 'orden' => 3, 'comment' => 'Diversos tipos de arroz', 'categories_id' => 6, 'visible' => true]);

        Subcategory::create(['name' => 'Libros de Ficción', 'orden' => 1, 'comment' => 'Papas fritas y más', 'categories_id' => 7, 'visible' => true]);
        Subcategory::create(['name' => 'Libros de No Ficción', 'orden' => 2, 'comment' => 'Guarniciones de verduras', 'categories_id' => 7, 'visible' => true]);
        Subcategory::create(['name' => 'Revistas', 'orden' => 3, 'comment' => 'Diversos tipos de arroz', 'categories_id' => 7, 'visible' => true]);

        Subcategory::create(['name' => 'Productos Lácteos', 'orden' => 1, 'comment' => 'Papas fritas y más', 'categories_id' => 8, 'visible' => true]);
        Subcategory::create(['name' => 'Carnes y Pescados', 'orden' => 2, 'comment' => 'Guarniciones de verduras', 'categories_id' => 8, 'visible' => true]);
        Subcategory::create(['name' => 'Frutas y Verduras', 'orden' => 3, 'comment' => 'Diversos tipos de arroz', 'categories_id' => 8, 'visible' => true]);
        Subcategory::create(['name' => 'Bebidas', 'orden' => 3, 'comment' => 'Diversos tipos de arroz', 'categories_id' => 8, 'visible' => true]);
    }
}
