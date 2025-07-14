<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilaya Resort - Search Transaction</title>
    
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
                        <a href="{{ route('transactions.lookup') }}" class="text-sm font-medium text-gray-700 hover:text-[#FF750F] mr-4">Search Transaction</a>
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
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h1 class="text-2xl font-bold text-[#1b1b18]">Search Transaction</h1>
            </div>
            
            <div class="p-6">
                <div class="text-center mb-8">
                    <h2 class="text-xl font-semibold mb-2">Enter Transaction Code</h2>
                    <p class="text-gray-600">Enter your transaction code to view and print your transaction details.</p>
                </div>
                
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Error</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('transactions.find') }}" method="POST" class="max-w-md mx-auto">
                    @csrf
                    <div class="mb-6">
                        <label for="transaction_code" class="block text-sm font-medium text-gray-700 mb-1">Transaction Code</label>
                        <input type="text" name="transaction_code" id="transaction_code" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#FF750F] focus:border-[#FF750F]" placeholder="Enter your transaction code" required>
                    </div>
                    
                    <div class="flex justify-center">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#FF750F] hover:bg-[#e66a0e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF750F]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Find Transaction
                        </button>
                    </div>
                </form>
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