<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Nilaya Resort - Luxury Real Estate Properties in Paradise">

        <title>Nilaya Resort - Luxury Real Estate</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|playfair-display:700" rel="stylesheet" />
        
        <!-- AOS Animation Library -->
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Fallback styles */
                body {
                    font-family: 'Instrument Sans', sans-serif;
                    color: #333;
                    line-height: 1.6;
                    scroll-behavior: smooth;
                }
                .font-serif {
                    font-family: 'Playfair Display', serif;
                }
                /* Smooth transitions */
                a, button {
                    transition: all 0.3s ease;
                }
                .hover-scale {
                    transition: transform 0.3s ease;
                }
                .hover-scale:hover {
                    transform: scale(1.03);
                }
                /* Responsive improvements */
                @media (max-width: 640px) {
                    .container-sm {
                        padding-left: 1rem;
                        padding-right: 1rem;
                    }
                }
            </style>
        @endif
    </head>
    <body class="antialiased bg-white" x-data="{ mobileMenuOpen: false }">
        <!-- Initialize AOS Animation -->        
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                AOS.init({
                    once: false,
                    mirror: true,
                    offset: 50,
                    duration: 800
                });
            });
        </script>
        <!-- Hero Section with Navigation -->
        <header class="relative overflow-hidden bg-cover bg-center h-screen" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
            <div class="absolute inset-0 bg-black/40"></div>
            
            <!-- Navigation -->
            <nav class="relative z-10 px-6 py-6 flex justify-between items-center">
                <div class="flex items-center" data-aos="fade-right" data-aos-duration="1000">
                    <span class="text-white text-3xl font-bold">Nilaya<span class="text-amber-400">Resort</span></span>
                </div>
                <div class="hidden md:flex space-x-10 text-white" data-aos="fade-left" data-aos-duration="1000">
                    <a href="#" class="hover:text-amber-400 transition">Home</a>
                    <a href="{{ route('bookings.index') }}" class="hover:text-amber-400 transition">Rental</a>
                    <a href="{{ route('properties.index') }}" class="hover:text-amber-400 transition">Property</a>
                    <a href="#about" class="hover:text-amber-400 transition">About</a>
                    <a href="#contact" class="hover:text-amber-400 transition">Contact</a>
                </div>
                <div class="hidden md:flex space-x-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/customer') }}" class="text-white hover:text-amber-400 transition">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:text-amber-400 transition">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ url('/customer/login') }}" class="text-white hover:text-amber-400 transition">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ url('/customer/register') }}" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-full font-medium transition hover:scale-105">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white text-xl transition-transform duration-300 ease-in-out" :class="{'rotate-90': mobileMenuOpen}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </nav>
            
            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="relative z-20 md:hidden px-6 py-4 bg-black/80 backdrop-blur-sm rounded-lg shadow-xl mx-6" style="display: none;">
                <div class="flex flex-col space-y-3 py-3">
                    <a href="#" class="text-white hover:text-amber-400 transition py-2">Home</a>
                    <a href="{{ route('bookings.index') }}" class="text-white hover:text-amber-400 transition py-2">Rental</a>
                    <a href="{{ route('properties.index') }}" class="text-white hover:text-amber-400 transition py-2">Property</a>
                    <a href="#about" class="text-white hover:text-amber-400 transition py-2">About</a>
                    <a href="#contact" class="text-white hover:text-amber-400 transition py-2">Contact</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/customer') }}" class="text-white hover:text-amber-400 transition py-2">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline py-2">
                                @csrf
                                <button type="submit" class="text-white hover:text-amber-400 transition">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ url('/customer/login') }}" class="text-white hover:text-amber-400 transition py-2">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ url('/customer/register') }}" class="text-amber-400 hover:text-amber-300 transition py-2">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
            
            <!-- Hero Content -->
            <div class="relative z-10 px-6 flex items-center justify-center h-full text-center">
                <div class="max-w-4xl" data-aos="fade-up" data-aos-duration="1200">
                    <h1 class="text-4xl md:text-6xl font-serif font-bold text-white leading-tight mb-6">Discover Your Dream Luxury Property at Nilaya Resort</h1>
                    <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">Experience the perfect blend of comfort, luxury, and natural beauty with our exclusive collection of premium properties.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('properties.index') }}" class="bg-green-700 hover:bg-green-800 text-white px-8 py-4 rounded-full font-medium text-lg transition hover:scale-105">Explore Properties</a>
                        <a href="{{ route('bookings.index') }}" class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-4 rounded-full font-medium text-lg transition hover:scale-105">Book a Stay</a>
                    </div>
                </div>
            </div>
            
            <!-- Search Bar -->
            
        </header>

        <!-- Featured Properties Section -->
        <section id="properties" class="py-24 mt-24 sm:mt-20 md:mt-16 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-4">Featured Properties</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explore our handpicked selection of premium properties designed for luxury and comfort.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Property Card 1 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg transition duration-500 hover:shadow-xl transform hover:scale-105" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" alt="Luxury Villa" class="w-full h-64 object-cover transition duration-500 hover:scale-110">
                            <div class="absolute top-4 left-4 bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-medium">Featured</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Beachfront Luxury Villa</h3>
                            <p class="text-gray-500 mb-4">Bali, Indonesia</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-green-700 font-bold text-xl">$1,200,000</span>
                                <span class="text-gray-500">350 m²</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600 border-t border-gray-100 pt-4">
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>4 Bedrooms</span>
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>3 Bathrooms</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Property Card 2 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg transition duration-500 hover:shadow-xl transform hover:scale-105" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1475&q=80" alt="Mountain Villa" class="w-full h-64 object-cover transition duration-500 hover:scale-110">
                            <div class="absolute top-4 left-4 bg-green-700 text-white px-3 py-1 rounded-full text-sm font-medium">New</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Mountain View Retreat</h3>
                            <p class="text-gray-500 mb-4">Ubud, Bali</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-green-700 font-bold text-xl">$850,000</span>
                                <span class="text-gray-500">280 m²</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600 border-t border-gray-100 pt-4">
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>3 Bedrooms</span>
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>2 Bathrooms</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Property Card 3 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg transition duration-500 hover:shadow-xl transform hover:scale-105" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Modern House" class="w-full h-64 object-cover transition duration-500 hover:scale-110">
                            <div class="absolute top-4 left-4 bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-medium">Premium</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Lakeside Modern House</h3>
                            <p class="text-gray-500 mb-4">Seminyak, Bali</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-green-700 font-bold text-xl">$1,500,000</span>
                                <span class="text-gray-500">420 m²</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600 border-t border-gray-100 pt-4">
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>5 Bedrooms</span>
                                <span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>4 Bathrooms</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-12" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                    <a href="{{ route('properties.index') }}" class="inline-block border-2 border-green-700 text-green-700 hover:bg-green-700 hover:text-white px-8 py-3 rounded-full font-medium transition hover:scale-105">View All Properties</a>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-24 bg-gray-50 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div data-aos="fade-right" data-aos-duration="1000">
                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-6">About Nilaya Resort</h2>
                        <p class="text-lg text-gray-600 mb-6">Nilaya Resort is a premier real estate development offering luxurious properties in the most sought-after locations across Bali. With a focus on quality, comfort, and sustainability, we create living spaces that harmonize with nature while providing modern amenities.</p>
                        <p class="text-lg text-gray-600 mb-8">Our properties are designed by award-winning architects and built with premium materials to ensure longevity and value appreciation. Whether you're looking for a vacation home, a permanent residence, or an investment opportunity, Nilaya Resort offers properties that exceed expectations.</p>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-white p-6 rounded-xl shadow-md transform transition duration-500 hover:scale-105 hover:shadow-xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                                <div class="text-amber-500 text-3xl font-bold mb-2">15+</div>
                                <div class="text-gray-700">Years of Experience</div>
                            </div>
                            <div class="bg-white p-6 rounded-xl shadow-md transform transition duration-500 hover:scale-105 hover:shadow-xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                                <div class="text-amber-500 text-3xl font-bold mb-2">200+</div>
                                <div class="text-gray-700">Properties Developed</div>
                            </div>
                            <div class="bg-white p-6 rounded-xl shadow-md transform transition duration-500 hover:scale-105 hover:shadow-xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                                <div class="text-amber-500 text-3xl font-bold mb-2">500+</div>
                                <div class="text-gray-700">Happy Clients</div>
                            </div>
                            <div class="bg-white p-6 rounded-xl shadow-md transform transition duration-500 hover:scale-105 hover:shadow-xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                                <div class="text-amber-500 text-3xl font-bold mb-2">20+</div>
                                <div class="text-gray-700">Awards Won</div>
                            </div>
                        </div>
                    </div>
                    <div class="relative" data-aos="fade-left" data-aos-duration="1000">
                        <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1453&q=80" alt="Luxury Property" class="rounded-xl shadow-2xl w-full h-auto transform transition duration-700 hover:scale-105 hover:shadow-2xl">
                        <div class="absolute -bottom-8 -left-8 bg-green-700 text-white p-6 rounded-xl shadow-xl max-w-xs transform transition duration-500 hover:scale-105 hover:bg-green-800" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                            <p class="text-lg font-medium">"Our mission is to create exceptional living spaces where luxury meets sustainability."</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-4">Why Choose Nilaya Resort</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Our properties offer a unique combination of luxury, comfort, and strategic location.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center transform transition duration-500 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 transform transition hover:rotate-12 duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Prime Locations</h3>
                        <p class="text-gray-600">All our properties are situated in strategic locations with stunning views and easy access to amenities.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center transform transition duration-500 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 transform transition hover:rotate-12 duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Security & Privacy</h3>
                        <p class="text-gray-600">24/7 security systems, gated communities, and privacy features for peace of mind.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center transform transition duration-500 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 transform transition hover:rotate-12 duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Modern Amenities</h3>
                        <p class="text-gray-600">Smart home features, energy-efficient systems, and premium fixtures in all our properties.</p>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center transform transition duration-500 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 transform transition hover:rotate-12 duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Investment Value</h3>
                        <p class="text-gray-600">Properties with strong appreciation potential and rental income opportunities.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="py-24 bg-gray-50 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-4">What Our Clients Say</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Hear from our satisfied property owners about their experience with Nilaya Resort.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover-scale transform transition duration-500 hover:shadow-2xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="flex items-center mb-6">
                            <div class="text-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">"Purchasing a villa at Nilaya Resort was the best investment decision I've made. The property quality is exceptional, and the location is perfect. The team was professional and made the process seamless."</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Client" class="w-12 h-12 rounded-full mr-4 transform transition duration-500 hover:scale-110 hover:rotate-3">
                            <div>
                                <h4 class="font-bold text-gray-900">Michael Johnson</h4>
                                <p class="text-gray-500">Villa Owner</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover-scale transform transition duration-500 hover:shadow-2xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="flex items-center mb-6">
                            <div class="text-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">"The attention to detail in our Nilaya Resort property is remarkable. From the architectural design to the finishing touches, everything speaks of quality and luxury. We couldn't be happier with our purchase."</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Client" class="w-12 h-12 rounded-full mr-4 transform transition duration-500 hover:scale-110 hover:rotate-3">
                            <div>
                                <h4 class="font-bold text-gray-900">Sarah Williams</h4>
                                <p class="text-gray-500">Homeowner</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 3 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover-scale transform transition duration-500 hover:shadow-2xl" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="flex items-center mb-6">
                            <div class="text-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">"As an investor, I've purchased multiple properties at Nilaya Resort. The rental yields have been excellent, and the property management services are top-notch. I highly recommend Nilaya for investment purposes."</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Client" class="w-12 h-12 rounded-full mr-4 transform transition duration-500 hover:scale-110 hover:rotate-3">
                            <div>
                                <h4 class="font-bold text-gray-900">David Chen</h4>
                                <p class="text-gray-500">Property Investor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-24 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                    <div data-aos="fade-right" data-aos-duration="1000">
                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-6">Get in Touch</h2>
                        <p class="text-lg text-gray-600 mb-8">Interested in our properties? Fill out the form, and our real estate experts will get back to you within 24 hours.</p>
                        
                        <form class="space-y-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-300 hover:shadow-md">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-300 hover:shadow-md">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-300 hover:shadow-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-300 hover:shadow-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">I'm Interested In</label>
                                <select class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-300 hover:shadow-md">
                                    <option>Buying a Property</option>
                                    <option>Renting a Property</option>
                                    <option>Property Investment</option>
                                    <option>Property Management</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea rows="4" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-300 hover:shadow-md"></textarea>
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white py-3 px-6 rounded-lg font-medium transition duration-300 transform hover:scale-105 hover:shadow-lg">Send Message</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="lg:pl-10" data-aos="fade-left" data-aos-duration="1000">
                        <div class="bg-gray-50 p-8 rounded-xl shadow-lg h-full transform transition duration-500 hover:shadow-2xl">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h3>
                            
                            <div class="space-y-6">
                                <div class="flex items-start" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                                    <div class="bg-green-100 p-3 rounded-full mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1">Office Address</h4>
                                        <p class="text-gray-600">Jl. Sunset Road No. 88, Seminyak, Bali, Indonesia</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                                    <div class="bg-green-100 p-3 rounded-full mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1">Phone Number</h4>
                                        <p class="text-gray-600">+62 361 123 4567</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                                    <div class="bg-green-100 p-3 rounded-full mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1">Email Address</h4>
                                        <p class="text-gray-600">info@nilayaresort.com</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                                    <div class="bg-green-100 p-3 rounded-full mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-1">Office Hours</h4>
                                        <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
                                        <p class="text-gray-600">Saturday: 9:00 AM - 2:00 PM</p>
                                        <p class="text-gray-600">Sunday: Closed</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-10" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                                <h4 class="font-bold text-gray-900 mb-4">Follow Us</h4>
                                <div class="flex space-x-4" data-aos="fade-up" data-aos-duration="600" data-aos-delay="600">
                                    <a href="#" class="bg-green-100 p-3 rounded-full text-green-700 hover:bg-green-700 hover:text-white transition duration-300 transform hover:scale-110 hover:rotate-3 hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0


