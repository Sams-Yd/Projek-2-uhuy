<x-app-layout>
    <div class="relative overflow-hidden bg-gradient-to-br from-pink-50 via-yellow-50 to-indigo-50 text-slate-800">

        <!-- Include Swiper CDN -->
        <link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css" />
        <script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>

        <!-- Hero (background image, lighter/fun colors) -->
        <section class="pt-24 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-2xl overflow-hidden shadow-lg" style="background-image: linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,250,240,0.85)), url('{{ asset('assets/img/1751274028_Buku.jpeg') }}'); background-size: cover; background-position: center;">
                    <div class="p-12 text-center">
                        <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Mitus Stationery</h1>
                        <p class="text-lg text-slate-700 max-w-3xl mx-auto">Solusi alat tulis modern — cepat, nyaman, dan tepercaya. Jelajahi koleksi kami dan temukan alat tulis yang cocok untuk kebutuhan kerja dan sekolah.</p>
                        <div class="mt-8 flex justify-center gap-4">
                            <a href="{{ route('products.index') }}" class="px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white rounded-lg font-semibold">Lihat Semua Produk</a>
                            <a href="#products" class="px-6 py-3 border border-rose-200 rounded-lg">Telusuri Produk</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- (Removed image carousel for cleaner aesthetic; hero uses background image instead) -->

        <!-- About Store -->
        <section class="py-12">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-4">Welcome to Mitus Stationery</h2>
                <p class="text-slate-700 whitespace-pre-line">Tempat belanja alat tulis yang simple, smart, and easy

Di sini kamu bisa nemuin berbagai kebutuhan ATK — dari yang basic sampai yang wajib ada di meja kerja atau sekolah kamu. Belanjanya gampang, tampilannya clean, dan fiturnya dibuat biar kamu nggak ribet.

With smart features, real-time order tracking, dan dashboard yang rapi, Mitus Stationery siap jadi your go-to stationery store, anytime, anywhere.
Let’s make work & study more productive</p>
            </div>
        </section>

        <!-- Products: grid + Swiper slider for mobile/interactive -->
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
                        <a href="{{ route('products.show', $product->id) }}" class="block bg-white/80 text-slate-800 rounded-lg p-4 hover:scale-[1.02] transition">
                            <div class="h-40 mb-3 bg-white rounded overflow-hidden flex items-center justify-center">
                                <img src="{{ asset($product->image ?? 'assets/img/placeholder.png') }}" alt="{{ $product->name }}" class="object-contain h-36">
                            </div>
                            <div class="text-sm font-semibold">{{ $product->name }}</div>
                            <div class="text-xs text-slate-600">{{ $product->category ?? '-' }}</div>
                            <div class="mt-2 font-bold text-rose-600">Rp{{ number_format($product->price,0,',','.') }}</div>
                        </a>
                    @endforeach
                </div>

                <!-- Swiper slider (responsive) -->
                <div class="md:hidden">
                    <div class="swiper-container swiper-products py-4">
                        <div class="swiper-wrapper">
                            @foreach($products as $product)
                                <div class="swiper-slide min-w-[200px]">
                                    <a href="{{ route('products.show', $product->id) }}" class="block bg-white/80 text-slate-800 rounded-lg p-3">
                                        <div class="h-36 mb-2 flex items-center justify-center">
                                            <img src="{{ asset($product->image ?? 'assets/img/placeholder.png') }}" alt="{{ $product->name }}" class="object-contain h-28">
                                        </div>
                                        <div class="text-sm font-semibold">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-600">{{ $product->category ?? '-' }}</div>
                                        <div class="mt-1 font-bold text-rose-600">Rp{{ number_format($product->price,0,',','.') }}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location -->
        <section class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-4">Lokasi Toko</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white/80 text-slate-800 rounded-lg p-6">
                        <p class="text-slate-700 mb-4">Kunjungi toko offline kami untuk melihat koleksi secara langsung. Klik tombol di bawah untuk membuka lokasi di Google Maps.</p>
                        <a href="https://maps.app.goo.gl/ZydszXNwBipakxFu9" target="_blank" class="inline-block px-4 py-2 bg-rose-500 hover:bg-rose-600 rounded-lg text-white">Buka di Google Maps</a>
                    </div>
                    <div class="bg-white/80 rounded-lg overflow-hidden">
                        <iframe src="https://www.google.com/maps?q=-6.200000,106.816666&z=15&output=embed" class="w-full h-64 border-0" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-10 bg-transparent mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-600">
                <div class="mb-4">© {{ date('Y') }} Mitus Stationery — Semua hak dilindungi.</div>
                <div class="text-sm">Designed with ❤️ — Mitus Team</div>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                try {
                    new Swiper('.swiper-products', {
                        slidesPerView: 1,
                        spaceBetween: 12,
                        loop: false,
                        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                        breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 4 } }
                    });
                } catch (e) {
                    console.error('Swiper init error', e);
                }
            });
        </script>
    </div>
</x-app-layout>
