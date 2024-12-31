<?php

namespace Database\Seeders;
use App\Models\Dishes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dishes::create(['name' => 'Sopa de pollo', 'price' => 5.99, 'ingredients' => 'Pollo, fideos, verduras', 'subcategory_id' => 1, 'visible' => true]);
        Dishes::create(['name' => 'Sopa de tomate', 'price' => 4.99, 'ingredients' => 'Tomate, albahaca, crema', 'subcategory_id' => 1, 'visible' => true]);
        Dishes::create(['name' => 'Ensalada César', 'price' => 7.99, 'ingredients' => 'Lechuga, croutons, parmesano, aderezo césar', 'subcategory_id' => 2, 'visible' => true]);
        Dishes::create(['name' => 'Ensalada Griega', 'price' => 6.99, 'ingredients' => 'Pepino, tomate, queso feta, aceitunas', 'subcategory_id' => 2, 'visible' => true]);
        Dishes::create(['name' => 'Bruschetta', 'price' => 5.49, 'ingredients' => 'Pan, tomate, albahaca, aceite de oliva', 'subcategory_id' => 3, 'visible' => true]);

        Dishes::create(['name' => 'Bistec a la parrilla', 'price' => 14.99, 'ingredients' => 'Carne de res, sal, pimienta', 'subcategory_id' => 4, 'visible' => true]);
        Dishes::create(['name' => 'Costillas BBQ', 'price' => 16.99, 'ingredients' => 'Costillas de cerdo, salsa BBQ', 'subcategory_id' => 4, 'visible' => true]);
        Dishes::create(['name' => 'Salmón al horno', 'price' => 12.99, 'ingredients' => 'Salmón, limón, eneldo', 'subcategory_id' => 5, 'visible' => true]);
        Dishes::create(['name' => 'Tilapia frita', 'price' => 10.99, 'ingredients' => 'Tilapia, harina, aceite', 'subcategory_id' => 5, 'visible' => true]);
        Dishes::create(['name' => 'Spaghetti Carbonara', 'price' => 11.99, 'ingredients' => 'Pasta, panceta, huevo, parmesano', 'subcategory_id' => 6, 'visible' => true]);
        Dishes::create(['name' => 'Lasagna', 'price' => 13.99, 'ingredients' => 'Pasta, carne, queso, salsa de tomate', 'subcategory_id' => 6, 'visible' => true]);
        Dishes::create(['name' => 'Risotto de hongos', 'price' => 12.99, 'ingredients' => 'Arroz, hongos, parmesano', 'subcategory_id' => 7, 'visible' => true]);

        Dishes::create(['name' => 'Tarta de manzana', 'price' => 4.99, 'ingredients' => 'Manzana, masa, canela', 'subcategory_id' => 8, 'visible' => true]);
        Dishes::create(['name' => 'Tarta de limón', 'price' => 5.49, 'ingredients' => 'Limón, masa, merengue', 'subcategory_id' => 8, 'visible' => true]);
        Dishes::create(['name' => 'Helado de vainilla', 'price' => 3.99, 'ingredients' => 'Leche, vainilla, azúcar', 'subcategory_id' => 9, 'visible' => true]);
        Dishes::create(['name' => 'Helado de chocolate', 'price' => 4.49, 'ingredients' => 'Leche, chocolate, azúcar', 'subcategory_id' => 9, 'visible' => true]);
        Dishes::create(['name' => 'Pastel de chocolate', 'price' => 5.99, 'ingredients' => 'Chocolate, harina, azúcar, huevos', 'subcategory_id' => 10, 'visible' => true]);
        Dishes::create(['name' => 'Cheesecake', 'price' => 6.49, 'ingredients' => 'Queso crema, galletas, azúcar', 'subcategory_id' => 10, 'visible' => true]);

        Dishes::create(['name' => 'Coca-Cola', 'price' => 1.99, 'ingredients' => 'Bebida gaseosa', 'subcategory_id' => 11, 'visible' => true]);
        Dishes::create(['name' => 'Limonada', 'price' => 2.49, 'ingredients' => 'Limón, agua, azúcar', 'subcategory_id' => 11, 'visible' => true]);
        Dishes::create(['name' => 'Café americano', 'price' => 1.49, 'ingredients' => 'Café, agua', 'subcategory_id' => 12, 'visible' => true]);
        Dishes::create(['name' => 'Café con leche', 'price' => 1.99, 'ingredients' => 'Café, leche', 'subcategory_id' => 12, 'visible' => true]);
        Dishes::create(['name' => 'Jugo de naranja', 'price' => 2.99, 'ingredients' => 'Naranjas', 'subcategory_id' => 13, 'visible' => true]);
        Dishes::create(['name' => 'Jugo de mango', 'price' => 3.49, 'ingredients' => 'Mangos', 'subcategory_id' => 13, 'visible' => true]);

        Dishes::create(['name' => 'Papas fritas', 'price' => 2.99, 'ingredients' => 'Papas, aceite, sal', 'subcategory_id' => 14, 'visible' => true]);
        Dishes::create(['name' => 'Aros de cebolla', 'price' => 3.49, 'ingredients' => 'Cebolla, harina, aceite', 'subcategory_id' => 14, 'visible' => true]);
        Dishes::create(['name' => 'Verduras al vapor', 'price' => 4.99, 'ingredients' => 'Brócoli, zanahorias, coliflor', 'subcategory_id' => 15, 'visible' => true]);
        Dishes::create(['name' => 'Ensalada de col', 'price' => 3.99, 'ingredients' => 'Col, zanahoria, mayonesa', 'subcategory_id' => 15, 'visible' => true]);
        Dishes::create(['name' => 'Arroz blanco', 'price' => 2.49, 'ingredients' => 'Arroz, agua, sal', 'subcategory_id' => 16, 'visible' => true]);
        Dishes::create(['name' => 'Arroz con vegetales', 'price' => 3.99, 'ingredients' => 'Arroz, verduras, salsa de soja', 'subcategory_id' => 16, 'visible' => true]);
    
    }
}
