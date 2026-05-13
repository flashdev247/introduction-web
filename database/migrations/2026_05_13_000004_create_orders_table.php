<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('customer_name');
            $table->string('customer_phone', 32);
            $table->string('customer_email')->nullable();
            $table->string('shipping_address_detail');
            $table->string('province_id', 32);
            $table->string('province_name');
            $table->string('commune_id', 32);
            $table->string('commune_name');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->boolean('wants_invoice')->default(false);
            $table->string('invoice_company')->nullable();
            $table->string('invoice_tax_code', 64)->nullable();
            $table->string('invoice_email')->nullable();
            $table->string('invoice_address')->nullable();
            $table->string('status', 32)->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
