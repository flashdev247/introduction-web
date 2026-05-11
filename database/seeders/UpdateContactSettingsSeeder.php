<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class UpdateContactSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'HTTM VIETNAM',
            'zalo' => '84901234567',
            'phone' => '0901234567',
            'shopee' => 'https://shopee.vn/your-shop',
            'email' => 'contact@shoppingonline.com',
            'address' => '123 Đường Chính, Thành phố, Việt Nam',
            'contact_info' => 'Vui lòng liên hệ với chúng tôi qua email hoặc điện thoại.'
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
