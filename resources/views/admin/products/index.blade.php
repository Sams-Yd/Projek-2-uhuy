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
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white">🛍️ Kelola Produk</h1>
                <p class="text-slate-400 mt-2">Tambah, edit, atau hapus produk dari katalog</p>
            </div>

            <!-- Action Bar -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="glass-effect rounded-lg p-4 flex-1">
                    <form method="GET" action="{{ route('admin.products') }}" class="flex flex-wrap gap-3 items-center">
                        <label class="text-sm font-semibold text-slate-900">Kategori</label>
                        <select name="category" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Semua</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">Terapkan</button>
                        <a href="{{ route('admin.products') }}" class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg transition">Reset</a>
                        @if(request()->filled('trashed'))
                            <a href="{{ route('admin.products') }}" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">Tampilkan Semua</a>
                        @else
                            <a href="{{ route('admin.products', array_merge(request()->all(), ['trashed'=>1])) }}" class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg transition">Tampilkan Terhapus</a>
                        @endif
                    </form>
                </div>
                <a href="{{ route('admin.products.create') }}" class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg transition font-semibold self-start">
                    ✨ Buat Produk Baru
                </a>
            </div>

            <!-- Products Table -->
            <div class="glass-effect rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-white">#</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Kategori</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Nama</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Harga</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Stok</th>
                                <th class="px-6 py-4 text-left font-semibold text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($products as $product)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-slate-900 font-medium">#{{ $loop->iteration + ($products->perPage() * ($products->currentPage() - 1)) }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $cat = $product->category;
                                        @endphp
                                        @if(is_object($cat) && isset($cat->name))
                                            <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full font-semibold">{{ $cat->name }}</span>
                                        @elseif(is_string($cat) && $cat !== '')
                                            <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full font-semibold">{{ $cat }}</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-900 font-medium">{{ $product->name }}</td>
                                    <td class="px-6 py-4 text-slate-900 font-semibold">Rp{{ number_format($product->price,0,',','.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                            @if($product->stock > 20) bg-green-100 text-green-800
                                            @elseif($product->stock > 5) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ $product->stock }} unit
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        @if(method_exists($product, 'trashed') && $product->trashed())
                                            <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition">↺ Restore</button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-block px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
                                                ✎ Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
