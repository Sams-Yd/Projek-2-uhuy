<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="p-4 bg-white shadow rounded">
                <div class="text-sm text-slate-500">Total Orders</div>
                <div class="text-2xl font-bold">{{ number_format($totalOrders) }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded">
                <div class="text-sm text-slate-500">Pending Orders</div>
                <div class="text-2xl font-bold">{{ number_format($pendingOrders) }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded">
                <div class="text-sm text-slate-500">Total Revenue</div>
                <div class="text-2xl font-bold">Rp{{ number_format($totalRevenue,0,',','.') }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded">
                <div class="text-sm text-slate-500">Total Products</div>
                <div class="text-2xl font-bold">{{ number_format($totalProducts) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white shadow rounded p-4">
                <h2 class="font-bold mb-2">Recent Orders</h2>
                <table class="w-full text-sm">
                    <thead class="bg-slate-50"><tr><th class="p-2">#</th><th class="p-2">User</th><th class="p-2">Total</th><th class="p-2">Status</th></tr></thead>
                    <tbody>
                        @foreach($recentOrders as $o)
                            <tr class="border-b"><td class="p-2">#{{ $o->id }}</td><td class="p-2">{{ $o->user?->name ?? 'Guest' }}</td><td class="p-2">Rp{{ number_format($o->total,0,',','.') }}</td><td class="p-2">{{ $o->status }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow rounded p-4">
                <h2 class="font-bold mb-2">Top Products</h2>
                <ul>
                    @foreach($topProducts as $p)
                        <li class="py-2 border-b">{{ $p->name }} — Terjual: {{ $p->total_sold ?? 0 }}</li>
                    @endforeach
                </ul>

                <h2 class="font-bold mt-4 mb-2">Recent Promos</h2>
                <ul>
                    @foreach($promos as $promo)
                        <li class="py-2 border-b">{{ $promo->code }} — {{ $promo->type }} {{ $promo->value }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Kelola Pesanan</a>
            <a href="{{ route('admin.products') }}" class="px-4 py-2 bg-green-600 text-white rounded ml-2">Kelola Produk</a>
            <a href="{{ route('admin.promos') }}" class="px-4 py-2 bg-purple-600 text-white rounded ml-2">Manajemen Promo</a>
            <a href="{{ route('admin.analytics') }}" class="px-4 py-2 bg-indigo-600 text-white rounded ml-2">Analitik</a>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
  <style>
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
    .card-hover {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-hover:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
  </style>

  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100">
    <!-- Admin Navbar -->
    <nav class="bg-white border-b border-slate-200 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center gap-8">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
              🏢 Admin
            </a>
            <div class="hidden md:flex items-center gap-6">
              <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-purple-100 text-purple-700' : 'text-slate-700 hover:bg-slate-100' }} transition">
                📊 Dashboard
              </a>
              <a href="{{ route('admin.orders') }}" class="px-3 py-2 rounded-lg font-semibold {{ request()->routeIs('admin.orders*') ? 'bg-purple-100 text-purple-700' : 'text-slate-700 hover:bg-slate-100' }} transition">
                📦 Pesanan
              </a>
              <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg font-semibold {{ request()->routeIs('admin.users*') ? 'bg-purple-100 text-purple-700' : 'text-slate-700 hover:bg-slate-100' }} transition">
                👥 User
              </a>
            </div>
          </div>

          <!-- User Menu -->
          <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="px-3 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition">
              👁️ Lihat Toko
            </a>
            <div class="h-8 w-px bg-slate-200"></div>
            <div class="flex items-center gap-2">
              <span class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
              <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-blue-500 flex items-center justify-center text-white font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
          <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
            📊 Dashboard Admin
          </h1>
          <p class="text-slate-600 mt-2">Kelola toko dan monitor penjualan Anda</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <!-- Total Orders -->
          <div class="glass-effect rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-slate-600 text-sm font-medium">Total Pesanan</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalOrders }}</p>
                <p class="text-xs text-slate-500 mt-2">📈 Semua waktu</p>
              </div>
              <div class="stat-icon bg-gradient-to-br from-blue-100 to-blue-200 text-2xl">📦</div>
            </div>
          </div>

          <!-- Pending Orders -->
          <div class="glass-effect rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-slate-600 text-sm font-medium">Pesanan Tertunda</p>
                @php $pending = \App\Models\Order::where('status', 'pending')->count(); @endphp
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $pending }}</p>
                <p class="text-xs text-slate-500 mt-2">⏳ Perlu diproses</p>
              </div>
              <div class="stat-icon bg-gradient-to-br from-yellow-100 to-yellow-200 text-2xl">⏳</div>
            </div>
          </div>

          <!-- Total Users -->
          <div class="glass-effect rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-slate-600 text-sm font-medium">Total User</p>
                @php $totalUsers = \App\Models\User::count(); @endphp
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalUsers }}</p>
                <p class="text-xs text-slate-500 mt-2">👥 Terdaftar</p>
              </div>
              <div class="stat-icon bg-gradient-to-br from-purple-100 to-purple-200 text-2xl">👥</div>
            </div>
          </div>

          <!-- Total Revenue -->
          <div class="glass-effect rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-slate-600 text-sm font-medium">Total Revenue</p>
                @php $revenue = \App\Models\Order::sum('total'); @endphp
                <p class="text-3xl font-bold text-slate-900 mt-2">Rp{{ number_format($revenue, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">💰 Komulat</p>
              </div>
              <div class="stat-icon bg-gradient-to-br from-green-100 to-green-200 text-2xl">💰</div>
            </div>
          </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Recent Orders Table -->
          <div class="lg:col-span-2">
            <div class="glass-effect rounded-2xl p-6">
              <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-slate-900">📋 Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua →</a>
              </div>

              <div class="overflow-x-auto">
                <table class="w-full text-sm">
                  <thead>
                    <tr class="border-b border-slate-200">
                      <th class="text-left py-3 px-3 font-semibold text-slate-700">ID</th>
                      <th class="text-left py-3 px-3 font-semibold text-slate-700">Pelanggan</th>
                      <th class="text-left py-3 px-3 font-semibold text-slate-700">Total</th>
                      <th class="text-left py-3 px-3 font-semibold text-slate-700">Status</th>
                      <th class="text-left py-3 px-3 font-semibold text-slate-700">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($recentOrders as $order)
                      <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-3 px-3 text-slate-900 font-medium">#{{ $order->id }}</td>
                        <td class="py-3 px-3 text-slate-600">{{ $order->customer_name }}</td>
                        <td class="py-3 px-3 text-slate-900 font-semibold">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="py-3 px-3">
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
                        <td class="py-3 px-3">
                          <a href="{{ route('admin.orders.detail', $order) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                            Lihat
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="py-8 px-3 text-center text-slate-500">
                          Belum ada pesanan
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div>
            <div class="glass-effect rounded-2xl p-6 h-full">
              <h2 class="text-xl font-bold text-slate-900 mb-4">⚡ Aksi Cepat</h2>
              <div class="space-y-3">
                <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition">
                  <span class="text-xl">📦</span>
                  <span class="font-medium text-slate-900">Kelola Pesanan</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition">
                  <span class="text-xl">👥</span>
                  <span class="font-medium text-slate-900">Kelola User</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition">
                  <span class="text-xl">📚</span>
                  <span class="font-medium text-slate-900">Kelola Produk</span>
                </a>
                <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition">
                  <span class="text-xl">🏪</span>
                  <span class="font-medium text-slate-900">Lihat Toko</span>
                </a>
              </div>

              <!-- Info Box -->
              <div class="mt-6 bg-blue-50 rounded-lg p-4 text-sm text-blue-800">
                <p class="flex items-start gap-2">
                  <span>ℹ️</span>
                  <span><strong>Selamat datang, {{ Auth::user()->name }}!</strong> Kelola semua aspek toko dari sini.</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
