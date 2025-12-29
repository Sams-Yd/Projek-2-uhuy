<x-app-layout>
  <style>
    .glass-effect { background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.3); }
    .stat-icon { width:60px;height:60px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:28px }
    .card-hover{transition:all .25s cubic-bezier(.4,0,.2,1)} .card-hover:hover{transform:translateY(-8px);box-shadow:0 18px 30px rgba(2,6,23,0.08)}
    .hero-bg{position:absolute;inset:0;z-index:-1;background:radial-gradient(ellipse at center, rgba(79,70,229,0.08), rgba(6,182,212,0.04));}
    @keyframes floaty {0%{transform:translateY(0)}50%{transform:translateY(-8px)}100%{transform:translateY(0)}}
    .floaty{animation:floaty 6s ease-in-out infinite}
  </style>

  <div class="min-h-screen relative bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="hero-bg floaty"></div>
    <!-- Admin Navbar (kept simple; layout includes main nav) -->
    <div class="max-w-7xl mx-auto">
      <header class="mb-8 flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-extrabold text-slate-900">📊 Admin Dashboard</h1>
          <p class="text-slate-600">Kelola toko dan pantau performa</p>
        </div>
        <div class="text-sm text-slate-500">Halo, <strong>{{ Auth::user()->name }}</strong></div>
      </header>

      <!-- Stats -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="glass-effect rounded-2xl p-6 card-hover">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-600">Total Pesanan</p>
              <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalOrders) }}</p>
            </div>
            <div class="stat-icon bg-gradient-to-br from-blue-100 to-blue-200">📦</div>
          </div>
        </div>

        <div class="glass-effect rounded-2xl p-6 card-hover">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-600">Pesanan Tertunda</p>
              <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($pendingOrders) }}</p>
            </div>
            <div class="stat-icon bg-gradient-to-br from-yellow-100 to-yellow-200">⏳</div>
          </div>
        </div>

        <div class="glass-effect rounded-2xl p-6 card-hover">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-600">Total Produk</p>
              <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalProducts) }}</p>
            </div>
            <div class="stat-icon bg-gradient-to-br from-purple-100 to-purple-200">📚</div>
          </div>
        </div>

        <div class="glass-effect rounded-2xl p-6 card-hover">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-slate-600">Total Revenue</p>
              <p class="text-2xl font-bold text-slate-900 mt-2">Rp{{ number_format($totalRevenue,0,',','.') }}</p>
            </div>
            <div class="stat-icon bg-gradient-to-br from-green-100 to-green-200">💰</div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 glass-effect rounded-2xl p-6">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-slate-900">📋 Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders') }}" class="text-sm text-blue-600">Lihat Semua →</a>
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
                  <tr class="border-b hover:bg-slate-50 transition">
                    <td class="py-3 px-3 font-medium">#{{ $order->id }}</td>
                    <td class="py-3 px-3 text-slate-600">{{ $order->user?->name ?? 'Guest' }}</td>
                    <td class="py-3 px-3 font-semibold">Rp{{ number_format($order->total,0,',','.') }}</td>
                    <td class="py-3 px-3">
                      <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($order->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst($order->status) }}
                      </span>
                    </td>
                    <td class="py-3 px-3"><a href="{{ route('admin.orders.detail', $order) }}" class="text-blue-600">Lihat</a></td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="py-8 text-center text-slate-500">Belum ada pesanan</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="glass-effect rounded-2xl p-6">
          <h2 class="text-xl font-bold mb-4">⚡ Aksi Cepat</h2>
          <div class="space-y-3">
            <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 p-3 rounded-lg bg-white/50 hover:bg-white/60 transition"><span>📦</span><span class="font-medium">Kelola Pesanan</span></a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-white/50 hover:bg-white/60 transition"><span>👥</span><span class="font-medium">Kelola User</span></a>
            <a href="{{ route('admin.products') }}" class="flex items-center gap-3 p-3 rounded-lg bg-white/50 hover:bg-white/60 transition"><span>📚</span><span class="font-medium">Kelola Produk</span></a>
            <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 rounded-lg bg-white/50 hover:bg-white/60 transition"><span>🏪</span><span class="font-medium">Lihat Toko</span></a>
          </div>

          <div class="mt-6 bg-blue-50 rounded-lg p-4 text-sm text-blue-800">
            <strong>Selamat datang, {{ Auth::user()->name }}!</strong>
            <p class="mt-2 text-sm">Kelola toko dengan cepat dari panel ini.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
