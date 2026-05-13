<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $productImages = [
            'https://images.squarespace-cdn.com/content/v1/624b503d84c2ba7dc187a92a/1649102915554-HKBHY3P2SYVIXVMQA7ZX/ulihu-blue-linen-tunic_0308-v1-FINAL-copy.jpg?format=500w',
            'https://images.squarespace-cdn.com/content/v1/624b503d84c2ba7dc187a92a/1649102915564-4QL4NUG7FVMI73EP5OOL/ulihu-blue-linen-tunic_DETAIL.jpg?format=500w',
        ];

        $categories = Category::all();
        if ($categories->count() === 0) {
            $categories = collect([
                Category::create(['name' => 'Chung', 'description' => 'Danh mục chung']),
            ]);
        }

        $count = 300;

        for ($i = 0; $i < $count; $i++) {
            $name = ucfirst($faker->words($faker->numberBetween(2,4), true));
            $description = '<p>' . implode('</p><p>', $faker->paragraphs(2)) . '</p>';
            $price = $faker->numberBetween(20000, 500000);
            $images = $faker->randomElements($productImages, $faker->numberBetween(1,3));
            $category = $categories->random();

            Product::create([
                'name' => $name,
                'category_id' => $category->id,
                'price' => $price,
                'description' => $description,
                'images' => $images,
                'is_featured' => $faker->boolean(10),
                'is_active' => true,
            ]);
        }
    }
}
