<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Midtrans Payment for Transaction #{{ $transaction->transaction_code }}</h2>
                    
                    <div class="mb-8 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Transaction Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Booking ID:</p>
                                <p class="font-medium">{{ $transaction->booking->booking_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Customer:</p>
                                <p class="font-medium">{{ $transaction->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Amount:</p>
                                <p class="font-medium">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Amount to Pay:</p>
                                <p class="font-medium text-red-600">
                                    Rp {{ number_format($transaction->remaining_balance, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <p class="text-gray-700">Click the button below to proceed with your payment</p>
                        <button id="pay-button" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Pay Now
                        </button>
                        
                        <div class="mt-4">
                            <a href="{{ route('payments.form', $transaction->transaction_id) }}" class="text-indigo-600 hover:text-indigo-800">
                                &larr; Back to payment options
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Midtrans JS -->
    <script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" data-client-key="{{ $client_key }}"></script>
    
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('pay-button');
            const snapToken = '{{ $snap_token }}';
            
            payButton.addEventListener('click', function() {
                // Disable the button to prevent multiple clicks
                payButton.disabled = true;
                payButton.textContent = 'Processing...';
                
                // Open Snap payment popup
                snap.pay(snapToken, {
                    // Success callback
                    onSuccess: function(result) {
                        window.location.href = '{{ route("midtrans.finish") }}?order_id=' + result.order_id + '&transaction_status=' + result.transaction_status;
                    },
                    // Pending callback
                    onPending: function(result) {
                        window.location.href = '{{ route("midtrans.finish") }}?order_id=' + result.order_id + '&transaction_status=' + result.transaction_status;
                    },
                    // Error callback
                    onError: function(result) {
                        window.location.href = '{{ route("midtrans.error") }}?order_id=' + result.order_id;
                    },
                    // Close callback
                    onClose: function() {
                        // Re-enable the button
                        payButton.disabled = false;
                        payButton.textContent = 'Pay Now';
                        
                        // Optionally redirect to unfinish URL
                        window.location.href = '{{ route("midtrans.unfinish") }}?order_id={{ $transaction->transaction_code }}';
                    }
                });
            });
        });
    </script>
</x-app-layout>