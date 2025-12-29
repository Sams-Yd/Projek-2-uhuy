<x-app-layout>
    <div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-800 py-8">
        <div class="absolute inset-0 z-0 pointer-events-none bg-[radial-gradient(ellipse_at_center,_rgba(99,102,241,0.06),_rgba(14,165,233,0.03))]"></div>

        <!-- Include Swiper CDN -->
        <link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css" />
        <script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>

        <style>
            /* Smooth reveal animations */
            .reveal { opacity: 0; transform: translateY(18px) scale(0.995); transition: opacity 700ms cubic-bezier(.2,.9,.2,1), transform 700ms cubic-bezier(.2,.9,.2,1); will-change: opacity, transform; }
            .reveal.in-view { opacity: 1; transform: translateY(0) scale(1); }

            /* Gentle floating blob for hero background */
            @keyframes floaty { 0% { transform: translateY(0px) } 50% { transform: translateY(-10px) } 100% { transform: translateY(0px) } }
            .floaty { animation: floaty 6s ease-in-out infinite; }

            /* Product card micro-interaction */
            .product-card { transition: transform 300ms cubic-bezier(.2,.9,.2,1), box-shadow 300ms; will-change: transform; }
            .product-card:hover { transform: translateY(-8px) rotateX(2deg); box-shadow: 0 18px 40px rgba(16,24,40,0.12); }

            /* Image smoothness */
            .product-img { transition: transform 400ms ease, object-position 400ms ease; }
            .product-card:active .product-img { transform: scale(0.98); }

            /* Buttons */
            .btn-smooth { transition: transform 220ms cubic-bezier(.2,.9,.2,1), box-shadow 220ms; }
            .btn-smooth:active { transform: translateY(1px) scale(0.997); }

            /* Subtle text shadow on hero title */
            .hero-title { text-shadow: 0 6px 30px rgba(255, 200, 200, 0.06); }

            /* Swiper tweaks */
            .swiper-container { padding-bottom: 1.15rem; }
            .swiper-slide { display: flex; align-items: stretch; justify-content: center; }
            .swiper-slide > a { width: 100%; }
        </style>

        <!-- Hero (background image, lighter/fun colors) -->
        <section class="pt-24 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-2xl overflow-hidden shadow-lg floaty" style="background-image: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(250,250,255,0.92)), url('{{ asset('assets/img/1751274028_Buku.jpeg') }}'); background-size: cover; background-position: center;">
                    <div class="p-12 text-center" style="backdrop-filter: blur(6px);">
                        <h1 class="text-5xl md:text-6xl font-extrabold mb-4 hero-title reveal" style="font-family: 'Poppins', ui-sans-serif, system-ui;">Mitus Stationery</h1>
                        <p class="text-lg text-slate-700 max-w-3xl mx-auto reveal" style="transition-delay:80ms">Solusi alat tulis modern — cepat, nyaman, dan tepercaya. Jelajahi koleksi kami dan temukan alat tulis yang cocok untuk kebutuhan kerja dan sekolah.</p>
                        <div class="mt-8 flex justify-center gap-4 reveal" style="transition-delay:160ms">
                            <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gradient-to-r from-[#667eea] to-[#764ba2] hover:from-[#5566d4] hover:to-[#5b3fa8] text-white rounded-lg font-semibold btn-smooth">Lihat Semua Produk</a>
                            <a href="#products" class="px-6 py-3 border border-[#667eea]/30 rounded-lg btn-smooth text-[#334155]">Telusuri Produk</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- (Removed image carousel for cleaner aesthetic; hero uses background image instead) -->

        <!-- About Store (image left, text right) -->
        <section class="py-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="order-1 md:order-1">
                        <img src="{{ asset('assets/img/background_Atk.jpg') }}" alt="about stationery" class="w-full rounded-2xl shadow-lg object-cover h-72">
                    </div>
                    <div class="order-2 md:order-2">
                        <h2 class="text-3xl font-bold mb-4" style="color:#0f172a">Welcome to Mitus Stationery</h2>
                        <p class="text-slate-700 whitespace-pre-line">Tempat belanja alat tulis yang simple, smart, and easy

Di sini kamu bisa nemuin berbagai kebutuhan ATK — dari yang basic sampai yang wajib ada di meja kerja atau sekolah kamu. Belanjanya gampang, tampilannya clean, dan fiturnya dibuat biar kamu nggak ribet.

With smart features, real-time order tracking, dan dashboard yang rapi, Mitus Stationery siap jadi your go-to stationery store, anytime, anywhere.
Let’s make work & study more productive</p>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" class="inline-block px-5 py-3 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white rounded-lg font-semibold btn-smooth">Mulai Belanja</a>
                        </div>
                    </div>
                </div>
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

                <!-- Swiper slider (desktop + mobile) -->
                <div>
                    <div class="swiper-container swiper-products py-4">
                        <div class="swiper-wrapper">
                            @foreach($products as $product)
                                <div class="swiper-slide">
                                    <a href="{{ route('products.show', $product->id) }}" class="product-card block bg-white/80 text-slate-800 rounded-lg p-3 reveal">
                                        <div class="h-36 mb-2 flex items-center justify-center">
                                            <img src="{{ asset($product->image ?? 'assets/img/placeholder.png') }}" alt="{{ $product->name }}" class="product-img object-contain h-28">
                                        </div>
                                        <div class="text-sm font-semibold">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-600">{{ $product->category ?? '-' }}</div>
                                        <div class="mt-1 font-bold text-rose-600">Rp{{ number_format($product->price,0,',','.') }}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <!-- Add Arrows + Pagination -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
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
                        <a href="https://maps.app.goo.gl/ZydszXNwBipakxFu9" target="_blank" class="inline-block px-4 py-2 bg-gradient-to-r from-[#667eea] to-[#764ba2] hover:from-[#5566d4] hover:to-[#5b3fa8] rounded-lg text-white">Buka di Google Maps</a>
                    </div>
                    <div class="bg-white/80 rounded-lg overflow-hidden">
                        <iframe src="https://www.google.com/maps?q=-6.200000,106.816666&z=15&output=embed" class="w-full h-64 border-0" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rating toko: dynamic from DB -->
        @php
            $avgRating = \App\Models\Review::avg('rating') ?? 0;
            $reviewCount = \App\Models\Review::count();
            $recentReviews = \App\Models\Review::with('user','product')->latest()->take(4)->get();
        @endphp

        <section aria-label="Rating toko" class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white/80 rounded-2xl p-8 shadow-sm reveal">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold mb-2">Rating Toko</h3>
                            <div class="flex items-center gap-4">
                                <div class="text-5xl font-extrabold text-slate-900">{{ number_format($avgRating, 1) }}</div>
                                <div>
                                    <div class="flex items-center text-amber-400 gap-1" aria-hidden="true">
                                        @php $fullStars = floor($avgRating); $half = ($avgRating - $fullStars) >= 0.5; @endphp
                                        @for($i=0;$i<5;$i++)
                                            @if($i < $fullStars)
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 .587l3.668 7.431L23.5 9.75l-5.667 5.522L19.333 24 12 20.202 4.667 24l1.5-8.728L.5 9.75l7.832-1.732L12 .587z"/></svg>
                                            @elseif($i == $fullStars && $half)
                                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><defs><linearGradient id="half"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="transparent"/></linearGradient></defs><path d="M12 .587l3.668 7.431L23.5 9.75l-5.667 5.522L19.333 24 12 20.202 4.667 24l1.5-8.728L.5 9.75l7.832-1.732L12 .587z" fill="url(#half)"/></svg>
                                            @else
                                                <svg class="w-5 h-5 text-amber-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 .587l3.668 7.431L23.5 9.75l-5.667 5.522L19.333 24 12 20.202 4.667 24l1.5-8.728L.5 9.75l7.832-1.732L12 .587z"/></svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="text-sm text-slate-600">Berdasarkan {{ $reviewCount }} ulasan</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1">
                            <h4 class="text-lg font-medium mb-2">Ulasan Terbaru</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @forelse($recentReviews as $r)
                                    <div class="bg-white rounded-lg p-3 shadow-sm">
                                        <div class="text-sm font-semibold">{{ $r->user?->name ?? 'Pengguna' }}</div>
                                        <div class="text-xs text-slate-600">{{ \Illuminate\Support\Str::limit($r->comment ?? ($r->product?->name ? 'Membeli ' . $r->product->name : 'Ulasan tidak tersedia'), 120) }}</div>
                                    </div>
                                @empty
                                    <div class="bg-white rounded-lg p-3 shadow-sm">Belum ada ulasan.</div>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex-none">
                            <a href="{{ route('products.index') }}" class="inline-block px-5 py-3 bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white rounded-lg font-semibold btn-smooth">Lihat Ulasan & Produk</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-10 bg-transparent mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-600">
                <div class="mb-4">© {{ date('Y') }} Mitus Stationery — Semua hak dilindungi.</div>
                <div class="text-sm">Designed by zou and team</div>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                try {
                    const productsSwiper = new Swiper('.swiper-products', {
                        slidesPerView: 1.2,
                        spaceBetween: 16,
                        loop: true,
                        speed: 700,
                        grabCursor: true,
                        centeredSlides: true,
                        autoplay: { delay: 3500, disableOnInteraction: false },
                        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                        pagination: { el: '.swiper-pagination', clickable: true },
                        breakpoints: {
                            640: { slidesPerView: 1.8, spaceBetween: 18 },
                            1024: { slidesPerView: 3, spaceBetween: 24 }
                        }
                    });

                    // Reveal animation observer
                    const observer = new IntersectionObserver((entries)=>{
                        entries.forEach(e=>{
                            if(e.isIntersecting){ e.target.classList.add('in-view'); observer.unobserve(e.target); }
                        });
                    }, { threshold: 0.08 });
                    document.querySelectorAll('.reveal').forEach(el=>observer.observe(el));
                } catch (e) {
                    console.error('Swiper init error', e);
                }
            });
        </script>
    </div>
</x-app-layout>
