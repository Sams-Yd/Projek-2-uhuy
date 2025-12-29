<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Pesanan #{{ $order->id }}</h1>
        <div class="bg-white shadow rounded-lg p-4">
            <div class="mb-4">
                <strong>Nama:</strong> {{ $order->user?->name ?? 'Guest' }}
            </div>
            <div class="mb-4">
                <strong>Total:</strong> Rp{{ number_format($order->total,0,',','.') }}
            </div>
            <div class="mb-4">
                <strong>Status:</strong> {{ $order->status }}
            </div>
            <div class="mb-4">
                <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                    @csrf
                    <div class="flex gap-2 items-center">
                        <select name="status" class="border p-2">
                            <option value="pending" @if($order->status=='pending') selected @endif>pending</option>
                            <option value="processing" @if($order->status=='processing') selected @endif>processing</option>
                            <option value="completed" @if($order->status=='completed') selected @endif>completed</option>
                            <option value="cancelled" @if($order->status=='cancelled') selected @endif>cancelled</option>
                        </select>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                    </div>
                </form>
            </div>

            <h3 class="font-bold mt-4">Items</h3>
            <ul class="mt-2">
                @foreach($order->items as $item)
                    <li class="py-2 border-b">{{ $item->product->name ?? 'Produk dihapus' }} x {{ $item->qty }} — Rp{{ number_format($item->price ?? 0,0,',','.') }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
