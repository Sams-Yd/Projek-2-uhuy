<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
</body>
    <body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-purple-800 to-blue-700 text-white min-h-screen">
        <div class="relative min-h-screen flex items-center justify-center px-4 py-12">
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_center,_rgba(255,255,255,0.06),_transparent)]"></div>

            <div class="max-w-md w-full space-y-6 relative z-10">
                <div class="text-center">
                    <a href="/" class="inline-flex items-center gap-3">
                        <div class="bg-white/10 p-3 rounded-md">
                            <span class="text-2xl">📚</span>
                        </div>
                        <div class="text-left">
                            <div class="font-bold text-xl">Mitus Stationery</div>
                            <div class="text-sm text-white/70">Alat tulis modern</div>
                        </div>
                    </a>
                </div>

                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl shadow-lg p-6">
                    {{ $slot }}
                </div>

                <p class="text-center text-sm text-white/60">© {{ date('Y') }} Mitus Stationery — Semua hak dilindungi.</p>
            </div>
        </div>
    </body>
</html>
