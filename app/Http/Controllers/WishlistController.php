<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        // Middleware diterapkan di routes/web.php
    }

    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product')->paginate(12);
        return view('wishlists.index', compact('wishlists'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $existingWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();
        
        if ($existingWishlist) {
            return redirect()->back()->with('info', 'Produk sudah ada di wishlist');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
        ]);

        return redirect()->back()->with('success', 'Produk ditambahkan ke wishlist');
    }

    public function remove($wishlistId)
    {
        $wishlist = Wishlist::findOrFail($wishlistId);
        
        if ($wishlist->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $wishlist->delete();
        return redirect()->back()->with('success', 'Produk dihapus dari wishlist');
    }

    public function toggle($productId)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => 'Dihapus dari wishlist']);
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
            ]);
            return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke wishlist']);
        }
    }

    public function isInWishlist($productId)
    {
        if (!auth()->check()) {
            return response()->json(['inWishlist' => false]);
        }

        $inWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->exists();

        return response()->json(['inWishlist' => $inWishlist]);
    }
}
