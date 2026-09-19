<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 1. General & Header Info
        'site_name',
        'site_title',
        'logo',
        'footer_logo',
        'favicon',

        // 2. Contact & Business Info
        'email',
        'support_email',
        'phone_1',
        'phone_2',
        'whatsapp_number',
        'address',
        'about_us',
        'copyright_text',

        // 3. Author & Developer Info
        'author_name',
        'author_email',
        'author_website',
        'developed_by',
        'developer_link',

        // 4. Social Media Links
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'youtube',
        'pinterest',

        // 5. Banners & Ad Images
        'shop_page_banner',
        'contact_page_banner',
        'default_placeholder',

        // 6. Advanced SEO & Meta Info
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_author',
        'og_image',

        // 7. Sitemap & Analytics / Tracking
        'sitemap_url',
        'google_map_url',
        'google_analytics_id',
        'facebook_pixel_id',
        'custom_head_script',
        'custom_body_script',

        // 8. E-commerce Specifics
        'currency_symbol',
        'currency_code',
        'timezone',
    ];
}
