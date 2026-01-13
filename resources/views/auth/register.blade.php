<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-semibold">Buat Akun Mitus</h2>
        <p class="text-sm text-white/70">Daftar untuk mulai belanja dan menyimpan wishlist</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
    @csrf

    <div>
        <x-input-label for="name" :value="__('Name')" class="text-white" />
        <x-text-input id="name" class="block mt-1 w-full text-slate-900" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" class="text-white" />
        <x-text-input id="email" class="block mt-1 w-full text-slate-900" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" class="text-white" />
        <x-text-input id="password" class="block mt-1 w-full text-slate-900"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
        <x-text-input id="password_confirmation" class="block mt-1 w-full text-slate-900"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-white hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>

        <x-primary-button class="ms-4">
            {{ __('Register') }}
        </x-primary-button>
    </div>
</form>
</x-guest-layout>
