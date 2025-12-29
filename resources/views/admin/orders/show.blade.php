<x-app-layout>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white">📋 Detail Pesanan #{{ $order->id }}</h1>
                    <p class="text-slate-400 mt-2">Lihat dan kelola detail pesanan pelanggan</p>
                </div>
                <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg transition">
                    ← Kembali
                </a>
            </div>

            <!-- Order Info -->
            <div class="glass-effect rounded-2xl p-8 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border-b md:border-b-0 md:border-r border-slate-200 pb-4 md:pb-0 md:pr-4">
                        <p class="text-sm text-slate-600 mb-2">Nama Pelanggan</p>
                        <p class="text-xl font-semibold text-slate-900">{{ $order->user?->name ?? 'Guest' }}</p>
                    </div>
                    <div class="border-b md:border-b-0 md:border-r border-slate-200 pb-4 md:pb-0 md:pr-4">
                        <p class="text-sm text-slate-600 mb-2">Total Pesanan</p>
                        <p class="text-2xl font-bold text-indigo-600">Rp{{ number_format($order->total,0,',','.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 mb-2">Tanggal Pesanan</p>
                        <p class="text-lg font-semibold text-slate-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Update -->
            <div class="glass-effect rounded-2xl p-8 mb-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">📊 Ubah Status Pesanan</h2>
                <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="flex flex-col md:flex-row gap-3 items-start md:items-end">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Status Saat Ini</label>
                        <select name="status" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="pending" @if($order->status=='pending') selected @endif>⏳ Pending</option>
                            <option value="processing" @if($order->status=='processing') selected @endif>⚙️ Processing</option>
                            <option value="completed" @if($order->status=='completed') selected @endif>✓ Completed</option>
                            <option value="cancelled" @if($order->status=='cancelled') selected @endif>✕ Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition font-semibold">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Items Table -->
            <div class="glass-effect rounded-2xl overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900">📦 Item Pesanan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-white">Nama Produk</th>
                                <th class="px-6 py-4 text-center font-semibold text-white">Qty</th>
                                <th class="px-6 py-4 text-right font-semibold text-white">Harga per Unit</th>
                                <th class="px-6 py-4 text-right font-semibold text-white">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($order->items as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-slate-900 font-medium">
                                        {{ $item->product?->name ?? 'Produk dihapus' }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-700">
                                        <span class="inline-block px-3 py-1 bg-slate-100 rounded">{{ $item->qty }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-slate-900 font-semibold">
                                        Rp{{ number_format($item->price ?? 0,0,',','.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-slate-900 font-bold text-lg">
                                        Rp{{ number_format(($item->price ?? 0) * $item->qty,0,',','.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                        Tidak ada item dalam pesanan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Total Summary -->
                <div class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <div class="text-right">
                        <p class="text-slate-600 mb-2">Total Pesanan:</p>
                        <p class="text-3xl font-bold text-indigo-600">Rp{{ number_format($order->total,0,',','.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
