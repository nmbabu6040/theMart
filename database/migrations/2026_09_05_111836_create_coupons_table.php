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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Coupon Code (e.g. SAVE20)
            $table->enum('type', ['percent', 'fixed']); // Percent ba Fixed Amount Discount
            $table->decimal('value', 10, 2); // Koto discount (e.g. 20% ba $20)
            $table->decimal('min_cart_amount', 10, 2)->default(0); // Minimum koto tk shopping korte hobe
            $table->date('validity'); // Khaddota/Expire Date
            $table->boolean('status')->default(1); // Active (1) ba Inactive (0)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
