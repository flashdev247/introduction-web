<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ContactSetting;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        ContactSetting::create([
            'site_name' => 'ULIHU',
            'email' => 'hello@ulihu.com',
            'phone' => '+84 123 456 789',
            'address' => 'Ho Chi Minh City, Vietnam',
        ]);

        $women = Category::create(['name' => 'Women', 'description' => 'Women collection']);
        $tops = Category::create(['name' => 'Tops', 'description' => 'Tops collection']);
        $bottoms = Category::create(['name' => 'Bottoms', 'description' => 'Bottoms collection']);

        $products = [
            ['name' => 'Lounge Tunic - Charcoal Silk Linen', 'category_id' => $tops->id, 'price' => 185.00, 'slug' => 'lounge-tunic-charcoal', 'is_featured' => true, 'images' => ['/assets/product-detail/ulihu-charcoal-silk-linen-tunic_0326-v1-FINAL-copy.jpg', '/assets/product-detail/ulihu-charcoal-silk-linen-tunic_DETAIL.jpg']],
            ['name' => 'Blue Linen Crop Top', 'category_id' => $tops->id, 'price' => 120.00, 'slug' => 'blue-linen-crop-top', 'is_featured' => true, 'images' => ['/assets/shop/ulihu-blue-linen-crop-top_0320-v1-FINAL-1-copy.jpg', '/assets/shop/ulihu-blue-linen-crop-top_DETAIL.jpg']],
            ['name' => 'Blue Linen Tunic', 'category_id' => $tops->id, 'price' => 165.00, 'slug' => 'blue-linen-tunic', 'images' => ['/assets/shop/ulihu-blue-linen-tunic_0308-v1-FINAL-copy.jpg', '/assets/shop/ulihu-blue-linen-tunic_DETAIL.jpg']],
            ['name' => 'Blue Linen Long Shorts', 'category_id' => $bottoms->id, 'price' => 135.00, 'slug' => 'blue-linen-long-shorts', 'images' => ['/assets/shop/ulihu-blue-linen-long-short_0346-v1-FINAL-copy.jpg', '/assets/shop/ulihu-blue-linen-long-short_DETAIL.jpg']],
            ['name' => 'Poplin Chef Shirt - White', 'category_id' => $tops->id, 'price' => 140.00, 'slug' => 'poplin-chef-shirt-white', 'images' => ['/assets/shop/kimem-poplin-chef-shirt-white_0304-v1-FINAL-copy.jpg', '/assets/shop/kimem-poplin-chef-shirt-white_DETAIL.jpg']],
            ['name' => 'Lisa Oversized Shirt - Navy', 'category_id' => $tops->id, 'price' => 155.00, 'slug' => 'lisa-oversized-shirt-navy', 'images' => ['/assets/shop/kimem-lisa-oversized-shirt-navy_0363-v1-FINAL-copy.jpg', '/assets/shop/kimem-lisa-oversized-shirt-navy_DETAIL.jpg']],
            ['name' => 'Jacky Bicolor Waist Trousers', 'category_id' => $bottoms->id, 'price' => 160.00, 'slug' => 'jacky-bicolor-waist-trousers', 'images' => ['/assets/shop/kimem-jacky-bicolor-waist-trousers-navy-black_0374-v1-FINAL-copy.jpg', '/assets/shop/kimem-jacky-bicolor-waist-trousers-navy-black_DETAIL.jpg']],
            ['name' => 'Long Pleated Skirt - Black', 'category_id' => $bottoms->id, 'price' => 145.00, 'slug' => 'long-pleated-skirt-black', 'images' => ['/assets/shop/kimem-long-pleated-skirt-black_0354-v1-FINAL-copy.jpg', '/assets/shop/kimem-long-pleated-skirt-black_DETAIL.jpg']],
            ['name' => 'Romy Trousers', 'category_id' => $bottoms->id, 'price' => 130.00, 'slug' => 'romy-trousers', 'images' => ['/assets/shop/kimem-romy-trousers_0155-v1-FINAL-copy.jpg', '/assets/shop/kimem-romy-trousers_DETAIL.jpg']],
            ['name' => 'Natural Dress', 'category_id' => $women->id, 'price' => 195.00, 'slug' => 'natural-dress', 'is_featured' => true, 'images' => ['/assets/shop/lauren-winter-natural-dress_0172-v1-FINAL-copy.jpg', '/assets/shop/lauren-winter-natural-dress_DETAIL.jpg']],
            ['name' => 'Sonia Dress - Terracotta', 'category_id' => $women->id, 'price' => 210.00, 'slug' => 'sonia-dress-terracotta', 'images' => ['/assets/shop/lauren-winter-sonia-dress-terracotta_0228-v1-FINAL-copy.jpg', '/assets/shop/lauren-winter-sonia-dress-terracotta_DETAIL.jpg']],
            ['name' => 'Sonia Skirt - Grey', 'category_id' => $bottoms->id, 'price' => 140.00, 'slug' => 'sonia-skirt-grey', 'images' => ['/assets/shop/lauren-winter-sonia-skirt-grey_0270-v1-FINAL-copy.jpg', '/assets/shop/lauren-winter-sonia-skirt-grey_DETAIL.jpg']],
            ['name' => 'Wide Pant - Natural', 'category_id' => $bottoms->id, 'price' => 150.00, 'slug' => 'wide-pant-natural', 'images' => ['/assets/shop/lauren-winter-wide-pant-natural_0178-v1-FINAL.jpg', '/assets/shop/lauren-winter-wide-pant-natural_DETAIL.jpg']],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['is_active' => true]));
        }
    }
}
