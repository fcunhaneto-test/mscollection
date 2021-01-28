<?php

namespace Database\Seeders;

use App\Models\Qualifiers\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Ação', 'slug' => 'acao'],
            ['name' => 'Adulto', 'slug' => 'adulto'],
            ['name' => 'Animação', 'slug' => 'animate'],
            ['name' => 'Aventura', 'slug' => 'aventura'],
            ['name' => 'Biografia', 'slug' => 'bio'],
            ['name' => 'Comédia', 'slug' => 'comedia'],
            ['name' => 'Crime', 'slug' => 'crime'],
            ['name' => 'Documentário', 'slug' => 'doc'],
            ['name' => 'Drama', 'slug' => 'drama'],
            ['name' => 'Esporte', 'slug' => 'esporte'],
            ['name' => 'Família', 'slug' => 'familia'],
            ['name' => 'Fantasia', 'slug' => 'fantasia'],
            ['name' => 'Faroeste', 'slug' => 'faroeste'],
            ['name' => 'Ficção Científica', 'slug' => 'fici'],
            ['name' => 'Film Noir', 'slug' => 'noir'],
            ['name' => 'Guerra', 'slug' => 'guerra'],
            ['name' => 'Histórico', 'slug' => 'historia'],
            ['name' => 'Mistério', 'slug' => 'misterio'],
            ['name' => 'Musical', 'slug' => 'musical'],
            ['name' => 'Policial', 'slug' => 'policial'],
            ['name' => 'Suspense', 'slug' => 'suspense'],
            ['name' => 'Terror', 'slug' => 'terror'],
            ['name' => 'Thriller', 'slug' => 'thriller']
        ];

        foreach ($categories as $arr) {
            Category::create($arr);
        }
    }
}
