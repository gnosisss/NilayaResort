<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center mb-8">
                        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="mt-4 text-2xl font-bold text-gray-800">Payment Submitted Successfully!</h2>
                        <p class="mt-2 text-gray-600">Your payment has been recorded and is being processed.</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg mb-8">
                        <h3 class="text-lg font-semibold mb-4">Payment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Payment Code:</p>
                                <p class="font-medium">{{ $payment->payment_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Transaction Code:</p>
                                <p class="font-medium">{{ $payment->checkoutTransaction->transaction_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Amount:</p>
                                <p class="font-medium">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Method:</p>
                                <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Status:</p>
                                <p class="font-medium">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $payment->payment_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $payment->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    ">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Date:</p>
                                <p class="font-medium">{{ $payment->payment_date->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($payment->payment_status === 'pending')
                            <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                                <p class="font-medium">Your payment is pending verification.</p>
                                <p class="text-sm">We will review your payment and update its status shortly. You will be notified once the payment is confirmed.</p>
                            </div>
                        @elseif($payment->payment_status === 'completed')
                            <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700">
                                <p class="font-medium">Your payment has been confirmed!</p>
                                <p class="text-sm">Thank you for your payment. Your transaction is now complete.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('payments.form', $payment->transaction_id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Back to Payment Page
                        </a>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>