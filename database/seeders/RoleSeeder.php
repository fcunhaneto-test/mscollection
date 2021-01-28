<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assinante = [
            'id' => 10,
            'role' => 'subscriber',
            'description' => 'Assinante pode ler o frontend, comentar e dar notas.'
        ];

        Role::create($assinante);

        $admin = [
            'id' => 90,
            'role' => 'admin',
            'description' => 'Administrador poder total.'
        ];

        Role::create($admin);

        $writer = [
            'id' => 30,
            'role' => 'writer',
            'description' => 'Administrador poder total.'
        ];

        Role::create($writer);
    }
}
