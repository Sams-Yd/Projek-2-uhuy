<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function page($orderId)
    {
        $order = Order::findOrFail($orderId);

        // configure midtrans
        Config::$serverKey = config('services.midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = config('services.midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = filter_var(config('services.midtrans.is_production'), FILTER_VALIDATE_BOOLEAN) ?? filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);

        // Validate keys
        if (empty(Config::$serverKey) || empty(Config::$clientKey)) {
            $message = 'Midtrans ServerKey/ClientKey belum diset. Silakan tambahkan MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY di file .env dan jalankan `php artisan config:clear`.';
            return view('checkout.payment_error', compact('message', 'order'));
        }

        $transactionDetails = [
            'order_id' => 'order-' . $order->id . '-' . time(),
            'gross_amount' => (float) $order->total,
        ];

        $itemDetails = [];
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => $item->product_id,
                'price' => (float) $item->price,
                'quantity' => (int) $item->qty,
                'name' => $item->product->name ?? 'Product',
            ];
        }

        $customerDetails = [
            'first_name' => $order->customer_name,
            'phone' => $order->customer_phone,
            'address' => $order->address,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('checkout.payment', compact('order', 'snapToken'));
    }

    public function notification(Request $request)
    {
        // handle midtrans notification
        Config::$serverKey = config('services.midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = filter_var(config('services.midtrans.is_production'), FILTER_VALIDATE_BOOLEAN) ?? filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);

        if (empty(Config::$serverKey)) {
            return response()->json(['error' => 'Midtrans server key not configured'], 500);
        }

        $notification = new Notification();

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id; // format order-<id>-<timestamp>

        // extract our internal order id
        $parts = explode('-', $orderId);
        $internalId = $parts[1] ?? null;

        if ($internalId) {
            $order = Order::find($internalId);
            if ($order) {
                if ($transaction == 'capture' || $transaction == 'settlement') {
                    $order->status = 'completed';
                } elseif ($transaction == 'pending') {
                    $order->status = 'pending';
                } elseif ($transaction == 'deny' || $transaction == 'cancel' || $transaction == 'expire') {
                    $order->status = 'cancelled';
                }
                $order->save();
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
