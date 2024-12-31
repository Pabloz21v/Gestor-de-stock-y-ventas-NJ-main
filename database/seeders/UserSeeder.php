<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Leonel',
            'email' => 'admin@admin.com',
            'apellido' => 'Messi',
            'cargo' => 'Campeón',
            'phone' => '2804444444',
            'domicilio' => 'EEUU',
            'password' => Hash::make('admin')
        ]);
        $admin->assignRole('admin');

        $tester = User::create([
            'name' => 'Tester1 full',
            'email' => 'tester1@admin.com',
            'apellido' => 'tester1',
            'cargo' => 'testear',
            'phone' => '280455555',
            'domicilio' => 'Argentino',
            'password' => Hash::make('admin')
        ]);
        $tester->assignRole('admin');

        $tester = User::create([
            'name' => 'Tester2 full',
            'email' => 'tester2@admin.com',
            'apellido' => 'tester2',
            'cargo' => 'testear2',
            'phone' => '280455555',
            'domicilio' => 'Argentino2',
            'password' => Hash::make('admin')
        ]);
        $tester->assignRole('admin');

        $editor = User::create([
            'name' => 'Pablo',
            'email' => 'editor@editor.com',
            'apellido' => 'Aceve',
            'cargo' => 'Dev',
            'phone' => '2804844443',
            'domicilio' => 'Arg Pto Madryn',
            'password' => Hash::make('editor')
        ]);
        $editor->assignRole('editor');

        // User::create([
        //     'name' => 'user',
        //     'email' => 'user@user.com',
        //     'apellido' => 'user',
        //     'phone' => '2804844444',
        //     'domicilio' => 'tu dire',
        //     'password' => Hash::make('editor')
        // ]);
    }
}
