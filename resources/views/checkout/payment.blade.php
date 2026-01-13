<x-app-layout>
  <div class="min-h-screen py-12">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow">
      <h2 class="text-2xl font-bold mb-4">Pembayaran Pesanan #{{ $order->id }}</h2>
      <p class="mb-6">Total yang harus dibayar: <span class="font-bold">Rp{{ number_format($order->total,0,',','.') }}</span></p>

      <div id="payment-area" class="mb-6">
        <button id="pay-button" class="px-6 py-3 bg-blue-600 text-white rounded">Bayar dengan Midtrans</button>
      </div>

      <p class="text-sm text-slate-500">Setelah pembayaran selesai, status pesanan akan diperbarui otomatis.</p>
    </div>
  </div>

  @php $isProd = filter_var(config('services.midtrans.is_production'), FILTER_VALIDATE_BOOLEAN); @endphp
  <script src="{{ $isProd ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
  <script>
    document.getElementById('pay-button').addEventListener('click', function () {
      const token = "{{ $snapToken }}";
      snap.pay(token, {
        onSuccess: function(result){
          console.log('success', result);
          window.location.href = "{{ route('dashboard') }}";
        },
        onPending: function(result){
          console.log('pending', result);
          window.location.href = "{{ route('home') }}";
        },
        onError: function(result){
          console.log('error', result);
          alert('Pembayaran gagal. Silakan coba lagi.');
        }
      });
    });
  </script>
</x-app-layout>
