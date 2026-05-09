<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Migrate data from contact_settings if it exists
        if (Schema::hasTable('contact_settings')) {
            $contactSetting = DB::table('contact_settings')->first();
            if ($contactSetting) {
                $settings = [
                    'site_name' => $contactSetting->site_name ?? 'Your Site Title',
                    'logo' => $contactSetting->logo ?? '',
                    'email' => $contactSetting->email ?? '',
                    'phone' => $contactSetting->phone ?? '',
                    'zalo' => $contactSetting->zalo ?? '',
                    'hotline' => $contactSetting->hotline ?? '',
                    'address' => $contactSetting->address ?? '',
                    'contact_info' => $contactSetting->contact_info ?? '',
                ];

                foreach ($settings as $key => $value) {
                    DB::table('settings')->insert([
                        'key' => $key,
                        'value' => $value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
