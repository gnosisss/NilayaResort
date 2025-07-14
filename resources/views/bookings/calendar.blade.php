<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilaya Resort - Booking Calendar</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Flatpickr for Calendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18]">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-[#FF750F]">Nilaya Resort</a>
                    </div>
                </div>
                <div class="flex items-center">
                    @auth
                        <a href="{{ route('bookings.my-bookings') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] mr-4">My Bookings</a>
                        <a href="{{ route('bookings.calendar') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] mr-4">Booking Calendar</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-700 hover:text-[#FF750F]">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] mr-4">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F]">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#1b1b18]">Booking Calendar</h1>
            <p class="mt-2 text-gray-600">View all booked dates for our rental units</p>
        </div>

        <!-- Unit Selection -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
            <form action="{{ route('bookings.calendar') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="unit_id" class="block text-sm font-medium text-gray-700 mb-1">Select Rental Unit</label>
                    <select id="unit_id" name="unit_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#FF750F] focus:ring focus:ring-[#FF750F] focus:ring-opacity-50" onchange="this.form.submit()">
                        <option value="">All Units</option>
                        @foreach($rentalUnits as $unit)
                            <option value="{{ $unit->unit_id }}" {{ request('unit_id') == $unit->unit_id ? 'selected' : '' }}>
                                {{ $unit->address }} ({{ $unit->type }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Select Month</label>
                    <input type="month" id="month" name="month" value="{{ request('month', date('Y-m')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#FF750F] focus:ring focus:ring-[#FF750F] focus:ring-opacity-50" onchange="this.form.submit()">
                </div>
            </form>
        </div>

        <!-- Calendar View -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div x-data="{ 
                bookings: {{ json_encode($bookings) }},
                availabilities: {{ json_encode($availabilities) }},
                selectedDate: null,
                selectedBookings: [],
                
                isDateBooked(date) {
                    const dateStr = date.toISOString().split('T')[0];
                    return this.bookings.some(booking => {
                        const start = new Date(booking.start_date);
                        const end = new Date(booking.end_date);
                        return date >= start && date <= end;
                    });
                },
                
                isDateAvailable(date) {
                    const dateStr = date.toISOString().split('T')[0];
                    return this.availabilities.some(avail => {
                        const start = new Date(avail.start_date);
                        const end = new Date(avail.end_date);
                        return date >= start && date <= end && avail.is_available;
                    });
                },
                
                getBookingsForDate(date) {
                    const dateStr = date.toISOString().split('T')[0];
                    return this.bookings.filter(booking => {
                        const start = new Date(booking.start_date);
                        const end = new Date(booking.end_date);
                        return date >= start && date <= end;
                    });
                },
                
                selectDate(date) {
                    this.selectedDate = date;
                    this.selectedBookings = this.getBookingsForDate(date);
                }
            }" x-init="
                flatpickr($refs.calendar, {
                    inline: true,
                    mode: 'single',
                    dateFormat: 'Y-m-d',
                    defaultDate: '{{ request('month', date('Y-m')) }}-01',
                    onDayCreate: function(dObj, dStr, fp, dayElem) {
                        const date = new Date(dayElem.dateObj);
                        if ($data.isDateBooked(date)) {
                            dayElem.classList.add('booked-date');
                        } else if ($data.isDateAvailable(date)) {
                            dayElem.classList.add('available-date');
                        }
                    },
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length > 0) {
                            $data.selectDate(selectedDates[0]);
                        }
                    }
                });
            ">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Calendar -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold mb-4">Booking Calendar</h2>
                        <div x-ref="calendar" class="booking-calendar"></div>
                        <div class="mt-4 flex items-center justify-center space-x-6">
                            <div class="flex items-center">
                                <span class="inline-block w-4 h-4 bg-red-200 rounded-full mr-2"></span>
                                <span class="text-sm text-gray-600">Booked</span>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-block w-4 h-4 bg-green-200 rounded-full mr-2"></span>
                                <span class="text-sm text-gray-600">Available</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Details -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4">Booking Details</h2>
                        <template x-if="selectedDate">
                            <div>
                                <p class="text-lg font-medium mb-2" x-text="'Selected Date: ' + selectedDate.toLocaleDateString()"></p>
                                
                                <template x-if="selectedBookings.length > 0">
                                    <div>
                                        <p class="font-medium text-gray-700 mb-2">Bookings on this date:</p>
                                        <div class="space-y-3">
                                            <template x-for="booking in selectedBookings" :key="booking.booking_id">
                                                <div class="bg-white p-3 rounded-md shadow-sm">
                                                    <p class="font-medium" x-text="booking.rental_unit.address"></p>
                                                    <p class="text-sm text-gray-600" x-text="'Booked by: ' + booking.user.name"></p>
                                                    <p class="text-sm text-gray-600">
                                                        <span x-text="'Check-in: ' + new Date(booking.start_date).toLocaleDateString()"></span><br>
                                                        <span x-text="'Check-out: ' + new Date(booking.end_date).toLocaleDateString()"></span>
                                                    </p>
                                                    <p class="text-sm mt-1">
                                                        <span x-text="'Status: '"></span>
                                                        <span 
                                                            x-text="booking.status"
                                                            :class="{
                                                                'text-green-600': booking.status === 'confirmed',
                                                                'text-yellow-600': booking.status === 'pending',
                                                                'text-red-600': booking.status === 'cancelled'
                                                            }"
                                                        ></span>
                                                    </p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                                
                                <template x-if="selectedBookings.length === 0">
                                    <p class="text-gray-600">No bookings for this date.</p>
                                </template>
                            </div>
                        </template>
                        
                        <template x-if="!selectedDate">
                            <p class="text-gray-600">Select a date to view booking details.</p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center md:order-2">
                    <p class="text-center text-sm text-gray-500">&copy; {{ date('Y') }} Nilaya Resort. All rights reserved.</p>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-sm text-gray-500">Experience luxury and comfort at Nilaya Resort</p>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-8">
                <h3 class="text-sm font-semibold text-gray-600 tracking-wider uppercase">Quick Links</h3>
                <div class="mt-4 grid grid-cols-2 gap-8 sm:grid-cols-3 md:grid-cols-5">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Navigation</h4>
                        <ul class="mt-4 space-y-2">
                            <li><a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-[#FF750F]">Home</a></li>
                            <li><a href="{{ route('properties.index') }}" class="text-sm text-gray-600 hover:text-[#FF750F]">Rental Units</a></li>
                            <li><a href="{{ route('bookings.index') }}" class="text-sm text-gray-600 hover:text-[#FF750F]">Bookings</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-[#FF750F]">About Us</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-[#FF750F]">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <style>
        .flatpickr-calendar {
            width: 100% !important;
            max-width: 100% !important;
        }
        .flatpickr-day {
            max-width: none !important;
            height: 50px !important;
        }
        .booked-date {
            background-color: rgba(239, 68, 68, 0.2) !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
        }
        .available-date {
            background-color: rgba(16, 185, 129, 0.2) !important;
            border-color: rgba(16, 185, 129, 0.3) !important;
        }
    </style>
</body>
</html>