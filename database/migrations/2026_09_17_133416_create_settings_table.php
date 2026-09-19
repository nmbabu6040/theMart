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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // 1. General & Header Info
            $table->string('site_name')->default('Themart');
            $table->string('site_title')->nullable();
            $table->string('logo')->nullable(); // Header Logo
            $table->string('footer_logo')->nullable(); // Footer Logo
            $table->string('favicon')->nullable();

            // 2. Contact & Business Info
            $table->string('email')->nullable();
            $table->string('support_email')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->text('address')->nullable();
            $table->text('about_us')->nullable(); // Short description for footer
            $table->string('copyright_text')->nullable();

            // 3. Author & Developer Info
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->string('author_website')->nullable();
            $table->string('developed_by')->nullable(); // e.g., "Developed by wpOceans"
            $table->string('developer_link')->nullable();

            // 4. Social Media Links
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('pinterest')->nullable();

            // 5. Banners & Ad Images
            $table->string('shop_page_banner')->nullable();
            $table->string('contact_page_banner')->nullable();
            $table->string('default_placeholder')->nullable();

            // 6. Advanced SEO & Meta Info
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_author')->nullable();
            $table->string('og_image')->nullable(); // Social Media Share Preview Image

            // 7. Sitemap & Analytics / Tracking
            $table->string('sitemap_url')->nullable(); // e.g., "sitemap.xml"
            $table->string('google_analytics_id')->nullable(); // GA4 ID (e.g., G-XXXXXXX)
            $table->string('facebook_pixel_id')->nullable();
            $table->text('custom_head_script')->nullable(); // Header Code (Google Tag Manager etc.)
            $table->text('custom_body_script')->nullable(); // Footer Code

            // 8. E-commerce Specifics
            $table->string('currency_symbol')->default('$');
            $table->string('currency_code')->default('USD');
            $table->string('timezone')->default('Asia/Dhaka');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
