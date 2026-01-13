<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-3xl font-bold mb-6">Daftar Wishlist Saya</h2>

                    @if($wishlists->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($wishlists as $wishlist)
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <div class="aspect-square bg-gray-100 overflow-hidden">
                                        @if($wishlist->product->image)
                                            {{-- Penyesuaian path gambar ke assets/img --}}
                                            <img src="{{ asset('assets/img/' . basename($wishlist->product->image)) }}" 
                                                 alt="{{ $wishlist->product->name }}"
                                                    class="w-full h-full object-cover"
                                                    onerror="this.src='{{ asset('assets/img/default-product.png') }}'">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                                 <span class="text-gray-400">Tidak ada gambar</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-4">
                                        <h3 class="font-semibold text-lg mb-2">
                                            <a href="{{ route('products.show', $wishlist->product->id) }}" 
                                               class="text-blue-600 hover:text-blue-700">
                                                {{ $wishlist->product->name }}
                                            </a>
                                        </h3>

                                        <p class="text-gray-600 text-sm mb-3">
                                            {{ Str::limit($wishlist->product->description, 100) }}
                                        </p>

                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-2xl font-bold text-blue-600">
                                                Rp{{ number_format($wishlist->product->price, 0, ',', '.') }}
                                            </span>
                                            @if($wishlist->product->stock > 0)
                                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                                    Stok: {{ $wishlist->product->stock }}
                                                </span>
                                            @else
                                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">
                                                    Habis
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex gap-2">
                                            <form action="{{ route('cart.add', $wishlist->product->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                                                    Tambah ke Keranjang
                                                </button>
                                            </form>

                                            <form action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $wishlists->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg mb-4">Wishlist Anda kosong</p>
                            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700">
                                Lihat Produk →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
