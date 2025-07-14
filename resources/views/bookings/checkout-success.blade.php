<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilaya Resort - Checkout Success</title>
    
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
            <a href="{{ route('bookings.my-bookings') }}" class="inline-flex items-center text-sm font-medium text-[#FF750F] hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Bookings
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h1 class="text-2xl font-bold text-[#1b1b18]">Checkout Successful</h1>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-center mb-6">
                    <div class="bg-green-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                
                <div class="text-center mb-8">
                    <h2 class="text-xl font-semibold mb-2">Thank You for Your Booking!</h2>
                    <p class="text-gray-600">Your transaction has been successfully processed.</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Transaction Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Transaction Code</p>
                                <p class="font-medium">{{ $transaction->transaction_code }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Checkout Date</p>
                                <p class="font-medium">{{ $transaction->checkout_date->format('d M Y, H:i') }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Payment Method</p>
                                <p class="font-medium capitalize">{{ $transaction->payment_method }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Payment Status</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Rental Unit</p>
                                <p class="font-medium">{{ $transaction->booking->rentalUnit->address }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-1">Booking Dates</p>
                                <p class="font-medium">{{ $transaction->booking->start_date->format('d M Y') }} - {{ $transaction->booking->end_date->format('d M Y') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                                <p class="font-bold text-lg text-[#FF750F]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Transaction Details</h3>
                    
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nights</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price Per Night</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transaction->transactionDetails as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->nights }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($detail->price_per_night, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Total:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-[#FF750F]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                @if($transaction->payment_status == 'pending')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Payment Pending</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Please complete your payment using the selected payment method. Your booking will be confirmed once payment is received.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if($transaction->notes)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Notes</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $transaction->notes }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <div class="flex justify-center">
                        <a href="{{ route('bookings.my-bookings') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#FF750F] hover:bg-[#e66a0e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF750F]">
                            View My Bookings
                        </a>
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