<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-semibold text-white">Masuk ke Mitus</h2>
        <p class="text-sm text-white">Masuk untuk melanjutkan belanja dan melihat pesanan Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" />
             <x-text-input id="email" 
                  class="block mt-1 w-full text-slate-900" 
                  type="email" 
                  name="email" 
                  :value="old('email')" 
                  required 
                  autofocus 
                  autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-white" />

            <x-text-input id="password" 
                  class="block mt-1 w-full text-gray-900" 
                  type="password"
                  name="password"
                  required 
                  autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 bg-white" 
                    name="remember">
                <span class="ms-2 text-sm text-white font-medium hover:text-gray-200 transition">
                     {{ __('Remember me') }}
                </span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-white hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-center text-sm text-white">
        Belum punya akun? <a href="{{ route('register') }}" class="text-white underline">Daftar sekarang</a>
    </div>
</x-guest-layout>
