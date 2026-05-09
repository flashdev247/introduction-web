<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class UpdateContactSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Shopping Online',
            'zalo' => '84901234567',
            'hotline' => '0901234567',
            'phone' => '0901234567',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
