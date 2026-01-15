<x-app-layout>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white">📦 Daftar Pesanan</h1>
                    <p class="text-slate-400 mt-2">Kelola dan pantau semua pesanan dari pelanggan</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Filter Section -->
            <div class="glass-effect rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('admin.orders') }}" class="flex flex-wrap gap-3 items-center">
                    <label class="text-sm font-semibold text-slate-900">Filter Kategori:</label>
                    <select name="category" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">Terapkan</button>
                    <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg transition">Reset</a>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="glass-effect rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-white">#</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Kategori</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">User</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Total</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Status</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Tanggal</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-slate-900 font-medium">#{{ $order->id }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $cats = $order->items->map(function($it){ 
                                                $cat = $it->product?->category;
                                                if(is_object($cat) && isset($cat->name)) {
                                                    return $cat->name;
                                                } elseif(is_string($cat) && $cat !== '') {
                                                    return $cat;
                                                }
                                                return null;
                                            })->filter()->unique()->values()->all();
                                        @endphp
                                        @if(count($cats) > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($cats as $cat)
                                                    <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full font-semibold">{{ $cat }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-700">{{ $order->user?->name ?? 'Guest' }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-900">Rp{{ number_format($order->total,0,',','.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-slate-100 text-slate-800
                                            @endif
                                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-700">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.orders.detail', $order->id) }}" class="inline-block px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg transition">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200 flex justify-center">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>