<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('contact_settings', 'zalo')) {
                $table->string('zalo')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('contact_settings', 'hotline')) {
                $table->string('hotline')->nullable()->after('zalo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('contact_settings', 'zalo') ? 'zalo' : null,
                Schema::hasColumn('contact_settings', 'hotline') ? 'hotline' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};