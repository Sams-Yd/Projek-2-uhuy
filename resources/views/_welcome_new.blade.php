<x-app-layout>
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-[#0f172a] via-[#4f46e5] to-[#06b6d4] opacity-20 pointer-events-none"></div>

        <!-- Hero -->
        <section class="pt-24 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Mitus Stationery</h1>
                <p class="text-lg text-slate-200 max-w-3xl mx-auto">Solusi alat tulis modern — cepat, nyaman, dan tepercaya. Jelajahi koleksi kami dan temukan alat tulis yang cocok untuk kebutuhan kerja dan sekolah.</p>
                <div class="mt-8 flex justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg font-semibold">Lihat Semua Produk</a>
                    <a href="#products" class="px-6 py-3 border border-white/20 rounded-lg">Telusuri Produk</a>
                </div>
            </div>
        </section>

        <!-- Stationery Images (aesthetic) -->
        <section class="py-8 bg-gradient-to-b from-transparent to-white/3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-4">Aesthetic Stationery Picks</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @php
                        $images = [
                            'assets/img/1751274000_Pensil.jpeg',
                            'assets/img/1751274007_pulpen.jpeg',
                            'assets/img/1751274028_Buku.jpeg',
                            'assets/img/sample_notebook.jpg'
                        ];
                    @endphp
                    @foreach($images as $img)
                        <div class="rounded-xl overflow-hidden shadow-lg bg-white/5">
                            <img src="{{ asset($img) }}" alt="stationery" class="w-full h-40 object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- About Store -->
        <section class="py-12">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">Welcome to Mitus Stationery</h2>
                <p class="text-slate-200 whitespace-pre-line">Tempat belanja alat tulis yang simple, smart, and easy

Di sini kamu bisa nemuin berbagai kebutuhan ATK — dari yang basic sampai yang wajib ada di meja kerja atau sekolah kamu. Belanjanya gampang, tampilannya clean, dan fiturnya dibuat biar kamu nggak ribet.

With smart features, real-time order tracking, dan dashboard yang rapi, Mitus Stationery siap jadi your go-to stationery store, anytime, anywhere.
Let’s make work & study more productive</p>
            </div>
        </section>

        <!-- Products: grid + horizontal slider -->
        <section id="products" class="py-12 bg-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Produk Unggulan</h2>
                    <div class="flex gap-3">
                        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white">Lihat Semua</a>
                    </div>
                </div>

                @php $products = \App\Models\Product::latest()->take(12)->get(); @endphp

                <!-- Grid for desktop -->
                <div class="hidden md:grid grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="block bg-white/6 rounded-lg p-4 hover:scale-[1.02] transition">
                            <div class="h-40 mb-3 bg-white/5 rounded overflow-hidden flex items-center justify-center">
                                <img src="{{ asset($product->image ?? 'assets/img/placeholder.png') }}" alt="{{ $product->name }}" class="object-contain h-36">
                            </div>
                            <div class="text-sm text-slate-200 font-semibold">{{ $product->name }}</div>
                            <div class="text-xs text-slate-400">{{ $product->category ?? '-' }}</div>
                            <div class="mt-2 font-bold text-slate-200">Rp{{ number_format($product->price,0,',','.') }}</div>
                        </a>
                    @endforeach
                </div>

                <!-- Horizontal slider for mobile -->
                <div class="md:hidden overflow-x-auto py-2">
                    <div class="flex gap-4 px-2">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product->id) }}" class="min-w-[200px] bg-white/6 rounded-lg p-3">
                                <div class="h-36 mb-2 flex items-center justify-center">
                                    <img src="{{ asset($product->image ?? 'assets/img/placeholder.png') }}" alt="{{ $product->name }}" class="object-contain h-28">
                                </div>
                                <div class="text-sm text-slate-200 font-semibold">{{ $product->name }}</div>
                                <div class="text-xs text-slate-400">{{ $product->category ?? '-' }}</div>
                                <div class="mt-1 font-bold text-slate-200">Rp{{ number_format($product->price,0,',','.') }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Location -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-4">Lokasi Toko</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white/5 rounded-lg p-6">
                        <p class="text-slate-200 mb-4">Kunjungi toko offline kami untuk melihat koleksi secara langsung. Klik tombol di bawah untuk membuka lokasi di Google Maps.</p>
                        <a href="https://maps.app.goo.gl/ZydszXNwBipakxFu9" target="_blank" class="inline-block px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white">Buka di Google Maps</a>
                    </div>
                    <div class="bg-white/5 rounded-lg overflow-hidden">
                        <iframe src="https://www.google.com/maps?q=-6.200000,106.816666&z=15&output=embed" class="w-full h-64 border-0" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-10 bg-black/60 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-400">
                <div class="mb-4">© {{ date('Y') }} Mitus Stationery — Semua hak dilindungi.</div>
                <div class="text-sm">Designed with ❤️ — Mitus Team</div>
            </div>
        </footer>
    </div>
</x-app-layout>
