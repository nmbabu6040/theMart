<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new product review.
     */
    public function store(Request $request, Product $product): RedirectResponse
    {
        // Validate review data
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        // Prevent duplicate review
        $alreadyReviewed = Review::where('product_id', $product->id)
            ->where('user_id', auth()->id())
            ->exists();

        $product = Product::with('reviews.user')->findOrFail($id);

        if ($alreadyReviewed) {
            return back()
                ->withInput()
                ->with('error', 'You have already reviewed this product.');
        }

        // Create review
        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_approved' => true,
        ]);

        return back()->with(
            'success',
            'Thank you! Your review has been submitted successfully.'
        );
    }
}
