<x-app-layout>
  <style>
    .product-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 240, 250, 1) 100%);
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    .product-badge {
      position: absolute;
      top: 8px;
      right: 8px;
    }
    .stock-status {
      transition: all 0.3s ease;
    }
    .wishlist-btn {
      cursor: pointer;
    }
  </style>

  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Header Section -->
      <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
              🛍️ Jelajahi Produk
            </h1>
            <p class="text-slate-600 mt-2">Temukan alat tulis berkualitas dengan harga terbaik</p>
          </div>
          <div class="text-right">
            <p class="text-sm text-slate-500">Total: <span class="font-bold text-slate-900">{{ $products->total() }}</span> Produk</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar Filter -->
        <div class="lg:col-span-1">
          <form action="{{ route('products.index') }}" method="GET" id="filterForm" class="bg-white p-6 rounded-lg shadow-sm">
            <!-- Search -->
            <div class="mb-6">
              <label class="block text-sm font-semibold text-slate-900 mb-2">Cari Produk</label>
              <input type="text" name="search" placeholder="Nama produk..." 
                     value="{{ request('search') }}"
                     class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </div>

            <!-- Category Filter -->
            <div class="mb-6">
              <label class="block text-sm font-semibold text-slate-900 mb-2">Kategori</label>
              <select name="category" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Price Range Filter -->
            <div class="mb-6">
              <label class="block text-sm font-semibold text-slate-900 mb-2">Rentang Harga</label>
              <div class="flex gap-2 mb-2">
                <input type="number" name="min_price" placeholder="Min" 
                       value="{{ request('min_price') }}"
                       class="w-1/2 px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                <input type="number" name="max_price" placeholder="Max" 
                       value="{{ request('max_price') }}"
                       class="w-1/2 px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
              </div>
            </div>

            <!-- Sort -->
            <div class="mb-6">
              <label class="block text-sm font-semibold text-slate-900 mb-2">Urutkan</label>
              <select name="sort" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
              </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
              <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Filter
              </button>
              <a href="{{ route('products.index') }}" class="flex-1 bg-slate-200 text-slate-900 px-4 py-2 rounded-lg font-semibold hover:bg-slate-300 transition text-center">
                Reset
              </a>
            </div>
          </form>

          @auth
          <div class="mt-4">
            <a href="{{ route('wishlist.index') }}" class="block w-full bg-red-100 text-red-700 px-4 py-2 rounded-lg font-semibold hover:bg-red-200 transition text-center">
              ❤️ Wishlist Saya
            </a>
          </div>
          @endauth
        </div>

        <!-- Products Grid -->
        <div class="lg:col-span-3">
          @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              @foreach($products as $product)
                <div class="product-card rounded-2xl shadow p-5 border border-white/50 flex flex-col overflow-hidden">
                  <!-- Product Image -->
                  <div class="relative mb-3 overflow-hidden rounded-lg bg-white/50 h-40 flex items-center justify-center">
                    @php
                      $img = $product->image ? basename($product->image) : 'default-product.png';
                    @endphp
                    <img src="{{ asset('assets/img/' . $img) }}" alt="{{ $product->name }}" class="h-full w-full object-contain hover:scale-110 transition">
                    
                    <!-- Stock Badge -->
                    <div class="product-badge">
                      @if($product->stock > 50)
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">✓ Stok Banyak</span>
                      @elseif($product->stock > 10)
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">⚠️ Stok Terbatas</span>
                      @else
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">⛔ Hampir Habis</span>
                      @endif
                    </div>

                    <!-- Wishlist Button -->
                    @auth
                    <button onclick="toggleWishlist({{ $product->id }})" 
                            class="wishlist-btn absolute top-2 left-2 text-2xl transition transform hover:scale-110"
                            id="wishlist-{{ $product->id }}"
                            data-in-wishlist="{{ in_array($product->id, $wishlistIds) ? 'true' : 'false' }}">
                      {{ in_array($product->id, $wishlistIds) ? '❤️' : '🤍' }}
                    </button>
                    @endauth
                  </div>

                  <!-- Product Info -->
                  <h3 class="font-bold text-lg text-slate-900 mb-1 text-center line-clamp-2">{{ $product->name }}</h3>
                  <p class="text-blue-600 font-bold text-lg mb-1 text-center">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                  @if($product->category)
                    <p class="text-sm text-slate-500 mb-1 text-center">📂 
                      @if(is_string($product->category))
                        {{ $product->category }}
                      @elseif(is_object($product->category) && isset($product->category->name))
                        {{ $product->category->name }}
                      @else
                        {{ $product->category }}
                      @endif
                    </p>
                  @endif
                  
                  <!-- Rating -->
                  <div class="text-center mb-1">
                    @php
                      $avgRating = $product->averageRating();
                      $reviewCount = $product->reviewCount();
                    @endphp
                    <span class="text-sm text-yellow-500">
                      {{ $avgRating > 0 ? '★ ' . number_format($avgRating, 1) : 'Belum ada rating' }}
                      <span class="text-xs text-slate-500">({{ $reviewCount }})</span>
                    </span>
                  </div>
                  
                  <!-- Stock Info -->
                  <p class="text-xs mb-3 text-center font-semibold stock-status {{ $product->stock <= 0 ? 'text-red-500' : 'text-green-600' }}">
                    📦 Stok: {{ $product->stock }} item
                  </p>

                  <!-- Description -->
                  @if($product->description)
                    <p class="text-xs text-slate-600 mb-3 line-clamp-2">{{ $product->description }}</p>
                  @endif

                  <!-- Action Buttons -->
                  <div class="mt-auto space-y-2">
                    <a href="{{ route('products.show', $product->id) }}" class="inline-block w-full text-center bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:from-blue-600 hover:to-blue-700 transition">
                      👁️ Lihat Detail
                    </a>
                    <form action="{{ route('cart.add', $product->id) }}" method="post">
                      @csrf
                      <input type="hidden" name="qty" value="1">
                      <button 
                        type="submit" 
                        class="w-full px-4 py-2 rounded-lg shadow font-bold text-white transition disabled:opacity-50 disabled:cursor-not-allowed
                          @if($product->stock <= 0)
                            bg-gray-400 hover:bg-gray-400
                          @else
                            bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-slate-900
                          @endif"
                        {{ $product->stock <= 0 ? 'disabled' : '' }}
                      >
                        @if($product->stock <= 0)
                          ❌ Stok Habis
                        @else
                          🛒 Keranjang
                        @endif
                      </button>
                    </form>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
              {{ $products->links() }}
            </div>
          @else
            <div class="text-center py-16">
              <div class="text-6xl mb-4">📭</div>
              <h2 class="text-2xl font-bold text-slate-900 mb-2">Produk Tidak Tersedia</h2>
              <p class="text-slate-600 mb-6">Maaf, produk yang Anda cari tidak tersedia saat ini.</p>
              <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold">
                ← Reset Filter
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  @auth
  <script>
    function toggleWishlist(productId) {
      const btn = document.getElementById('wishlist-' + productId);
      
      fetch('/wishlist/toggle/' + productId, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'added') {
          btn.textContent = '❤️';
          btn.dataset.inWishlist = 'true';
        } else {
          btn.textContent = '🤍';
          btn.dataset.inWishlist = 'false';
        }
      });
    }
  </script>
  @endauth
</x-app-layout>
