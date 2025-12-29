<x-app-layout>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-white">
                    @if(isset($product)) ✎ Edit Produk @else ✨ Buat Produk Baru @endif
                </h1>
                <p class="text-slate-400 mt-2">
                    @if(isset($product)) Perbarui informasi produk @else Tambahkan produk baru ke katalog @endif
                </p>
            </div>

            <!-- Form -->
            <div class="glass-effect rounded-2xl p-8">
                <form action="@if(isset($product)) {{ route('admin.products.update', $product->id) }} @else {{ route('admin.products.store') }} @endif" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if(isset($product)) @method('PATCH') @endif

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Nama Produk</label>
                        <input type="text" name="name" value="{{ $product->name ?? old('name') }}" placeholder="Contoh: Buku Tulis A4" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                        @error('name') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Harga (Rp)</label>
                        <input type="number" step="0.01" name="price" value="{{ $product->price ?? old('price') }}" placeholder="0" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('price') border-red-500 @enderror">
                        @error('price') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Kategori</label>
                        <select name="category_id" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('category_id') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ (isset($product) && $product->category_id == $c->id) || old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Stok</label>
                        <input type="number" name="stock" value="{{ $product->stock ?? old('stock') }}" placeholder="0" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('stock') border-red-500 @enderror">
                        @error('stock') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Deskripsi</label>
                        <textarea name="description" placeholder="Masukkan deskripsi produk..." class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 h-32 @error('description') border-red-500 @enderror">{{ $product->description ?? old('description') }}</textarea>
                        @error('description') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Gambar Produk</label>
                        @if(isset($product) && $product->image)
                            <div class="mb-4 p-3 bg-slate-100 rounded-lg">
                                <p class="text-xs text-slate-600 mb-2">Gambar saat ini:</p>
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-32 object-contain rounded">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('image') border-red-500 @enderror" id="imageInput">
                        <p class="text-xs text-slate-500 mt-2">Maks: 2MB. Tipe: jpg, png, gif.</p>
                        @error('image') <span class="text-sm text-red-600 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg transition font-semibold">
                            @if(isset($product)) ✓ Perbarui @else ✓ Simpan Produk @endif
                        </button>
                        <a href="{{ route('admin.products') }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg transition font-semibold">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
