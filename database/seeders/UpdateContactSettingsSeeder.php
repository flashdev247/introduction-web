<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Seeder;

class UpdateContactSettingsSeeder extends Seeder
{
    public function run(): void
    {
        ContactSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'ULIHU',
                'zalo' => '84901234567',
                'hotline' => '0901234567',
                'phone' => '0901234567',
            ]
        );
    }
}