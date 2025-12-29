<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            $items = $cart->items()->with('product')->get();
        } else {
            $items = session('cart_items', []);
        }
        return view('checkout.index', compact('items'));
    }

    public function place(Request $request)
    {
        $user = Auth::user();
        // Basic validation
        $data = $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $items = [];
        if ($user) {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            $items = $cart->items()->with('product')->get();
        } else {
            $items = collect(session('cart_items', []));
        }

        if (count($items) == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $total = 0;
        foreach ($items as $it) {
            $p = $it->product ?? (isset($it['product']) ? $it['product'] : null);
            $qty = $it->qty ?? $it['qty'];
            if ($p) $total += ($p->price ?? 0) * $qty;
        }

        $order = Order::create(array_merge($data, ['user_id' => $user->id ?? null, 'total' => $total, 'status' => 'pending']));
        foreach ($items as $it) {
            $p = $it->product ?? (isset($it['product']) ? $it['product'] : null);
            $qty = $it->qty ?? $it['qty'];
            if ($p) {
                OrderItem::create(['order_id' => $order->id, 'product_id' => $p->id, 'qty' => $qty, 'price' => $p->price]);
                // reduce stock
                if (isset($p->stock)) { $p->stock = max(0, $p->stock - $qty); $p->save(); }
            }
        }

        // clear cart
        if ($user) {
            $cart->items()->delete();
        } else {
            session()->forget('cart_items');
        }

        // Redirect to payment page to process payment via Midtrans
        return redirect()->route('payment.page', $order->id);
    }
}
