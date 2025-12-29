<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        // Middleware diterapkan di routes/web.php
    }

    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            return redirect()->back()->with('success', 'Review diperbarui');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review ditambahkan');
    }

    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $review->delete();
        return redirect()->back()->with('success', 'Review dihapus');
    }

    public function getProductReviews($productId)
    {
        $product = Product::findOrFail($productId);
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'reviews' => $reviews,
            'averageRating' => $product->averageRating(),
            'reviewCount' => $product->reviewCount(),
        ]);
    }
}
