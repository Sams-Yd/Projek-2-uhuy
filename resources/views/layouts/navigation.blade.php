<nav x-data="{ open: false }" class="bg-gradient-to-r from-slate-900 via-purple-700 to-blue-700 text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="flex items-center gap-3">
                    <div class="bg-white/10 p-2 rounded-md">
                        <span class="text-xl">📚</span>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="font-bold text-lg">Mitus Stationery</span>
                        <small class="text-xs text-white/70">Memudahkan kehidupan anda</small>
                    </div>
                </a>
            </div>

            <div class="flex-1 mx-6 hidden lg:block">
                <form action="{{ route('products.index') }}" method="GET" class="flex">
                    <input name="search" value="{{ request('search') }}" placeholder="Cari produk, kategori, atau merek..." class="w-full rounded-l-md px-4 py-2 text-slate-900" />
                    <button class="bg-white text-slate-900 px-4 rounded-r-md font-semibold">Cari</button>
                </form>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="hidden sm:inline-block px-3 py-2 rounded hover:bg-white/10">Beranda</a>
                <a href="{{ route('products.index') }}" class="hidden sm:inline-block px-3 py-2 rounded hover:bg-white/10">Produk</a>
                @php
                    $cartCount = 0;
                    if(auth()->check()) {
                        $cart = \App\Models\Cart::where('user_id', auth()->id())->with('items')->first();
                        $cartCount = $cart ? $cart->items->sum('qty') : 0;
                    } else {
                        $cartCount = collect(session('cart_items', []))->sum('qty');
                    }
                @endphp
                <a href="{{ route('cart.index') }}" class="relative px-3 py-2 rounded hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4"/></svg>
                    <span class="absolute -top-1 -right-2 bg-red-500 text-white rounded-full text-xs px-1 cart-badge">{{ $cartCount }}</span>
                </a>

                @if (Route::has('login'))
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 px-3 py-2 rounded hover:bg-white/10">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                                <x-dropdown-link :href="route('dashboard')">Dashboard</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">@csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded hover:bg-white/10">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-3 py-2 bg-white text-slate-900 rounded">Daftar</a>
                        @endif
                    @endauth
                @endif

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button @click="open = ! open" class="p-2 rounded hover:bg-white/10">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="lg:hidden bg-gradient-to-r from-slate-900 via-purple-700 to-blue-700/95">
        <div class="px-4 pt-4 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-white/10">Beranda</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded hover:bg-white/10">Produk</a>
            <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded hover:bg-white/10">Keranjang</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-white/10">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded hover:bg-white/10">Profil</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-white/10">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded hover:bg-white/10">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded hover:bg-white/10">Daftar</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function(){
    function updateCartBadge(count){
        const el = document.querySelector('.cart-badge');
        if(el) el.textContent = count ?? '0';
    }

    // Intercept forms that post to /cart/add to do AJAX and update badge
    document.querySelectorAll('form[action*="/cart/add"]').forEach(form=>{
        form.addEventListener('submit', async function(e){
            e.preventDefault();
            try{
                const fd = new FormData(form);
                const res = await fetch(form.action, { method: (form.method||'POST'), body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const json = await res.json();
                if(json && typeof json.count !== 'undefined') updateCartBadge(json.count);
            }catch(err){
                console.error('Add to cart failed, falling back to full submit', err);
                form.submit();
            }
        });
    });

    // Support buttons with class .add-to-cart-btn (inside or outside forms)
    document.querySelectorAll('.add-to-cart-btn').forEach(btn=>{
        btn.addEventListener('click', async function(e){
            const form = btn.closest('form');
            if(form && form.action && form.action.includes('/cart/add')){
                // trigger the form submit handler above
                e.preventDefault();
                form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                return;
            }

            // Fallback: data-product-id on button
            const pid = btn.dataset.productId;
            if(pid){
                e.preventDefault();
                try{
                    const fd = new FormData();
                    // try to read csrf token from meta or existing input
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    if(meta) fd.append('_token', meta.getAttribute('content'));
                    const res = await fetch('/cart/add/'+pid, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const json = await res.json();
                    if(json && typeof json.count !== 'undefined') updateCartBadge(json.count);
                }catch(err){ console.error(err); }
            }
        });
    });
});
</script>
