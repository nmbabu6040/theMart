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
        Schema::table('contact_questions', function (Blueprint $table) {
            $table->string('address')->nullable()->after('email');
            $table->string('service')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_questions', function (Blueprint $table) {
            $table->dropColumn(['address', 'service']);
        });
    }
};
