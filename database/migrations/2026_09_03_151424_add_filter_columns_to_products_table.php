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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_trending')->default(false)->after('featured');
            $table->boolean('is_interest')->default(false)->after('is_trending');
            $table->decimal('rating', 3, 2)->default(0.00)->after('discount_price');
            $table->integer('total_sales')->default(0)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_trending', 'is_interest', 'rating', 'total_sales']);
        });
    }
};
