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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number')->unique();

            // Billing
            $table->string('billing_fname');
            $table->string('billing_lname');
            $table->foreignId('billing_country_id')->constrained('countries');
            $table->string('billing_city');
            $table->string('billing_postcode');
            $table->string('billing_company')->nullable();
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->text('billing_address');
            $table->text('order_notes')->nullable();

            // Shipping (Optional)
            $table->boolean('ship_to_different')->default(false);
            $table->string('shipping_fname')->nullable();
            $table->string('shipping_lname')->nullable();
            $table->foreignId('shipping_country_id')->nullable()->constrained('countries');
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->text('shipping_address')->nullable();

            // Totals & Payment
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_charge', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method');
            $table->string('payment_status')->default('pending');
            $table->string('order_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
