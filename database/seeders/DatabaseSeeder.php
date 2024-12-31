<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Dishes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'PabloEcommerce',
        //     'email' => 'pabloEcommerce@pabloEcommerce.com',
        // ]);
        $this->call([
            CategoriesSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            SubcategorySeeder::class,
            DishesSeeder::class,
        ]);
    }
}
