<x-app-layout>
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-success {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .gradient-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border-radius: 16px;
        }
        .product-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 35px -5px rgba(0, 0, 0, 0.15);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .add-to-cart-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .add-to-cart-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
    </style>

    <div class="min-h-screen relative bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-0 z-0 bg-[radial-gradient(ellipse_at_center,_rgba(99,102,241,0.06),_rgba(14,165,233,0.03))]"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        @if(Auth::check())
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                                Selamat Datang, {{ Auth::user()->name }}! 👋
                            </h1>
                            <p class="text-slate-600 mt-2">Dashboard pelanggan</p>
                        @else
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                                Katalog Produk 🛍️
                            </h1>
                            <p class="text-slate-600 mt-2">Jelajahi koleksi produk kami yang menarik - <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700">Login untuk checkout</a></p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500">{{ now()->translatedFormat('l, j F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- User Stats Grid - Hanya untuk yang login -->
            @if(Auth::check())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- My Orders -->
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Pesanan Saya</p>
                            @php $myOrders = \App\Models\Order::where('user_id', Auth::id())->count(); @endphp
                            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $myOrders }}</p>
                            <p class="text-xs text-slate-500 mt-2">🛍️ Total pesanan</p>
                        </div>
                        <div class="stat-icon gradient-primary text-white">📦</div>
                    </div>
                </div>

                <!-- Pending Pesanan -->
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Pesanan Tertunda</p>
                            @php $pendingOrders = \App\Models\Order::where('user_id', Auth::id())->where('status', 'pending')->count(); @endphp
                            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $pendingOrders }}</p>
                            <p class="text-xs text-slate-500 mt-2">⏳ Perlu diproses</p>
                        </div>
                        <div class="stat-icon gradient-warning text-white">⏳</div>
                    </div>
                </div>

                <!-- Total Spending -->
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Total Belanja</p>
                            @php $totalSpent = \App\Models\Order::where('user_id', Auth::id())->sum('total'); @endphp
                            <p class="text-2xl font-bold text-slate-900 mt-2">Rp{{ number_format($totalSpent, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500 mt-2">💰 Sepanjang waktu</p>
                        </div>
                        <div class="stat-icon gradient-success text-white">💰</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Main Content Grid -->
            <div class="mb-8 w-full">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">🛒 Belanja Produk</h2>
                        @if(!Auth::check())
                            <p class="text-slate-600 text-sm mt-1">Lihat koleksi produk kami - login untuk checkout</p>
                        @else
                            <p class="text-slate-600 text-sm mt-1">Pilih dan checkout produk langsung dari dashboard</p>
                        @endif
                    </div>
                </div>

                @php $products = \App\Models\Product::where('stock', '>', 0)->get(); @endphp
                
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="glass-effect product-card overflow-hidden flex flex-col">
                                <!-- Product Image -->
                                <div class="relative bg-gradient-to-br from-slate-100 to-slate-200 h-48 flex items-center justify-center overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                                    @else
                                        <div class="text-5xl">📦</div>
                                    @endif
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-block px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full">
                                            Stok: {{ $product->stock }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 p-4 flex flex-col">
                                    <h3 class="text-lg font-bold text-slate-900 mb-1 line-clamp-2">{{ $product->name }}</h3>
                                    <p class="text-slate-600 text-sm mb-3 line-clamp-2">{{ $product->description ?? 'Produk berkualitas' }}</p>
                                    
                                    <div class="flex items-baseline gap-2 mb-4">
                                        <span class="text-2xl font-bold gradient-primary bg-clip-text text-transparent">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Quick Add to Cart -->
                                    @if(Auth::check())
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                            @csrf
                                            <div class="flex gap-2 mb-3">
                                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                                       class="w-20 px-2 py-2 border border-slate-300 rounded-lg text-center focus:outline-none focus:border-purple-500">
                                                <button type="submit" class="flex-1 add-to-cart-btn text-white font-bold py-2 rounded-lg">
                                                    Tambah 🛒
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="mt-auto mb-3">
                                            <a href="{{ route('login') }}" class="flex-1 w-full text-center add-to-cart-btn text-white font-bold py-2 rounded-lg block">
                                                Login untuk Pesan
                                            </a>
                                        </div>
                                    @endif

                                    <!-- View Detail Button -->
                                    <a href="{{ route('products.show', $product->id) }}" class="w-full text-center px-3 py-2 border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- View All Products -->
                    <div class="text-center mt-8">
                        <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 gradient-primary text-white font-bold rounded-lg hover:shadow-lg transition">
                            Lihat Semua Produk →
                        </a>
                    </div>
                @else
                    <div class="glass-effect rounded-2xl p-12 text-center">
                        <p class="text-slate-600 text-lg mb-4">Tidak ada produk yang tersedia saat ini</p>
                        <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 gradient-primary text-white font-medium rounded-lg">
                            Cek Halaman Produk
                        </a>
                    </div>
                @endif
            </div>

            <!-- Recent Orders Grid - Hanya untuk yang login -->
            @if(Auth::check())
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2">
                    <div class="glass-effect rounded-2xl p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-slate-900">📋 Pesanan Terbaru</h2>
                        </div>

                        <div class="overflow-x-auto">
                            @php
                                $myRecentOrders = \App\Models\Order::where('user_id', Auth::id())->latest()->limit(5)->get();
                            @endphp
                            @if($myRecentOrders->count() > 0)
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-slate-200">
                                            <th class="text-left py-2 px-2 font-semibold text-slate-700">ID</th>
                                            <th class="text-left py-2 px-2 font-semibold text-slate-700">Total</th>
                                            <th class="text-left py-2 px-2 font-semibold text-slate-700">Status</th>
                                            <th class="text-left py-2 px-2 font-semibold text-slate-700">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($myRecentOrders as $order)
                                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                                <td class="py-2 px-2 text-slate-900 font-medium">#{{ $order->id }}</td>
                                                <td class="py-2 px-2 text-slate-900 font-semibold">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                                <td class="py-2 px-2">
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                        @if($order->status === 'completed')
                                                            bg-green-100 text-green-800
                                                        @elseif($order->status === 'pending')
                                                            bg-yellow-100 text-yellow-800
                                                        @elseif($order->status === 'cancelled')
                                                            bg-red-100 text-red-800
                                                        @else
                                                            bg-blue-100 text-blue-800
                                                        @endif
                                                    ">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="py-2 px-2 text-slate-600">{{ $order->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-slate-500">Belum ada pesanan</p>
                                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700 font-medium mt-2 inline-block">
                                        Mulai Belanja →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="glass-effect rounded-2xl p-6 h-full">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">⚡ Aksi Cepat</h2>
                        <div class="space-y-3">
                            <a href="{{ route('cart.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-blue-100 to-blue-50 hover:from-blue-200 hover:to-blue-100 transition">
                                <span class="text-xl">🛒</span>
                                <span class="font-medium text-slate-900">Keranjang</span>
                                @include('partials._cart_count')
                            </a>
                            <a href="{{ route('checkout') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-green-100 to-green-50 hover:from-green-200 hover:to-green-100 transition">
                                <span class="text-xl">💳</span>
                                <span class="font-medium text-slate-900">Checkout</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-purple-100 to-purple-50 hover:from-purple-200 hover:to-purple-100 transition">
                                <span class="text-xl">⚙️</span>
                                <span class="font-medium text-slate-900">Pengaturan</span>
                            </a>
                            <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-orange-100 to-orange-50 hover:from-orange-200 hover:to-orange-100 transition">
                                <span class="text-xl">🏪</span>
                                <span class="font-medium text-slate-900">Toko Utama</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Additional Sections - Hanya untuk yang login -->
            @if(Auth::check())
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Account Info -->
                <div class="glass-effect rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">👤 Informasi Akun</h2>
                    <div class="space-y-3 text-slate-600">
                        <div class="flex justify-between">
                            <span>Nama</span>
                            <span class="font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Email</span>
                            <span class="font-semibold text-slate-900">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status</span>
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">✓ Aktif</span>
                        </div>
                        <div class="pt-3 border-t border-slate-200">
                            <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                Ubah Profil →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="glass-effect rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">💡 Tips Penggunaan</h2>
                    <ul class="space-y-2 text-slate-600 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-lg">✓</span>
                            <span>Pantau status pesanan Anda secara real-time</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-lg">✓</span>
                            <span>Simpan produk favorit untuk pembelian mudah</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-lg">✓</span>
                            <span>Gunakan wishlist untuk reminder pembelian</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-lg">✓</span>
                            <span>Hubungi kami jika ada pertanyaan</span>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
