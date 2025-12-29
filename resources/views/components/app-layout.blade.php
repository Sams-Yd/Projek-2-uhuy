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
        <!-- Google Fonts (Poppins) for a more modern, professional look -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            /* Subtle site-wide animations */
            @keyframes floaty { 0% { transform: translateY(0); } 50% { transform: translateY(-8px); } 100% { transform: translateY(0); } }
            @keyframes blob { 0% { transform: translate(0,0) scale(1); } 33% { transform: translate(8px,-6px) scale(1.03); } 66% { transform: translate(-6px,6px) scale(0.98); } 100% { transform: translate(0,0) scale(1); } }
            @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }

            .floaty { animation: floaty 6s ease-in-out infinite; }
            .animate-blob { animation: blob 8s ease-in-out infinite; filter: blur(8px); opacity: 0.65; }
            .shimmer {
                background: linear-gradient(90deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.14) 50%, rgba(255,255,255,0.06) 100%);
                background-size: 200% 100%;
                animation: shimmer 2.5s linear infinite;
            }

            .btn-ghost { transition: transform .18s ease, box-shadow .18s ease; }
            .btn-ghost:hover { transform: translateY(-4px) scale(1.02); box-shadow: 0 10px 20px rgba(2,6,23,0.12); }

            /* Small attention pulse for badges */
            @keyframes pulse-soft { 0% { transform: scale(1); opacity: 1 } 50% { transform: scale(1.06); opacity: .9 } 100% { transform: scale(1); opacity: 1 } }
            .pulse-soft { animation: pulse-soft 3s ease-in-out infinite; }
            /* Use Poppins as a friendly, professional UI font where available */
            body { font-family: 'Poppins', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }

            /* Small-screen adjustments */
            @media (max-width: 640px) {
                .hero-title { font-size: 1.8rem; }
                .btn-smooth { padding: .5rem .9rem; }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
