<x-app-layout>
  <style>
    .glass-effect {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }
  </style>

  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
          🛒 Keranjang Belanja
        </h1>
        <p class="text-slate-600 mt-2">Periksa dan lanjutkan pembelian Anda</p>
      </div>

      @if(count($items) == 0)
        <!-- Empty Cart -->
        <div class="glass-effect rounded-2xl p-12 text-center">
          <div class="text-6xl mb-4">📭</div>
          <h2 class="text-2xl font-bold text-slate-900 mb-2">Keranjang Kosong</h2>
          <p class="text-slate-600 mb-6">Anda belum menambahkan produk ke keranjang. Mari mulai belanja!</p>
          <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition">
            🛍️ Jelajahi Produk
          </a>
        </div>
      @else
        <!-- Cart Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Items List -->
          <div class="lg:col-span-2">
            <div class="glass-effect rounded-2xl overflow-hidden">
              @php $total = 0; @endphp
              @foreach($items as $it)
                @php 
                  $p = $it->product ?? (object)($it['product'] ?? null); 
                  $qty = $it->qty ?? $it['qty']; 
                  $subtotal = ($p->price ?? 0) * $qty; 
                  $total += $subtotal;
                @endphp
                <div class="p-6 border-b border-slate-200 hover:bg-slate-50 transition">
                  <div class="flex gap-4">
                    <!-- Product Image -->
                    <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                      @php $img = $p->image ? basename($p->image) : 'default-product.png'; @endphp
                      <img src="{{ asset('assets/img/' . $img) }}" alt="{{ $p->name ?? 'Produk' }}" class="w-full h-full object-contain">
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1">
                      <h3 class="text-lg font-bold text-slate-900 mb-1">
                        {{ $p->name ?? 'Produk tidak ditemukan' }}
                      </h3>
                      <p class="text-blue-600 font-semibold mb-3">
                        Rp{{ number_format($p->price ?? 0, 0, ',', '.') }}
                      </p>
                      <div class="flex items-center gap-3">
                        <form action="{{ route('cart.update', $p->id ?? $it['product_id']) }}" method="POST" class="cart-update-form flex items-center gap-3" data-price="{{ $p->price ?? 0 }}" data-product-id="{{ $p->id ?? $it['product_id'] }}">
                          @csrf
                          <input type="hidden" name="qty" value="{{ $qty }}" class="qty-input">
                          <button type="button" class="qty-decrease px-3 py-1 bg-slate-100 rounded">−</button>
                          <span class="bg-slate-100 px-3 py-1 rounded font-semibold qty-display">{{ $qty }}</span>
                          <button type="button" class="qty-increase px-3 py-1 bg-slate-100 rounded">+</button>
                        </form>
                        <span class="text-slate-600">Subtotal:</span>
                        <span class="font-bold text-slate-900 item-subtotal" data-product-id="{{ $p->id ?? $it['product_id'] }}">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                      </div>
                    </div>

                    <!-- Remove Button -->
                    <div class="flex flex-col gap-2 justify-center">
                      <form action="{{ route('cart.remove', $p->id ?? $it['product_id']) }}" method="post">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition">
                          🗑️ Hapus
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- Continue Shopping -->
            <div class="mt-6">
              <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 text-blue-600 font-semibold hover:text-blue-700 transition">
                ← Lanjutkan Belanja
              </a>
            </div>
          </div>

          <!-- Summary -->
          <div class="lg:col-span-1">
            <div class="glass-effect rounded-2xl p-6 sticky top-24">
              <h2 class="text-2xl font-bold text-slate-900 mb-6">📊 Ringkasan Pesanan</h2>

              <!-- Items Count -->
              <div class="flex justify-between mb-4 pb-4 border-b border-slate-200">
                <span class="text-slate-600">Jumlah Item</span>
                <span class="font-semibold text-slate-900" id="cart-items-count">{{ collect($items)->sum(fn($it)=> $it->qty ?? $it['qty']) }} produk</span>
              </div>

              <!-- Subtotal -->
              <div class="flex justify-between mb-4 pb-4 border-b border-slate-200">
                <span class="text-slate-600">Subtotal</span>
                <span class="font-semibold text-slate-900" id="cart-total">Rp{{ number_format($total, 0, ',', '.') }}</span>
              </div>

              <!-- Shipping (Dummy) -->
              <div class="flex justify-between mb-4 pb-4 border-b border-slate-200">
                <span class="text-slate-600">Ongkir</span>
                <span class="font-semibold text-slate-900">Rp0 (Gratis)</span>
              </div>

              <!-- Total -->
              <div class="flex justify-between mb-6">
                <span class="text-lg font-bold text-slate-900">Total</span>
                <span id="cart-total-final" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                  Rp{{ number_format($total, 0, ',', '.') }}
                </span>
              </div>

              <!-- Checkout Button -->
              <a href="{{ route('checkout') }}" class="w-full block text-center px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 rounded-lg font-bold text-lg hover:from-yellow-500 hover:to-yellow-600 transition shadow-lg mb-3">
                ✓ Lanjut Checkout
              </a>

              <!-- Info -->
              <div class="bg-blue-50 rounded-lg p-4 text-sm text-blue-800">
                <p class="flex items-center gap-2">
                  <span>ℹ️</span>
                  <span>Pilihan pembayaran tersedia di halaman checkout</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
 <script>
  document.addEventListener('DOMContentLoaded', () => {
    // Fungsi update badge navbar
    function updateBadge(count) {
      const b = document.querySelector('.cart-badge');
      if (b) b.textContent = count;
    }

    // Fungsi utama untuk kirim data ke server
    async function sendUpdate(form) {
      const productId = form.dataset.productId;
      const qty = form.querySelector('.qty-input').value;
      const url = form.action;

      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ qty: qty })
        });

        const json = await res.json();

        if (json && json.success) {
          // 1. Update angka di tampilan (antara tombol + dan -)
          form.querySelector('.qty-display').textContent = json.qty;
          
          // 2. Update Subtotal barang tersebut
          const subtotalEl = document.querySelector(`.item-subtotal[data-product-id="${productId}"]`);
          if (subtotalEl) subtotalEl.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(json.itemSubtotal);
          
          // 3. Update Ringkasan Pesanan (Total Harga)
          const totalElements = document.querySelectorAll('#cart-total, .text-2xl.font-bold.bg-gradient-to-r');
          totalElements.forEach(el => {
              el.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(json.total);
          });

          // 4. Update Jumlah Item
          const countEl = document.getElementById('cart-items-count');
          if (countEl) countEl.textContent = json.count + ' produk';
          
          updateBadge(json.count);
        }
      } catch (err) {
        console.error('Update failed:', err);
      }
    }

    // Event Listener Tombol Kurang (-)
    document.querySelectorAll('.qty-decrease').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const form = btn.closest('.cart-update-form');
        const input = form.querySelector('.qty-input');
        let v = parseInt(input.value || '1');
        if (v > 1) {
          input.value = v - 1;
          sendUpdate(form);
        }
      });
    });

    // Event Listener Tombol Tambah (+)
    document.querySelectorAll('.qty-increase').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const form = btn.closest('.cart-update-form');
        const input = form.querySelector('.qty-input');
        let v = parseInt(input.value || '1');
        input.value = v + 1;
        sendUpdate(form);
      });
    });
  });
</script>
</x-app-layout>
