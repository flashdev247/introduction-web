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

        $productImages = [
            'https://images.squarespace-cdn.com/content/v1/624b503d84c2ba7dc187a92a/1649102915554-HKBHY3P2SYVIXVMQA7ZX/ulihu-blue-linen-tunic_0308-v1-FINAL-copy.jpg?format=500w',
            'https://images.squarespace-cdn.com/content/v1/624b503d84c2ba7dc187a92a/1649102915564-4QL4NUG7FVMI73EP5OOL/ulihu-blue-linen-tunic_DETAIL.jpg?format=500w',
        ];

        $women = Category::create(['name' => 'Nữ', 'description' => 'Bộ sưu tập dành cho nữ']);
        $tops = Category::create(['name' => 'Áo', 'description' => 'Bộ sưu tập áo']);
        $bottoms = Category::create(['name' => 'Quần / Chân váy', 'description' => 'Bộ sưu tập quần và chân váy']);

        $products = [
            ['name' => 'Áo tunic Lounge - xám than lụa linen', 'category_id' => $tops->id, 'price' => 185000, 'description' => '<p>Mẫu tunic dáng rũ màu xám than, dễ mặc và thoải mái khi phối lớp.</p><p>Chất lụa linen mang lại bề mặt lì tinh tế, phom mềm và thoáng khí, phù hợp từ công sở đến những buổi tối cuối tuần.</p><ul><li>Phom dáng thoải mái</li><li>Vải lụa linen thoáng nhẹ</li><li>Dễ phối cùng quần tây</li></ul>', 'is_featured' => true, 'images' => $productImages],
            ['name' => 'Áo crop linen xanh', 'category_id' => $tops->id, 'price' => 120000, 'description' => '<p>Áo crop nhẹ nhàng làm từ linen với phom gọn gàng và sắc xanh tươi mới.</p><p>Phù hợp cho ngày nóng, dễ phối cùng quần cạp cao và mang lại vẻ ngoài chỉn chu nhưng thoải mái.</p>', 'is_featured' => true, 'images' => $productImages],
            ['name' => 'Áo tunic linen xanh', 'category_id' => $tops->id, 'price' => 165000, 'description' => '<p>Áo tunic linen xanh mang đến phom oversized thoải mái với độ rũ tự nhiên.</p><p>Đây là mẫu dễ phối theo nhiều cách: thả suông, thắt eo hoặc layer cùng quần slim để tạo vẻ mềm mại.</p>', 'images' => $productImages],
            ['name' => 'Quần short dài linen xanh', 'category_id' => $bottoms->id, 'price' => 135000, 'description' => '<p>Thiết kế dành cho trang phục hằng ngày, mẫu quần short dài này cân bằng giữa sự thoải mái và cấu trúc với phom relax, đường may gọn và chất linen thoáng.</p><p>Kết quả là một item dễ mặc nhưng vẫn giữ được vẻ cao cấp.</p>', 'images' => $productImages],
            ['name' => 'Áo poplin trắng dáng chef', 'category_id' => $tops->id, 'price' => 140000, 'description' => '<p>Áo poplin trắng có phom đứng, mang lại vẻ ngoài gọn gàng, tinh tế và rất linh hoạt.</p><p>Chất vải sắc nét cùng dáng áo chuẩn giúp item này dễ kết hợp cho cả phong cách chỉn chu lẫn tối giản.</p>', 'images' => $productImages],
            ['name' => 'Áo oversize Lisa - xanh navy', 'category_id' => $tops->id, 'price' => 155000, 'description' => '<p>Với phom rộng rãi, chiếc áo navy này mang lại cảm giác thoải mái nhưng vẫn giữ vẻ hiện đại và chỉn chu.</p><p>Có thể mặc như một item nổi bật hoặc dùng làm lớp layer nhẹ nhàng.</p>', 'images' => $productImages],
            ['name' => 'Quần Jacky phối màu cạp', 'category_id' => $bottoms->id, 'price' => 160000, 'description' => '<p>Mẫu quần này nổi bật với phần cạp phối màu đặc trưng và phom dáng may đo, phù hợp cả đi làm lẫn đi chơi.</p><p>Chi tiết tương phản tạo điểm nhấn nhưng tổng thể vẫn giữ được sự tinh tế.</p>', 'images' => $productImages],
            ['name' => 'Chân váy xếp ly dài - đen', 'category_id' => $bottoms->id, 'price' => 145000, 'description' => '<p>Chân váy xếp ly dài tạo độ chuyển động và kết cấu, mang đến nền đen linh hoạt cho nhiều kiểu phối.</p><p>Phom dáng bay nhẹ giúp bạn dễ nâng tầm outfit với áo đứng phom hoặc giữ vẻ casual khi phối layer thoải mái.</p>', 'images' => $productImages],
            ['name' => 'Quần Romy', 'category_id' => $bottoms->id, 'price' => 130000, 'description' => '<p>Quần Romy được thiết kế theo hướng tối giản, dễ phối và thoải mái cho nhu cầu sử dụng hằng ngày.</p><p>Phom đơn giản giúp mẫu quần này trở thành nền tảng đáng tin cậy cho tủ đồ ưu tiên đường nét gọn gàng.</p>', 'images' => $productImages],
            ['name' => 'Đầm Natural', 'category_id' => $women->id, 'price' => 195000, 'description' => '<p>Chiếc đầm này tạo nên vẻ ngoài nhẹ nhàng nhờ tông màu mềm, phom tôn dáng và cảm giác mỏng nhẹ.</p><p>Đây là mẫu lý tưởng cho mặc hằng ngày, đi du lịch hoặc những dịp cần vẻ đẹp tinh tế, tiết chế.</p>', 'is_featured' => true, 'images' => $productImages],
            ['name' => 'Đầm Sonia - màu đất nung', 'category_id' => $women->id, 'price' => 210000, 'description' => '<p>Đầm Sonia kết hợp màu đất nung ấm với đường nét mượt mà, tạo nên một item vừa thanh lịch vừa dễ mặc.</p><p>Tông màu ấm và phom cân đối giúp mẫu đầm này phù hợp từ ban ngày đến buổi tối.</p>', 'images' => $productImages],
            ['name' => 'Chân váy Sonia - xám', 'category_id' => $bottoms->id, 'price' => 140000, 'description' => '<p>Chân váy xám hiện đại, dễ phối đồ, chuyển động gọn và mang lại vẻ đẹp tinh giản nhưng vẫn nâng tầm.</p><p>Màu trung tính khiến đây trở thành một item rất mạnh cho phong cách tối giản lẫn layer nhiều lớp.</p>', 'images' => $productImages],
            ['name' => 'Quần ống rộng - màu tự nhiên', 'category_id' => $bottoms->id, 'price' => 150000, 'description' => '<p>Mẫu quần ống rộng này có độ rũ mềm và cảm giác thoải mái, rất hợp làm nền cho các outfit tối giản.</p><p>Tông màu tự nhiên giúp tổng thể nhẹ nhàng, linh hoạt và dễ mặc quanh năm.</p>', 'images' => $productImages],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['is_active' => true]));
        }
    }
}
