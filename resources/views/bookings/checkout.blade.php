<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilaya Resort - Checkout</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <div class="mb-4">
            <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center text-sm font-medium text-[#FF750F] hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Booking Details
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h1 class="text-2xl font-bold text-[#1b1b18]">Checkout</h1>
            </div>
            
            <div class="md:flex">
                <!-- Checkout Form -->
                <div class="md:w-2/3 p-6">
                    <form action="{{ route('bookings.checkout.process', $booking) }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-4">Booking Summary</h2>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Rental Unit</p>
                                        <p class="font-medium">{{ $booking->rentalUnit->address }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Dates</p>
                                        <p class="font-medium">{{ $booking->start_date->format('d M Y') }} - {{ $booking->end_date->format('d M Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4 mt-2">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600">Rp {{ number_format($pricePerNight, 0, ',', '.') }} x {{ $nights }} nights</span>
                                        <span class="font-medium">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2 mt-2">
                                        <div class="flex justify-between font-bold">
                                            <span>Total</span>
                                            <span class="text-[#FF750F]">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-4">Damage Assessment</h2>
                            <p class="text-sm text-gray-500 mb-4">If any items were damaged during the stay, please select them below. The cost will be added to the total amount.</p>
                            
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="space-y-3">
                                    @foreach($checklistItems as $item)
                                    <div class="flex items-center">
                                        <input id="damaged_item_{{ $item->checklist_id }}" name="damaged_items[]" type="checkbox" value="{{ $item->checklist_id }}" class="h-4 w-4 text-[#FF750F] focus:ring-[#FF750F] border-gray-300">
                                        <label for="damaged_item_{{ $item->checklist_id }}" class="ml-3 block text-sm font-medium text-gray-700">
                                            {{ $item->item }} - Rp {{ number_format($item->price, 0, ',', '.') }}
                                            @if($item->description)
                                            <span class="block text-xs text-gray-500">{{ $item->description }}</span>
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-4">Payment Method</h2>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input id="payment_cash" name="payment_method" type="radio" value="cash" class="h-4 w-4 text-[#FF750F] focus:ring-[#FF750F] border-gray-300" checked>
                                    <label for="payment_cash" class="ml-3 block text-sm font-medium text-gray-700">Cash</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="payment_credit_card" name="payment_method" type="radio" value="credit_card" class="h-4 w-4 text-[#FF750F] focus:ring-[#FF750F] border-gray-300">
                                    <label for="payment_credit_card" class="ml-3 block text-sm font-medium text-gray-700">Credit Card</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="payment_bank_transfer" name="payment_method" type="radio" value="bank_transfer" class="h-4 w-4 text-[#FF750F] focus:ring-[#FF750F] border-gray-300">
                                    <label for="payment_bank_transfer" class="ml-3 block text-sm font-medium text-gray-700">Bank Transfer</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="payment_e_wallet" name="payment_method" type="radio" value="e_wallet" class="h-4 w-4 text-[#FF750F] focus:ring-[#FF750F] border-gray-300">
                                    <label for="payment_e_wallet" class="ml-3 block text-sm font-medium text-gray-700">E-Wallet</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-4">Additional Notes</h2>
                            <textarea name="notes" rows="3" class="shadow-sm focus:ring-[#FF750F] focus:border-[#FF750F] block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Any special requests or notes for your checkout"></textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#FF750F] hover:bg-[#e66a0e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF750F]">
                                Complete Checkout
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Checkout Information -->
                <div class="md:w-1/3 bg-gray-50 p-6">
                    <h2 class="text-lg font-semibold mb-4">Checkout Information</h2>
                    
                    <div class="text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-500 mb-4">Please review your booking details before completing checkout</p>
                        <p class="text-sm text-gray-400">By proceeding with checkout, you agree to our terms and conditions</p>
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
        </div>
    </footer>
</body>
</html>