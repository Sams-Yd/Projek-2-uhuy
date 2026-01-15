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
                    <h1 class="text-4xl font-bold text-white">🛍️ Kelola Produk</h1>
                    <p class="text-slate-400 mt-2">Tambah, edit, atau hapus produk dari katalog</p>
                </div>
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center gap-2 bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition">
                    ← Dashboard
                </a>
            </div>

            <!-- Filter -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="glass-effect rounded-lg p-4 flex-1">
                    <form method="GET" action="{{ route('admin.products') }}"
                          class="flex flex-wrap gap-3 items-center">
                        <label class="text-sm font-semibold text-slate-900">Kategori</label>
                        <select name="category"
                                class="px-3 py-2 bg-slate-50 border rounded-lg">
                            <option value="">Semua</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}"
                                    {{ request('category') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                            Terapkan
                        </button>
                        <a href="{{ route('admin.products') }}"
                           class="px-4 py-2 bg-slate-500 text-white rounded-lg">
                            Reset
                        </a>
                    </form>
                </div>

                <a href="{{ route('admin.products.create') }}"
                   class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-semibold">
                    ✨ Buat Produk
                </a>
            </div>

            <!-- Table -->
            <div class="glass-effect rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Gambar</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Deskripsi</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Stok</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y">
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4 font-medium">
                                    {{ $loop->iteration + ($products->perPage() * ($products->currentPage() - 1)) }}
                                </td>

                                {{-- ================= GAMBAR (FINAL) ================= --}}
                                @php
                                    $imageUrl = null;
                                    $raw = $product->image ?? null;

                                    if ($raw) {
                                        if (\Illuminate\Support\Str::startsWith($raw, ['http://','https://'])) {
                                            $imageUrl = $raw;
                                        } else {
                                            $candidate = ltrim($raw, '/');

                                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($candidate)) {
                                                $imageUrl = asset('storage/'.$candidate);
                                            } elseif (file_exists(public_path($candidate))) {
                                                $imageUrl = asset($candidate);
                                            } else {
                                                try {
                                                    $url = \Illuminate\Support\Facades\Storage::url($candidate);
                                                    if ($url) $imageUrl = $url;
                                                } catch (\Throwable $e) {}
                                            }
                                        }
                                    }

                                    if (!$imageUrl && isset($product->images) && $product->images->count()) {
                                        $first = $product->images->first();
                                        $p = $first->path ?? $first->url ?? null;

                                        if ($p) {
                                            if (\Illuminate\Support\Str::startsWith($p, ['http://','https://'])) {
                                                $imageUrl = $p;
                                            } else {
                                                $candidate = ltrim($p, '/');
                                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($candidate)) {
                                                    $imageUrl = asset('storage/'.$candidate);
                                                }
                                            }
                                        }
                                    }
                                @endphp

                                <td class="px-6 py-4">
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}"
                                             class="w-16 h-12 object-cover rounded border">
                                    @else
                                        <div class="w-16 h-12 bg-slate-100 flex items-center justify-center text-xs text-slate-400 rounded border">
                                            No Img
                                        </div>
                                    @endif
                                </td>
                                {{-- ==================================================== --}}

                                <td class="px-6 py-4">
                                        @php $cat = $product->category; @endphp
                                        @if(is_object($cat) && isset($cat->name))
                                            <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full font-semibold">{{ $cat->name }}</span>
                                        @elseif(is_string($cat) && $cat !== '')
                                            <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full font-semibold">{{ $cat }}</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                <td class="px-6 py-4 font-medium">
                                    {{ $product->name }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                                </td>

                                <td class="px-6 py-4 font-semibold">
                                    Rp{{ number_format($product->price,0,',','.') }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $product->stock }} unit
                                </td>

                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('admin.products.edit',$product->id) }}"
                                       class="px-3 py-2 bg-blue-600 text-white rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.products.destroy',$product->id) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-2 bg-red-600 text-white rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if($products->hasPages())
                    <div class="p-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
