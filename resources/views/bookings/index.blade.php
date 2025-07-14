<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilaya Resort - Available Units</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-[#FDFDFC] to-[#F8F8F6] text-[#1b1b18] min-h-screen flex flex-col">
    <header class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-[#FF750F] hover:text-[#e66a0e] transition-colors duration-300 flex items-center">
                            <span class="mr-2">✦</span>Nilaya Resort
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-1 sm:space-x-4">
                    @auth
                        <a href="{{ route('bookings.my-bookings') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] hover:bg-orange-50 px-3 py-2 rounded-md transition-all duration-300">My Bookings</a>
                        <a href="{{ route('bookings.calendar') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] hover:bg-orange-50 px-3 py-2 rounded-md transition-all duration-300">Booking Calendar</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] hover:bg-orange-50 px-3 py-2 rounded-md transition-all duration-300">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] hover:bg-orange-50 px-3 py-2 rounded-md transition-all duration-300">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-[#FF750F] text-white hover:bg-[#e66a0e] px-4 py-2 rounded-md transition-all duration-300">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow">
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-3xl sm:text-4xl font-bold text-[#1b1b18] relative inline-block">
                Available Rental Units
                <span class="absolute bottom-0 left-0 w-full h-1 bg-[#FF750F] opacity-70 rounded"></span>
            </h1>
            <p class="mt-3 text-gray-600 text-lg">Find your perfect stay at Nilaya Resort</p>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-10 border border-gray-100 transform transition-all duration-300 hover:shadow-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter Your Search
            </h2>
            <form action="{{ route('bookings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <div class="relative">
                        <select id="category_id" name="category_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#FF750F] focus:ring focus:ring-[#FF750F] focus:ring-opacity-50 pl-3 pr-10 py-2 appearance-none">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="price_range" class="block text-sm font-medium text-gray-700">Price Range</label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" id="price_min" name="price_min" placeholder="Min" value="{{ request('price_min') }}" class="pl-10 w-full rounded-lg border-gray-300 focus:border-[#FF750F] focus:ring focus:ring-[#FF750F] focus:ring-opacity-50">
                        </div>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" id="price_max" name="price_max" placeholder="Max" value="{{ request('price_max') }}" class="pl-10 w-full rounded-lg border-gray-300 focus:border-[#FF750F] focus:ring focus:ring-[#FF750F] focus:ring-opacity-50">
                        </div>
                    </div>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-[#FF750F] text-white py-3 px-4 rounded-lg hover:bg-[#e66a0e] focus:outline-none focus:ring-2 focus:ring-[#FF750F] focus:ring-opacity-50 transition duration-300 ease-in-out transform hover:scale-[1.02] flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Rental Units Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($rentalUnits as $unit)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl hover:transform hover:scale-[1.02] group">
                    <div class="relative overflow-hidden h-56">
                        @if($unit->images->count() > 0)
                            <img src="{{ asset('storage/' . $unit->images->first()->image_path) }}" alt="{{ $unit->address }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No image available</span>
                            </div>
                        @endif
                        <div class="absolute top-0 right-0 bg-[#FF750F] text-white px-3 py-1 m-3 rounded-lg shadow-md">
                            <span class="font-medium">{{ $unit->category->name }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800">{{ $unit->address }}</h2>
                        <div class="flex items-center text-sm text-gray-600 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="mr-3">{{ $unit->type }}</span>
                        </div>
                        <div class="text-[#FF750F] font-bold text-xl mb-4">Rp {{ number_format($unit->price_per_night, 0, ',', '.') }} <span class="text-sm font-normal text-gray-600">/ night</span></div>
                        
                        <!-- Facilities -->
                        <div class="mb-5">
                            <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Facilities:
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($unit->facilities as $facility)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-50 text-[#FF750F] border border-orange-100">
                                        {{ $facility->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        
                        <a href="{{ route('bookings.create', $unit->unit_id) }}" class="block w-full text-center bg-[#FF750F] text-white py-3 px-4 rounded-lg hover:bg-[#e66a0e] focus:outline-none focus:ring-2 focus:ring-[#FF750F] focus:ring-opacity-50 transition duration-300 ease-in-out font-medium">
                            Book Now
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white p-8 rounded-xl shadow-md text-center border border-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-600 text-lg">No rental units available with the selected filters.</p>
                    <p class="text-gray-500 mt-2">Try adjusting your search criteria.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            <div class="pagination-container">
                {{ $rentalUnits->links() }}
            </div>
            
            <style>
                /* Custom Pagination Styles */
                .pagination-container nav div:first-child { display: none; } /* Hide the pagination text */
                .pagination-container nav div:last-child span, 
                .pagination-container nav div:last-child a {
                    @apply inline-flex items-center justify-center w-10 h-10 mx-1 rounded-full border border-gray-200 bg-white text-gray-700 transition-colors duration-300;
                }
                .pagination-container nav div:last-child span.cursor-default {
                    @apply bg-[#FF750F] text-white border-[#FF750F] font-medium;
                }
                .pagination-container nav div:last-child a:hover {
                    @apply bg-orange-50 border-orange-100 text-[#FF750F];
                }
                .pagination-container nav div:last-child span:not(.cursor-default):hover {
                    @apply bg-gray-50;
                }
            </style>
        </div>
    </main>

    <footer class="bg-[#1b1b18] text-white py-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start gap-10">
                <div class="mb-6 md:mb-0 max-w-md">
                    <div class="flex items-center mb-4">
                        <h3 class="text-2xl font-bold">Nilaya Resort</h3>
                        <span class="text-[#FF750F] ml-2 text-xl">✦</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Experience luxury and comfort in our carefully curated rental units. Perfect for your next getaway in a serene and rejuvenating environment.</p>
                    <div class="mt-6 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-10 md:gap-20">
                    <div>
                        <h4 class="text-lg font-semibold mb-5 relative inline-block">
                            Quick Links
                            <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-[#FF750F]"></span>
                        </h4>
                        <ul class="space-y-3">
                            <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><span class="mr-2">→</span> Home</a></li>
                            <li><a href="{{ route('bookings.index') }}" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><span class="mr-2">→</span> Rental Units</a></li>
                            <li><a href="{{ route('bookings.my-bookings') }}" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><span class="mr-2">→</span> My Bookings</a></li>
                            <li><a href="{{ route('bookings.calendar') }}" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><span class="mr-2">→</span> Booking Calendar</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold mb-5 relative inline-block">
                            Contact Us
                            <span class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-[#FF750F]"></span>
                        </h4>
                        <ul class="space-y-3">
                            <li class="text-gray-400 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#FF750F] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Jl. Paradise Resort No. 123<br>Bali, Indonesia</span>
                            </li>
                            <li class="text-gray-400 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>info@nilayaresort.com</span>
                            </li>
                            <li class="text-gray-400 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>+62 123 4567 890</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-10 pt-8 text-center">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Nilaya Resort. All rights reserved.</p>
                <p class="text-gray-600 text-xs mt-2">Designed with <span class="text-[#FF750F]">♥</span> for luxury and comfort</p>
            </div>
        </div>
    </footer>
</body>
</html>