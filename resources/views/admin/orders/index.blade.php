<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Daftar Pesanan</h1>
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.orders') }}" class="flex gap-2 items-center">
                <label class="text-sm font-semibold">Filter Kategori:</label>
                <select name="category" class="px-3 py-2 border rounded">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Filter</button>
                <a href="{{ route('admin.orders') }}" class="px-3 py-2 border rounded">Reset</a>
            </form>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">User</th>
                        <th class="p-3 text-left">Total</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b">
                            <td class="p-3">#{{ $order->id }}</td>
                            <td class="p-3">
                                @php
                                    $cats = $order->items->map(function($it){ return optional($it->product->category)->name; })->filter()->unique()->values()->all();
                                @endphp
                                {{ count($cats) ? implode(', ', $cats) : '-' }}
                            </td>
                            <td class="p-3">{{ $order->user?->name ?? 'Guest' }}</td>
                            <td class="p-3">Rp{{ number_format($order->total,0,',','.') }}</td>
                            <td class="p-3">{{ $order->status }}</td>
                            <td class="p-3">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.orders.detail', $order->id) }}" class="text-blue-600">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
</x-app-layout>
