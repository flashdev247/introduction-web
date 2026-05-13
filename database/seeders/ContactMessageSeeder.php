<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        $subjects = [
            'Tư vấn sản phẩm',
            'Hỏi về giá sỉ',
            'Kiểm tra tình trạng đơn hàng',
            'Yêu cầu báo giá',
            'Phản hồi dịch vụ',
            'Hỗ trợ thanh toán',
            'Hỏi về chính sách đổi trả',
            'Liên hệ hợp tác',
        ];

        $count = 60;

        for ($i = 1; $i <= $count; $i++) {
            ContactMessage::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'subject' => $faker->randomElement($subjects) . ' #' . $i,
                'message' => implode("\n\n", $faker->paragraphs($faker->numberBetween(2, 4))),
                'is_read' => $faker->boolean(65),
            ]);
        }
    }
}