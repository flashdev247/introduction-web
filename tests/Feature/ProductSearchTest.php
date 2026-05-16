<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_search_products_on_products_page(): void
    {
        Product::create([
            'name' => 'Van Công Nghiệp',
            'description' => 'Dùng cho hệ thống nước',
            'price' => 100000,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Ống thép',
            'description' => 'Kích thước tiêu chuẩn',
            'price' => 200000,
            'is_active' => true,
        ]);

        $response = $this->get('/products?q=Van');

        $response->assertOk();
        $response->assertSee('Van Công Nghiệp');
        $response->assertDontSee('Ống thép');
    }

    public function test_inactive_product_is_visible_with_out_of_stock_label_for_user(): void
    {
        $product = Product::create([
            'name' => 'Máy bơm mini',
            'description' => 'Sản phẩm tạm ngưng',
            'price' => 300000,
            'is_active' => false,
        ]);

        $this->get('/products')
            ->assertOk()
            ->assertSee('Máy bơm mini')
            ->assertSee('Hết hàng');

        $this->get('/products/'.$product->id)
            ->assertOk()
            ->assertSee('Hết hàng')
            ->assertDontSee('Thêm vào giỏ hàng');
    }

    public function test_admin_can_search_products_on_admin_list_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        Product::create([
            'name' => 'Khớp nối nhanh',
            'description' => 'Sản phẩm A',
            'price' => 100000,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Bulong inox',
            'description' => 'Sản phẩm B',
            'price' => 150000,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.products.index', ['q' => 'Khớp']));

        $response->assertOk();
        $response->assertSee('Khớp nối nhanh');
        $response->assertDontSee('Bulong inox');
    }
}
