<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            UpdateContactSettingsSeeder::class,
        ]);

        $women = Category::create(['name' => 'Women', 'description' => 'Women collection']);
        $tops = Category::create(['name' => 'Tops', 'description' => 'Tops collection']);
        $bottoms = Category::create(['name' => 'Bottoms', 'description' => 'Bottoms collection']);

        $products = [
            ['name' => 'Lounge Tunic - Charcoal Silk Linen', 'category_id' => $tops->id, 'price' => 185.00, 'description' => '<p>A fluid charcoal tunic designed for easy layering and long-wear comfort.</p><p>The silk-linen blend gives it a refined matte finish, soft structure, and a breathable feel that works from office hours to weekend dinners.</p><ul><li>Relaxed silhouette</li><li>Breathable silk-linen fabric</li><li>Easy to style with tailored trousers</li></ul>', 'is_featured' => true, 'images' => ['/assets/product-detail/ulihu-charcoal-silk-linen-tunic_0326-v1-FINAL-copy.jpg', '/assets/product-detail/ulihu-charcoal-silk-linen-tunic_DETAIL.jpg']],
            ['name' => 'Blue Linen Crop Top', 'category_id' => $tops->id, 'price' => 120.00, 'description' => '<p>A lightweight cropped top made from linen with a clean silhouette and a fresh blue tone.</p><p>It is built for warm days, easy pairing with high-waisted bottoms, and a polished casual look.</p>', 'is_featured' => true, 'images' => ['/assets/shop/ulihu-blue-linen-crop-top_0320-v1-FINAL-1-copy.jpg', '/assets/shop/ulihu-blue-linen-crop-top_DETAIL.jpg']],
            ['name' => 'Blue Linen Tunic', 'category_id' => $tops->id, 'price' => 165.00, 'description' => '<p>This blue linen tunic offers a comfortable oversized fit with a polished drape.</p><p>It is a versatile piece that can be styled loose, belted, or layered over slim trousers for a soft tailored effect.</p>', 'images' => ['/assets/shop/ulihu-blue-linen-tunic_0308-v1-FINAL-copy.jpg', '/assets/shop/ulihu-blue-linen-tunic_DETAIL.jpg']],
            ['name' => 'Blue Linen Long Shorts', 'category_id' => $bottoms->id, 'price' => 135.00, 'description' => '<p>Made for versatile daily wear, these long shorts balance comfort and structure with a relaxed fit, clean tailoring, and a breathable linen texture.</p><p>The result is a piece that stays easy and elevated throughout the day.</p>', 'images' => ['/assets/shop/ulihu-blue-linen-long-short_0346-v1-FINAL-copy.jpg', '/assets/shop/ulihu-blue-linen-long-short_DETAIL.jpg']],
            ['name' => 'Poplin Chef Shirt - White', 'category_id' => $tops->id, 'price' => 140.00, 'description' => '<p>A structured white poplin shirt that brings a clean, elevated look with timeless versatility.</p><p>The crisp fabric and neat shape make it an easy piece for both smart and minimal styling.</p>', 'images' => ['/assets/shop/kimem-poplin-chef-shirt-white_0304-v1-FINAL-copy.jpg', '/assets/shop/kimem-poplin-chef-shirt-white_DETAIL.jpg']],
            ['name' => 'Lisa Oversized Shirt - Navy', 'category_id' => $tops->id, 'price' => 155.00, 'description' => '<p>Cut in a roomy silhouette, this navy shirt delivers relaxed comfort while keeping a polished and contemporary appearance.</p><p>It works as a statement top or an effortless layering piece.</p>', 'images' => ['/assets/shop/kimem-lisa-oversized-shirt-navy_0363-v1-FINAL-copy.jpg', '/assets/shop/kimem-lisa-oversized-shirt-navy_DETAIL.jpg']],
            ['name' => 'Jacky Bicolor Waist Trousers', 'category_id' => $bottoms->id, 'price' => 160.00, 'description' => '<p>These trousers feature a distinctive bicolor waist design and a tailored shape that works for both office and casual styling.</p><p>The contrast detail adds interest while keeping the overall look refined.</p>', 'images' => ['/assets/shop/kimem-jacky-bicolor-waist-trousers-navy-black_0374-v1-FINAL-copy.jpg', '/assets/shop/kimem-jacky-bicolor-waist-trousers-navy-black_DETAIL.jpg']],
            ['name' => 'Long Pleated Skirt - Black', 'category_id' => $bottoms->id, 'price' => 145.00, 'description' => '<p>A long pleated skirt that adds movement and texture, offering a versatile black base for refined styling.</p><p>Its flowing shape makes it easy to dress up with structured tops or keep casual with relaxed layers.</p>', 'images' => ['/assets/shop/kimem-long-pleated-skirt-black_0354-v1-FINAL-copy.jpg', '/assets/shop/kimem-long-pleated-skirt-black_DETAIL.jpg']],
            ['name' => 'Romy Trousers', 'category_id' => $bottoms->id, 'price' => 130.00, 'description' => '<p>Romy trousers are designed with a minimal, easy-to-style look and a comfortable fit for daily use.</p><p>The simple silhouette makes them a dependable base for wardrobes that favor clean lines.</p>', 'images' => ['/assets/shop/kimem-romy-trousers_0155-v1-FINAL-copy.jpg', '/assets/shop/kimem-romy-trousers_DETAIL.jpg']],
            ['name' => 'Natural Dress', 'category_id' => $women->id, 'price' => 195.00, 'description' => '<p>This natural dress creates an effortless look through its soft tone, flattering cut, and lightweight feel.</p><p>It is an easy dress for daily wear, travel, and occasions where understated elegance matters.</p>', 'is_featured' => true, 'images' => ['/assets/shop/lauren-winter-natural-dress_0172-v1-FINAL-copy.jpg', '/assets/shop/lauren-winter-natural-dress_DETAIL.jpg']],
            ['name' => 'Sonia Dress - Terracotta', 'category_id' => $women->id, 'price' => 210.00, 'description' => '<p>The Sonia dress pairs a rich terracotta color with a smooth silhouette for an elegant yet wearable statement piece.</p><p>Its warm tone and balanced shape make it ideal for day-to-night dressing.</p>', 'images' => ['/assets/shop/lauren-winter-sonia-dress-terracotta_0228-v1-FINAL-copy.jpg', '/assets/shop/lauren-winter-sonia-dress-terracotta_DETAIL.jpg']],
            ['name' => 'Sonia Skirt - Grey', 'category_id' => $bottoms->id, 'price' => 140.00, 'description' => '<p>A modern grey skirt designed for easy pairing, clean movement, and an understated elevated look.</p><p>The neutral color makes it a strong styling piece for both minimal and layered outfits.</p>', 'images' => ['/assets/shop/lauren-winter-sonia-skirt-grey_0270-v1-FINAL-copy.jpg', '/assets/shop/lauren-winter-sonia-skirt-grey_DETAIL.jpg']],
            ['name' => 'Wide Pant - Natural', 'category_id' => $bottoms->id, 'price' => 150.00, 'description' => '<p>These wide pants offer a soft drape and comfortable fit, making them a strong foundation for minimalist outfits.</p><p>The natural tone keeps the look calm, versatile, and easy to style across seasons.</p>', 'images' => ['/assets/shop/lauren-winter-wide-pant-natural_0178-v1-FINAL.jpg', '/assets/shop/lauren-winter-wide-pant-natural_DETAIL.jpg']],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['is_active' => true]));
        }
    }
}
