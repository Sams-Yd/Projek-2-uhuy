<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Kelola Produk</h1>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.products') }}" class="flex items-center gap-2">
                    <label class="text-sm font-semibold">Kategori</label>
                    <select name="category" class="px-2 py-1 border rounded">
                        <option value="">Semua</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded">Filter</button>
                    <a href="{{ route('admin.products') }}" class="px-3 py-1 border rounded">Reset</a>
                </form>
                <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">Buat Produk</a>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Harga</th>
                        <th class="p-3 text-left">Stok</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-b">
                            <td class="p-3">#{{ $product->id }}</td>
                            <td class="p-3">
                                @php
                                    $cat = $product->category;
                                @endphp
                                @if(is_object($cat) && isset($cat->name))
                                    {{ $cat->name }}
                                @elseif(is_string($cat) && $cat !== '')
                                    {{ $cat }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-3">{{ $product->name }}</td>
                            <td class="p-3">Rp{{ number_format($product->price,0,',','.') }}</td>
                            <td class="p-3">{{ $product->stock }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 mr-2">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-app-layout>
