<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $erica = [
            'name' => 'Erica Cunha',
            'email' => 'erica@gmail.com',
            'role_id' => 10,
            'password' => Hash::make('123456'),
        ];

        User::create($erica);

        $francisco = [
            'name' => 'Francisco Cunha Neto',
            'email' => 'fcunhaneto@gmail.com',
            'role_id' => 90,
            'password' => Hash::make('123456'),
        ];

        User::create($francisco);

        $marcos = [
            'name' => 'Marcos',
            'email' => 'marcos@gmail.com',
            'role_id' => 30,
            'password' => Hash::make('123456'),
        ];

        User::create($marcos);

        $lili = [
            'name' => 'Lilian',
            'email' => 'lili@gmail.com',
            'role_id' => 30,
            'password' => Hash::make('123456'),
        ];

        User::create($lili);
    }
}
