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

    <!-- Dynamic Theme Styles -->
    <style>
        :root {
            --color-primary: {{ $theme['colors']['primary'] }};
            --color-secondary: {{ $theme['colors']['secondary'] }};
            --color-bg: {{ $theme['colors']['bg'] }};
            --color-text: {{ $theme['colors']['text'] }};
            --font-family: '{{ $theme['font'] }}', sans-serif;
        }

        body {
            background-color: var(--color-bg);
            color: var(--color-text);
            font-family: var(--font-family);
        }

        .theme-primary { color: var(--color-primary); }
        .theme-bg-primary { background-color: var(--color-primary); }
        .theme-secondary { color: var(--color-secondary); }
        .theme-bg-secondary { background-color: var(--color-secondary); }

        .btn-primary {
            background-color: var(--color-primary);
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.9; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="font-bold text-2xl theme-primary">
                            {{ config('app.name') }}
                        </a>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Home
                        </a>
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Shop
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart') }}" class="text-gray-500 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700">Log in</a>
                        <a href="{{ route('register') }}" class="text-sm text-gray-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow {{ $theme['layout'] === 'boxed' ? 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full' : 'w-full' }}">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">About Us</h3>
                    <p class="text-gray-400 text-sm">We provide the best products for your needs. Trust, Quality, and Service.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Links</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white">Returns</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <p class="text-gray-400 text-sm">support@example.com</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Newsletter</h3>
                    <input type="email" placeholder="Your email" class="w-full p-2 rounded text-gray-900">
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
