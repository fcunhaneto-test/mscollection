<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Qualifiers\Category;
use Illuminate\Database\Eloquent\Factories\Factory;


class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $movie = $this->moviesTitle();
        $title = $movie['title'];
        $year = $movie['year'];
        return [
            'title' => $title,
            'original_title' => $title,
            'year' => $year,
            'time' => $this->createTime(),
            'category_1' => $this->getCategory(),
            'category_2' => $this->getCategory(),
            'rating' => random_int(1, 5),
            'synopsis' => $this->faker->realText($maxNbChars = 600, $indexSize = 3),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function moviesTitle() {
        $movies_file = file_get_contents("/home/francisco/Projetos/Phpstorm/mscollection/database/factories/movies1960.json");
        $movies_array = json_decode($movies_file, true);
        $end = count($movies_array) - 1;
        $index = random_int(0, $end);
        return $movies_array[$index];
    }

    public function createTime()
    {
        $hour = random_int(1, 2);
        $minutes = random_int(0, 59);
        if ($minutes < 10) {
            return '0' . strval($hour) . ':0' . strval($minutes);
        }
        return '0' . strval($hour) . ':' . strval($minutes);
    }

    public function getCategory()
    {
        $id = random_int(1, 23);
        $category = Category::find($id);
        return $category->name;
    }
}
