<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        Category::factory(100)->create();
        News::factory(100000)->create();
    }
}
