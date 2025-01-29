<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Products;

class SalesSeeder extends Seeder
{
    public function run()
    {
        // Obtener usuarios y productos existentes
        $users = User::all()->pluck('id')->toArray();
        $products = Products::all()->pluck('id')->toArray();

        // Crear 10 registros de ejemplo
        for ($i = 0; $i < 10; $i++) {
            DB::table('sales')->insert([
                'reg' => Str::random(10),
                'cliente' => 'Cliente ' . ($i + 1),
                'contacto' => 'Contacto ' . ($i + 1),
                'vendedor' => $users[array_rand($users)],
                'producto' => $products[array_rand($products)],
                'precio' => rand(10, 1000),
                'unidades' => rand(1, 10),
                'entrada' => rand(0, 100),
                'pendiente' => rand(0, 100),
                'sub_total' => rand(10, 1000),
                'estado' => $this->getRandomState(),
                'sobreprecio' => rand(0, 100),
                'observacion' => 'Observación ' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function getRandomState()
    {
        $states = ['ENTREGADO', 'PENDIENTE', 'CANCELADO', 'EN_PREPARACION', 'VERIFICANDO', 'CONSIGNA'];
        return $states[array_rand($states)];
    }
}
// inyectar mas ventas
// php artisan db:seed --class=SalesSeeder