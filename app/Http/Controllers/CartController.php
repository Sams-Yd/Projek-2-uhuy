<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            $items = $cart->items()->with('product')->get();
        } else {
            $items = session('cart_items', []);
        }
        return view('cart.index', compact('items'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty = max(1, (int)$request->input('qty', 1));

        $user = Auth::user();
        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            $item = CartItem::firstOrNew(['cart_id' => $cart->id, 'product_id' => $product->id]);
            $item->qty = ($item->exists ? $item->qty + $qty : $qty);
            $item->save();
            $cartCount = $cart->items()->sum('qty');
        } else {
            $session = session('cart_items', []);
            $found = false;
            foreach ($session as &$s) {
                if ($s['product_id'] == $product->id) { $s['qty'] += $qty; $found = true; break; }
            }
            if (! $found) {
                $session[] = ['product_id' => $product->id, 'qty' => $qty, 'product' => $product];
            }
            session(['cart_items' => $session]);
            $cartCount = collect(session('cart_items', []))->sum('qty');
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'count' => $cartCount]);
        }
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $qty = max(1, (int)$request->input('qty', 1));
        $user = Auth::user();
        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            $item = CartItem::where('cart_id', $cart->id)->where('product_id', $id)->first();
            if ($item) { $item->qty = $qty; $item->save(); }
        } else {
            $session = session('cart_items', []);
            foreach ($session as &$s) {
                if ($s['product_id'] == $id) { $s['qty'] = $qty; }
            }
            session(['cart_items' => $session]);
        }
        // prepare response data
        $itemSubtotal = 0;
        $cartTotal = 0;
        $cartCount = 0;

        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $items = $cart->items()->with('product')->get();
            foreach ($items as $it) {
                $line = ($it->product->price ?? 0) * $it->qty;
                if ($it->product_id == $id) $itemSubtotal = $line;
                $cartTotal += $line;
                $cartCount += $it->qty;
            }
        } else {
            $session = session('cart_items', []);
            foreach ($session as $s) {
                $price = isset($s['product']['price']) ? $s['product']['price'] : 0;
                $line = $price * $s['qty'];
                if ($s['product_id'] == $id) $itemSubtotal = $line;
                $cartTotal += $line;
                $cartCount += $s['qty'];
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count' => $cartCount,
                'itemSubtotal' => $itemSubtotal,
                'total' => $cartTotal,
                'qty' => $qty,
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function remove(Request $request, $id)
    {
        $user = Auth::user();
        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            CartItem::where('cart_id', $cart->id)->where('product_id', $id)->delete();
        } else {
            $session = session('cart_items', []);
            $session = array_filter($session, fn($s)=> $s['product_id'] != $id);
            session(['cart_items' => array_values($session)]);
        }
        return redirect()->route('cart.index');
    }
}
