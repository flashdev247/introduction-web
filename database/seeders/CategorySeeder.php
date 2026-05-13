<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $count = 40;

        for ($i = 1; $i <= $count; $i++) {
            Category::create([
                'name' => 'Danh mục ' . $i . ' - ' . ucfirst($faker->words($faker->numberBetween(1, 2), true)),
                'description' => $faker->sentence($faker->numberBetween(8, 16)),
                'image' => null,
                'is_active' => $faker->boolean(90),
            ]);
        }
    }
}