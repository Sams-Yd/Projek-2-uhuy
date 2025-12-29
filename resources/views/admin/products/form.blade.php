<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">@if(isset($product)) Edit Produk @else Buat Produk @endif</h1>
        <form action="@if(isset($product)) {{ route('admin.products.update', $product->id) }} @else {{ route('admin.products.store') }} @endif" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($product)) @method('PATCH') @endif
            <div class="mb-3">
                <label class="block text-sm">Nama</label>
                <input type="text" name="name" value="{{ $product->name ?? old('name') }}" class="w-full border p-2 rounded">
            </div>
            <div class="mb-3">
                <label class="block text-sm">Harga</label>
                <input type="number" step="0.01" name="price" value="{{ $product->price ?? old('price') }}" class="w-full border p-2 rounded">
            </div>
            <div class="mb-3">
                <label class="block text-sm">Kategori</label>
                <select name="category_id" class="w-full border p-2 rounded">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ (isset($product) && $product->category_id == $c->id) || old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Stok</label>
                <input type="number" name="stock" value="{{ $product->stock ?? old('stock') }}" class="w-full border p-2 rounded">
            </div>
            <div class="mb-3">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="description" class="w-full border p-2 rounded">{{ $product->description ?? old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Gambar Produk</label>
                @if(isset($product) && $product->image)
                    <div class="mb-2">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-24 object-contain">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full">
                <p class="text-xs text-slate-500 mt-1">Maks: 2MB. Tipe: jpg, png, gif.</p>
            </div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
