<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilaya Resort - Book Your Stay</title>
    
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
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-[#FF750F] flex items-center">
                            Nilaya Resort <span class="text-[#FF750F] ml-1">✦</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ route('bookings.my-bookings') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] transition duration-300 ease-in-out">My Bookings</a>
                        <a href="{{ route('bookings.calendar') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] transition duration-300 ease-in-out">Booking Calendar</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] transition duration-300 ease-in-out">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] transition duration-300 ease-in-out">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] transition duration-300 ease-in-out">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-6">
            <a href="{{ route('bookings.index') }}" class="inline-flex items-center text-sm font-medium text-[#FF750F] hover:text-[#e66a0e] transition duration-300 ease-in-out group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Available Units
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-lg">
            <div class="md:flex">
                <!-- Unit Details -->
                <div class="md:w-1/2 p-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ $rentalUnit->address }}
                    </h1>
                    
                    <div class="flex items-center text-gray-600 mb-6 bg-gray-50 rounded-lg p-3 border-l-4 border-[#FF750F]">
                        <span class="mr-3 font-medium">{{ $rentalUnit->type }}</span>
                        <span class="mx-2 text-gray-400">•</span>
                        <span class="bg-[#FF750F] text-white px-2 py-1 rounded-md text-xs font-medium">{{ $rentalUnit->category->name }}</span>
                    </div>
                    
                    <div class="mb-8 bg-orange-50 p-4 rounded-lg border border-orange-100">
                        <h2 class="text-lg font-semibold mb-2 flex items-center text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Price
                        </h2>
                        <p class="text-[#FF750F] font-bold text-2xl">Rp {{ number_format($rentalUnit->price_per_night, 0, ',', '.') }} <span class="text-sm font-normal text-gray-600">/ night</span></p>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-3 flex items-center text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Facilities
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($rentalUnit->facilities as $facility)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-50 text-[#FF750F] border border-orange-100">
                                    {{ $facility->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-3 flex items-center text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Images
                        </h2>
                        <div class="grid grid-cols-2 gap-3">
                            @forelse($rentalUnit->images as $image)
                                <div class="rounded-lg overflow-hidden h-36 shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $rentalUnit->address }}" class="w-full h-full object-cover">
                                </div>
                            @empty
                                <div class="col-span-2 bg-gray-100 rounded-lg h-36 flex items-center justify-center">
                                    <span class="text-gray-400 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        No images available
                                    </span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Booking Form -->
                <div class="md:w-1/2 bg-gray-50 p-8 border-l border-gray-100">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Book Your Stay
                    </h2>
                    
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6 border border-red-100">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">Please correct the following errors:</span>
                            </div>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @guest
                        <div class="bg-yellow-50 text-yellow-700 p-5 rounded-lg mb-6 border border-yellow-100 flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 mt-0.5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Please <a href="{{ route('login') }}" class="font-medium text-[#FF750F] hover:underline">login</a> or <a href="{{ route('register') }}" class="font-medium text-[#FF750F] hover:underline">register</a> to book your stay.</p>
                        </div>
                    @else
                        <form action="{{ route('bookings.store') }}" method="POST" x-data="{ startDate: '', endDate: '', totalNights: 0, totalPrice: 0 }" x-init="flatpickr($refs.datepicker, {
                            mode: 'range',
                            dateFormat: 'Y-m-d',
                            minDate: 'today',
                            enable: {{ json_encode($availableDates) }},
                            onClose: function(selectedDates) {
                                if(selectedDates.length === 2) {
                                    startDate = selectedDates[0].toISOString().split('T')[0];
                                    endDate = selectedDates[1].toISOString().split('T')[0];
                                    
                                    // Calculate total nights
                                    const start = new Date(startDate);
                                    const end = new Date(endDate);
                                    const diffTime = Math.abs(end - start);
                                    totalNights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                                    
                                    // Calculate total price
                                    totalPrice = totalNights * {{ $rentalUnit->price_per_night }};
                                }
                            }
                        })">
                            @csrf
                            <input type="hidden" name="unit_id" value="{{ $rentalUnit->unit_id }}">
                            
                            <div class="mb-6">
                                <label for="date_range" class="block text-sm font-medium text-gray-700 mb-2">Select Dates</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="date_range" 
                                        placeholder="Select check-in and check-out dates" 
                                        class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-[#FF750F] focus:ring focus:ring-[#FF750F] focus:ring-opacity-50"
                                        x-ref="datepicker"
                                        readonly
                                    >
                                </div>
                                <input type="hidden" name="start_date" x-model="startDate">
                                <input type="hidden" name="end_date" x-model="endDate">
                                <p class="text-sm text-gray-500 mt-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Only available dates are selectable
                                </p>
                            </div>
                            
                            <div class="bg-white p-5 rounded-lg mb-6 shadow-sm border border-gray-100" x-show="totalNights > 0" x-transition>
                                <h3 class="text-lg font-semibold mb-3 text-gray-800">Booking Summary</h3>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Rp {{ number_format($rentalUnit->price_per_night, 0, ',', '.') }} x <span x-text="totalNights"></span> nights</span>
                                    <span class="font-medium">Rp <span x-text="totalPrice.toLocaleString('id-ID')"></span></span>
                                </div>
                                <div class="border-t border-gray-200 pt-3 mt-3">
                                    <div class="flex justify-between font-bold">
                                        <span>Total</span>
                                        <span class="text-[#FF750F] text-xl">Rp <span x-text="totalPrice.toLocaleString('id-ID')"></span></span>
                                    </div>
                                </div>
                            </div>
                            
                            <button 
                                type="submit" 
                                class="w-full bg-[#FF750F] text-white py-3 px-4 rounded-lg hover:bg-[#e66a0e] focus:outline-none focus:ring-2 focus:ring-[#FF750F] focus:ring-opacity-50 transition duration-300 ease-in-out transform hover:scale-[1.02] font-medium flex items-center justify-center"
                                x-bind:disabled="!startDate || !endDate"
                                x-bind:class="{ 'opacity-50 cursor-not-allowed': !startDate || !endDate }"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Book Now
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-[#1b1b18] text-white py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h2 class="text-xl font-bold mb-4 flex items-center">
                        <span class="text-[#FF750F] mr-2">✦</span> Nilaya Resort
                    </h2>
                    <p class="text-gray-400 mb-4">Your perfect getaway destination in the heart of paradise. Experience luxury, comfort, and unforgettable memories.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider mb-4 text-gray-300">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><svg class="h-3 w-3 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg> Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><svg class="h-3 w-3 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg> About Us</a></li>
                        <li><a href="{{ route('properties.index') }}" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><svg class="h-3 w-3 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg> Rental Units</a></li>
                        <li><a href="{{ route('bookings.index') }}" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><svg class="h-3 w-3 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg> Bookings</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300 flex items-center"><svg class="h-3 w-3 mr-2 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg> Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider mb-4 text-gray-300">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-[#FF750F] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-400">Jl. Paradise Island No. 123<br>Bali, Indonesia 80361</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-400">info@nilayaresort.com</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-[#FF750F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-400">+62 123 4567 890</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Nilaya Resort. All rights reserved.</p>
                <div class="mt-4 md:mt-0 flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300 text-sm">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300 text-sm">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-[#FF750F] transition duration-300 text-sm">FAQ</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>