<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "BCA", "Mandiri", "GoPay"
            $table->string('account_number'); // e.g. "1234567890"
            $table->string('account_name'); // e.g. "PT Ranti Exclusive"
            $table->string('type')->default('bank'); // "bank" or "e_wallet"
            $table->boolean('is_active')->default(true);
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
