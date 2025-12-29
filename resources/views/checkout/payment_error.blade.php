<x-app-layout>
  <div class="min-h-screen py-12">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow">
      <h2 class="text-2xl font-bold mb-4">Kesalahan Konfigurasi Midtrans</h2>
      <p class="mb-6 text-slate-700">{{ $message }}</p>

      <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <p class="text-sm">Langkah yang harus dilakukan:</p>
        <ol class="text-sm list-decimal list-inside mt-2">
          <li>Tambahkan variabel berikut di file <strong>.env</strong>:</li>
        </ol>
        <pre class="bg-white p-3 rounded mt-2">MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false</pre>
        <ol start="2" class="text-sm list-decimal list-inside mt-2">
          <li>Jalankan perintah ini di terminal:</li>
        </ol>
        <pre class="bg-white p-3 rounded mt-2">php artisan config:clear
php artisan cache:clear</pre>
      </div>

      <div class="mt-6">
        <a href="{{ route('home') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded">Kembali ke Beranda</a>
      </div>
    </div>
  </div>
</x-app-layout>