<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display all active products.
     */
    public function index(): View
    {
        $products = Product::query()
            ->with([
                'category:id,name',
                'subCategory:id,name',
                'brand:id,name',
                'images',
            ])
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show create product form.
     */
    public function create(): View
    {
        return view(
            'admin.product.create',
            $this->getFormData()
        );
    }

    /**
     * Store a new product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        try {

            DB::transaction(function () use ($request, $validated) {

                /*
                 * ---------------------------------------------------------
                 * Thumbnail
                 * ---------------------------------------------------------
                 */
                $thumbnailPath = null;

                if ($request->hasFile('thumbnail')) {
                    $thumbnailPath = $request
                        ->file('thumbnail')
                        ->store('products/thumbnails', 'public');
                }

                /*
                 * ---------------------------------------------------------
                 * Product
                 * ---------------------------------------------------------
                 */
                $product = Product::create([
                    'category_id'       => $validated['category_id'],
                    'sub_category_id'   => $validated['sub_category_id'] ?? null,
                    'brand_id'          => $validated['brand_id'] ?? null,

                    'name'              => $validated['name'],
                    'slug'              => $this->generateUniqueSlug(
                        $validated['name']
                    ),
                    'sku'               => $validated['sku'],

                    'thumbnail'         => $thumbnailPath,

                    'short_description' => $validated['short_description'] ?? null,
                    'description'       => $validated['description'] ?? null,

                    'buying_price'      => $validated['buying_price'] ?? 0,
                    'sale_price'        => $validated['sale_price'],
                    'discount'          => $validated['discount'] ?? 0,
                    'discount_price'    => $validated['discount_price'] ?? 0,

                    'rating'            => $validated['rating'] ?? 0,
                    'stock'             => $validated['stock'] ?? 0,

                    'featured'          => $request->boolean('featured'),
                    'is_interest'       => $request->boolean('is_interest'),
                    'is_trending'       => $request->boolean('is_trending'),
                    'status'            => $request->boolean('status', true),

                    'meta_title'        => $validated['meta_title'] ?? null,
                    'meta_description'  => $validated['meta_description'] ?? null,
                ]);

                /*
                 * ---------------------------------------------------------
                 * Relationships
                 * ---------------------------------------------------------
                 */
                $product->sizes()->sync(
                    $validated['sizes'] ?? []
                );

                $product->colors()->sync(
                    $validated['colors'] ?? []
                );

                $product->tags()->sync(
                    $validated['tags'] ?? []
                );

                /*
                 * ---------------------------------------------------------
                 * Gallery Images
                 * ---------------------------------------------------------
                 */
                if ($request->hasFile('images')) {
                    $this->storeImages(
                        $product,
                        $request->file('images')
                    );
                }
            });

            return redirect()
                ->route('products.index')
                ->with(
                    'success',
                    'Product created successfully.'
                );
        } catch (\Throwable $e) {

            Log::error(
                'Product Creation Error',
                [
                    'message' => $e->getMessage(),
                    'trace'   => $e->getTraceAsString(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to create product. Please try again.'
                );
        }
    }

    /**
     * Show edit product form.
     */
    public function edit(Product $product): View
    {
        $product->load([
            'sizes:id',
            'colors:id',
            'tags:id',
            'images' => function ($query) {
                $query
                    ->orderBy('sort_order')
                    ->orderBy('id');
            },
        ]);

        $formData = $this->getFormData();

        return view(
            'admin.product.edit',
            array_merge(
                compact('product'),
                $formData
            )
        );
    }

    /**
     * Update product.
     *
     * Thumbnail update, product information update and
     * new gallery image upload are handled here.
     */
    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {

        $validated = $this->validateProduct(
            $request,
            $product->id
        );

        try {

            DB::transaction(function () use (
                $request,
                $validated,
                $product
            ) {

                /*
                 * ---------------------------------------------------------
                 * Slug
                 * ---------------------------------------------------------
                 */
                $slug = $product->name !== $validated['name']
                    ? $this->generateUniqueSlug(
                        $validated['name'],
                        $product->id
                    )
                    : $product->slug;

                /*
                 * ---------------------------------------------------------
                 * Thumbnail
                 * ---------------------------------------------------------
                 */
                $thumbnailPath = $product->thumbnail;

                if ($request->hasFile('thumbnail')) {

                    $newThumbnail = $request
                        ->file('thumbnail')
                        ->store(
                            'products/thumbnails',
                            'public'
                        );

                    if (!$newThumbnail) {
                        throw new \RuntimeException(
                            'Unable to store product thumbnail.'
                        );
                    }

                    /*
                     * Delete old thumbnail only after
                     * new thumbnail has been stored successfully.
                     */
                    if (
                        $product->thumbnail &&
                        Storage::disk('public')->exists(
                            $product->thumbnail
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $product->thumbnail
                        );
                    }

                    $thumbnailPath = $newThumbnail;
                }

                /*
                 * ---------------------------------------------------------
                 * Product Update
                 * ---------------------------------------------------------
                 */
                $product->update([
                    'category_id'       => $validated['category_id'],
                    'sub_category_id'   => $validated['sub_category_id'] ?? null,
                    'brand_id'          => $validated['brand_id'] ?? null,

                    'name'              => $validated['name'],
                    'slug'              => $slug,
                    'sku'               => $validated['sku'],

                    'thumbnail'         => $thumbnailPath,

                    'short_description' => $validated['short_description'] ?? null,
                    'description'       => $validated['description'] ?? null,

                    'buying_price'      => $validated['buying_price'] ?? 0,
                    'sale_price'        => $validated['sale_price'],
                    'discount'          => $validated['discount'] ?? 0,
                    'discount_price'    => $validated['discount_price'] ?? 0,

                    'rating'            => $validated['rating'] ?? 0,
                    'stock'             => $validated['stock'] ?? 0,

                    'featured'          => $request->boolean('featured'),
                    'is_interest'       => $request->boolean('is_interest'),
                    'is_trending'       => $request->boolean('is_trending'),
                    'status'            => $request->boolean('status', true),

                    'meta_title'        => $validated['meta_title'] ?? null,
                    'meta_description'  => $validated['meta_description'] ?? null,
                ]);

                /*
                 * ---------------------------------------------------------
                 * Relationships
                 * ---------------------------------------------------------
                 */
                $product->sizes()->sync(
                    $validated['sizes'] ?? []
                );

                $product->colors()->sync(
                    $validated['colors'] ?? []
                );

                $product->tags()->sync(
                    $validated['tags'] ?? []
                );

                /*
                 * ---------------------------------------------------------
                 * Optional legacy bulk delete support
                 * ---------------------------------------------------------
                 *
                 * Individual delete uses deleteImage().
                 * This block keeps the existing edit form compatible.
                 */
                if (!empty($validated['delete_images'])) {

                    $images = ProductImage::query()
                        ->where('product_id', $product->id)
                        ->whereIn(
                            'id',
                            $validated['delete_images']
                        )
                        ->get();

                    foreach ($images as $image) {
                        $this->deleteImageFileAndRecord($image);
                    }
                }

                /*
                 * ---------------------------------------------------------
                 * Add New Gallery Images
                 * ---------------------------------------------------------
                 */
                if ($request->hasFile('images')) {

                    $this->storeImages(
                        $product,
                        $request->file('images')
                    );
                }

                /*
                 * ---------------------------------------------------------
                 * Make sure a primary image always exists
                 * when gallery images are available.
                 * ---------------------------------------------------------
                 */
                $this->ensurePrimaryImage($product);
            });

            return redirect()
                ->route('products.edit', $product)
                ->with(
                    'success',
                    'Product updated successfully.'
                );
        } catch (\Throwable $e) {

            Log::error(
                'Product Update Error',
                [
                    'product_id' => $product->id,
                    'message'    => $e->getMessage(),
                    'trace'      => $e->getTraceAsString(),
                ]
            );

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Failed to update product. Please try again.'
                );
        }
    }

    /**
     * Add gallery images separately.
     *
     * This is used by:
     * POST /products/{product}/images
     */
    public function addImage(
        Request $request,
        Product $product
    ): RedirectResponse {

        $validated = $request->validate([
            'images' => [
                'required',
                'array',
                'min:1',
            ],

            'images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        try {

            DB::transaction(function () use (
                $product,
                $validated
            ) {

                $this->storeImages(
                    $product,
                    $validated['images']
                );

                $this->ensurePrimaryImage($product);
            });

            return back()->with(
                'success',
                'Gallery image(s) added successfully.'
            );
        } catch (\Throwable $e) {

            Log::error(
                'Product Gallery Add Error',
                [
                    'product_id' => $product->id,
                    'message'    => $e->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'Failed to add gallery image(s).'
            );
        }
    }

    /**
     * Delete one gallery image.
     *
     * This is used by:
     * DELETE /products/{product}/images/{image}
     */
    public function deleteImage(
        Product $product,
        ProductImage $image
    ): RedirectResponse {

        /*
         * Security:
         * Do not allow an image belonging to another product
         * to be deleted.
         */
        abort_unless(
            (int) $image->product_id === (int) $product->id,
            404
        );

        try {

            DB::transaction(function () use (
                $product,
                $image
            ) {

                $wasPrimary = (bool) $image->is_primary;

                /*
                 * Delete image file + database record.
                 */
                $this->deleteImageFileAndRecord($image);

                /*
                 * If the deleted image was primary,
                 * assign the first remaining image as primary.
                 */
                if ($wasPrimary) {

                    ProductImage::where(
                        'product_id',
                        $product->id
                    )->update([
                        'is_primary' => false,
                    ]);

                    $nextImage = ProductImage::query()
                        ->where(
                            'product_id',
                            $product->id
                        )
                        ->orderBy('sort_order')
                        ->orderBy('id')
                        ->first();

                    if ($nextImage) {
                        $nextImage->update([
                            'is_primary' => true,
                        ]);
                    }
                }
            });

            return back()->with(
                'success',
                'Gallery image deleted successfully.'
            );
        } catch (\Throwable $e) {

            Log::error(
                'Product Gallery Delete Error',
                [
                    'product_id' => $product->id,
                    'image_id'   => $image->id,
                    'message'    => $e->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'Failed to delete gallery image.'
            );
        }
    }

    /**
     * Make a gallery image primary.
     *
     * This is used by:
     * PATCH /products/{product}/images/{image}/primary
     */
    public function setPrimaryImage(
        Product $product,
        ProductImage $image
    ): RedirectResponse {

        abort_unless(
            (int) $image->product_id === (int) $product->id,
            404
        );

        try {

            DB::transaction(function () use (
                $product,
                $image
            ) {

                /*
                 * Remove primary status from all images.
                 */
                ProductImage::where(
                    'product_id',
                    $product->id
                )->update([
                    'is_primary' => false,
                ]);

                /*
                 * Set selected image as primary.
                 */
                $image->update([
                    'is_primary' => true,
                ]);
            });

            return back()->with(
                'success',
                'Primary image updated successfully.'
            );
        } catch (\Throwable $e) {

            Log::error(
                'Product Primary Image Error',
                [
                    'product_id' => $product->id,
                    'image_id'   => $image->id,
                    'message'    => $e->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'Failed to update primary image.'
            );
        }
    }

    /**
     * Soft delete product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product moved to trash.'
            );
    }

    /**
     * Display trashed products.
     */
    public function trash(): View
    {
        $products = Product::onlyTrashed()
            ->with([
                'category:id,name',
                'subCategory:id,name',
                'brand:id,name',
                'images',
            ])
            ->orderByDesc('deleted_at')
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.product.trash',
            compact('products')
        );
    }

    /**
     * Restore product.
     */
    public function restore(int $id): RedirectResponse
    {
        $product = Product::withTrashed()
            ->findOrFail($id);

        $product->restore();

        return redirect()
            ->route('products.trash')
            ->with(
                'success',
                'Product restored successfully.'
            );
    }

    /**
     * Permanently delete product and its assets.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $product = Product::withTrashed()
            ->with('images')
            ->findOrFail($id);

        try {

            DB::transaction(function () use ($product) {

                /*
                 * Delete thumbnail.
                 */
                if (
                    $product->thumbnail &&
                    Storage::disk('public')->exists(
                        $product->thumbnail
                    )
                ) {
                    Storage::disk('public')->delete(
                        $product->thumbnail
                    );
                }

                /*
                 * Delete gallery files.
                 */
                foreach ($product->images as $image) {

                    if (
                        $image->image &&
                        Storage::disk('public')->exists(
                            $image->image
                        )
                    ) {
                        Storage::disk('public')->delete(
                            $image->image
                        );
                    }
                }

                /*
                 * Detach relationships.
                 */
                $product->sizes()->detach();
                $product->colors()->detach();
                $product->tags()->detach();

                /*
                 * Delete gallery records.
                 */
                ProductImage::where(
                    'product_id',
                    $product->id
                )->delete();

                /*
                 * Permanently delete product.
                 */
                $product->forceDelete();
            });

            return redirect()
                ->route('products.trash')
                ->with(
                    'success',
                    'Product permanently deleted.'
                );
        } catch (\Throwable $e) {

            Log::error(
                'Product Force Delete Error',
                [
                    'product_id' => $product->id,
                    'message'    => $e->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'Failed to delete product permanently.'
            );
        }
    }

    /**
     * Get form data.
     */
    private function getFormData(): array
    {
        return [
            'categories' => Category::query()
                ->select('id', 'name')
                ->where('status', true)
                ->orderBy('name')
                ->get(),

            'subCategories' => SubCategory::query()
                ->select('id', 'name', 'category_id')
                ->where('status', true)
                ->orderBy('name')
                ->get(),

            'brands' => Brand::query()
                ->select('id', 'name')
                ->where('status', true)
                ->orderBy('name')
                ->get(),

            'sizes' => Size::query()
                ->select('id', 'name')
                ->where('status', true)
                ->orderBy('name')
                ->get(),

            'colors' => Color::query()
                ->select('id', 'name', 'code')
                ->where('status', true)
                ->orderBy('name')
                ->get(),

            'tags' => Tag::query()
                ->select('id', 'name')
                ->where('status', true)
                ->orderBy('name')
                ->get(),
        ];
    }

    /**
     * Validate product.
     */
    private function validateProduct(
        Request $request,
        ?int $productId = null
    ): array {

        return $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
c                Rule::unique(
                    'products',
                    'sku'
                )
                    ->ignore($productId)
                    ->whereNull('deleted_at'),
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'sub_category_id' => [
                'nullable',
                'integer',
                'exists:sub_categories,id',
            ],

            'brand_id' => [
                'nullable',
                'integer',
                'exists:brands,id',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'short_description' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'buying_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'sale_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'rating' => [
                'nullable',
                'numeric',
                'min:0',
                'max:5',
            ],

            'stock' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'sizes' => [
                'nullable',
                'array',
            ],

            'sizes.*' => [
                'integer',
                'exists:sizes,id',
            ],

            'colors' => [
                'nullable',
                'array',
            ],

            'colors.*' => [
                'integer',
                'exists:colors,id',
            ],

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'integer',
                'exists:tags,id',
            ],

            'images' => [
                'nullable',
                'array',
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
             * Kept for backward compatibility with bulk-delete
             * if you use it anywhere else.
             */
            'delete_images' => [
                'nullable',
                'array',
            ],

            'delete_images.*' => [
                'integer',
                'exists:product_images,id',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],
        ]);
    }

    /**
     * Store gallery images.
     */
    private function storeImages(
        Product $product,
        array $images
    ): void {

        if (empty($images)) {
            return;
        }

        /*
         * Continue after the last existing image.
         */
        $sortOrder = (int) (
            ProductImage::where(
                'product_id',
                $product->id
            )->max('sort_order') ?? 0
        );

        /*
         * Check whether product already has primary image.
         */
        $hasPrimary = ProductImage::where(
            'product_id',
            $product->id
        )
            ->where('is_primary', true)
            ->exists();

        foreach ($images as $image) {

            if (
                !$image instanceof UploadedFile ||
                !$image->isValid()
            ) {
                continue;
            }

            $path = $image->store(
                'products/gallery',
                'public'
            );

            if (!$path) {
                throw new \RuntimeException(
                    'Failed to store gallery image.'
                );
            }

            $sortOrder++;

            ProductImage::create([
                'product_id' => $product->id,
                'image'      => $path,
                'sort_order' => $sortOrder,

                /*
                 * First gallery image becomes primary
                 * when no primary image currently exists.
                 */
                'is_primary' => !$hasPrimary,
            ]);

            $hasPrimary = true;
        }
    }

    /**
     * Delete physical image and database record.
     */
    private function deleteImageFileAndRecord(
        ProductImage $image
    ): void {

        if (
            $image->image &&
            Storage::disk('public')->exists(
                $image->image
            )
        ) {
            Storage::disk('public')->delete(
                $image->image
            );
        }

        $image->delete();
    }

    /**
     * Ensure exactly one primary image when gallery exists.
     */
    private function ensurePrimaryImage(
        Product $product
    ): void {

        $images = ProductImage::query()
            ->where('product_id', $product->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($images->isEmpty()) {
            return;
        }

        /*
         * Find current primary images.
         */
        $primaryImages = $images->where(
            'is_primary',
            true
        );

        /*
         * If no primary image exists,
         * make first image primary.
         */
        if ($primaryImages->isEmpty()) {

            $images->first()->update([
                'is_primary' => true,
            ]);

            return;
        }

        /*
         * Production safety:
         * Only one image should be primary.
         */
        $primaryImages
            ->skip(1)
            ->each(function ($image) {
                $image->update([
                    'is_primary' => false,
                ]);
            });
    }

    /**
     * Generate unique product slug.
     */
    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {

        $slug = Str::slug($name);

        /*
         * Prevent empty slug.
         */
        if ($slug === '') {
            $slug = 'product';
        }

        $originalSlug = $slug;
        $counter = 1;

        while (
            Product::withTrashed()
            ->where('slug', $slug)
            ->when(
                $ignoreId,
                fn($query) =>
                $query->where(
                    'id',
                    '!=',
                    $ignoreId
                )
            )
            ->exists()
        ) {

            $slug = $originalSlug . '-' . $counter;

            $counter++;
        }

        return $slug;
    }
}
