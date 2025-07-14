<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nilaya Resort - Properti eksklusif dan villa mewah untuk disewa dan dibeli">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nilaya Resort') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        /* Custom Font Settings */
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #0284c7;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #0369a1;
        }
        
        /* Dropdown Animation */
        .dropdown-menu {
            transform-origin: top;
            animation: dropdownAnimation 0.2s ease-out;
        }
        
        @keyframes dropdownAnimation {
            from {
                opacity: 0;
                transform: scaleY(0.8);
            }
            to {
                opacity: 1;
                transform: scaleY(1);
            }
        }
        
        /* Active Navigation Link */
        .nav-link.active {
            color: #0284c7;
            font-weight: 500;
            position: relative;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #0284c7;
            border-radius: 2px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Header/Navigation -->
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center">
                            <span class="text-primary-600 text-2xl font-bold">{{ config('app.name', 'Nilaya Resort') }}</span>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('bookings.index') }}" class="nav-link px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs('bookings.index') ? 'active' : '' }}">
                            {{ __('Bookings') }}
                        </a>
                        <a href="{{ route('properties.index') }}" class="nav-link px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs('properties.index') ? 'active' : '' }}">
                            {{ __('Properties') }}
                        </a>
                    </div>
                    
                    <!-- Right Side Navigation -->
                    <div class="hidden md:flex items-center space-x-4">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors duration-200">
                                    {{ __('Login') }}
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors duration-200">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @else
                            <a href="{{ route('bookings.my-bookings') }}" class="nav-link px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs('bookings.my-bookings') ? 'active' : '' }}">
                                {{ __('My Bookings') }}
                            </a>
                            
                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 focus:outline-none transition-colors duration-200">
                                    <span class="mr-1">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="open" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Profile') }}
                                    </a>
                                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 focus:outline-none transition-colors duration-200" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="{{ route('bookings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs('bookings.index') ? 'text-primary-600' : 'text-gray-700' }}">
                            {{ __('Bookings') }}
                        </a>
                        <a href="{{ route('properties.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs('properties.index') ? 'text-primary-600' : 'text-gray-700' }}">
                            {{ __('Properties') }}
                        </a>
                        
                        @auth
                        <a href="{{ route('bookings.my-bookings') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 transition-colors duration-200 {{ request()->routeIs('bookings.my-bookings') ? 'text-primary-600' : 'text-gray-700' }}">
                            {{ __('My Bookings') }}
                        </a>
                        <div class="border-t border-gray-200 my-2"></div>
                        <div class="px-3 py-2 text-base font-medium text-gray-700">
                            {{ Auth::user()->name }}
                        </div>
                        <a href="{{ route('logout') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                           onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        @else
                        <div class="border-t border-gray-200 my-2"></div>
                        <div class="flex flex-col space-y-2 px-3 py-2">
                            @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="w-full px-4 py-2 text-center text-sm font-medium text-primary-600 border border-primary-600 rounded-lg hover:bg-primary-50 transition-colors duration-200">
                                {{ __('Login') }}
                            </a>
                            @endif
                            
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full px-4 py-2 text-center text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                {{ __('Register') }}
                            </a>
                            @endif
                        </div>
                        @endauth
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Brand Info -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">{{ config('app.name', 'Nilaya Resort') }}</h3>
                        <p class="text-gray-600 mb-4">Properti eksklusif dan villa mewah untuk disewa dan dibeli di lokasi strategis.</p>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ url('/') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">Home</a></li>
                            <li><a href="{{ route('properties.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">Properties</a></li>
                            <li><a href="{{ route('bookings.index') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">Bookings</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Contact Us</h3>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <i class='bx bx-map text-primary-600 mr-2 text-lg'></i>
                                <span class="text-gray-600">Jl. Paradise Resort No. 123, Bali, Indonesia</span>
                            </li>
                            <li class="flex items-center">
                                <i class='bx bx-phone text-primary-600 mr-2 text-lg'></i>
                                <span class="text-gray-600">+62 123 4567 890</span>
                            </li>
                            <li class="flex items-center">
                                <i class='bx bx-envelope text-primary-600 mr-2 text-lg'></i>
                                <span class="text-gray-600">info@nilayaresort.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Copyright -->
                <div class="border-t border-gray-200 mt-8 pt-6 text-center">
                    <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'Nilaya Resort') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Alpine.js for Dropdowns -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const openIcon = mobileMenuButton.querySelector('.block');
            const closeIcon = mobileMenuButton.querySelector('.hidden');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                openIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>