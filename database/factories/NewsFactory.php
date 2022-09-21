<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(100),
            'detail' => '<h1>DESCRIPTION</h1>',
            'category_id' => Category::all()->random()->id,
            'slug' => Str::slug($this->faker->text(100)),
        ];
    }
}
