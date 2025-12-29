<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                // Sort by average rating - akan menggunakan subquery
                $query->orderByRaw('(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id) DESC');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        // Get user's wishlist items untuk frontend
        $wishlistIds = auth()->check() 
            ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
            : [];

        return view('products.index', compact('products', 'categories', 'wishlistIds'));
    }

    public function show($id)
    {
        $product = Product::with(['reviews.user', 'category'])->findOrFail($id);
        
        $userReview = null;
        if (auth()->check()) {
            $userReview = $product->reviews()
                ->where('user_id', auth()->id())
                ->first();
        }

        $inWishlist = auth()->check() 
            ? Wishlist::where('user_id', auth()->id())
                ->where('product_id', $id)
                ->exists()
            : false;

        return view('products.show', compact('product', 'userReview', 'inWishlist'));
    }
}
