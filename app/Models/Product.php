<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'brand_id',
        'name',
        'slug',
        'thumbnail',
        'sku',
        'short_description',
        'description',
        'buying_price',
        'sale_price',
        'discount',
        'discount_price',
        'rating',
        'stock',
        'featured',
        'is_interest',
        'is_trending',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'sub_category_id' => 'integer',
        'brand_id' => 'integer',

        'buying_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'stock' => 'integer',

        'featured' => 'boolean',
        'is_interest' => 'boolean',
        'is_trending' => 'boolean',
        'status' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Sub Category
    |--------------------------------------------------------------------------
    */

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Brand
    |--------------------------------------------------------------------------
    */

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    public function sizes()
    {
        return $this->belongsToMany(
            Size::class,
            'product_size',
            'product_id',
            'size_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Colors
    |--------------------------------------------------------------------------
    */

    public function colors()
    {
        return $this->belongsToMany(
            Color::class,
            'product_color',
            'product_id',
            'color_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Tags
    |--------------------------------------------------------------------------
    */

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Product Images
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Primary Image
    |--------------------------------------------------------------------------
    */

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)
            ->where('is_primary', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isNew(): bool
    {
        return $this->created_at->gte(now()->subDays(30));
    }
}
