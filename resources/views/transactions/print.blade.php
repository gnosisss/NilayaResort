<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nilaya Resort - Transaction Receipt</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #1b1b18;
        }
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .receipt-header {
            background-color: #FF750F;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .receipt-body {
            padding: 20px;
        }
        .receipt-section {
            margin-bottom: 20px;
        }
        .receipt-section h3 {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-top: 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-item {
            margin-bottom: 15px;
        }
        .info-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        .info-value {
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #f9fafb;
            text-align: left;
            padding: 12px;
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f9fafb;
        }
        .text-right {
            text-align: right;
        }
        .total-amount {
            color: #FF750F;
            font-size: 18px;
        }
        .notes {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 6px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #6b7280;
        }
        .damage-item {
            background-color: #fee2e2;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt {
                border: none;
                max-width: 100%;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="no-print bg-[#FF750F] text-white p-4 fixed top-0 left-0 right-0 z-10 flex justify-between items-center">
        <h1 class="text-xl font-bold">Transaction Receipt</h1>
        <div>
            <button onclick="window.print()" class="bg-white text-[#FF750F] px-4 py-2 rounded-md font-medium hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print
            </button>
            <button onclick="window.close()" class="bg-white text-[#FF750F] px-4 py-2 rounded-md font-medium hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white ml-2">
                Close
            </button>
        </div>
    </div>
    
    <div class="pt-20 pb-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="print-container bg-white max-w-4xl mx-auto rounded-lg shadow-sm overflow-hidden">
            <div class="p-8">
                <!-- Header -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-[#FF750F]">Nilaya Resort</h1>
                        <p class="text-gray-600">Experience luxury and comfort</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-semibold">RECEIPT</h2>
                        <p class="text-gray-600">{{ $transaction->checkout_date->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                
                <!-- Transaction Info -->
                <div class="border-t border-b border-gray-200 py-4 mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Transaction Code:</p>
                            <p class="font-medium">{{ $transaction->transaction_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Payment Status:</p>
                            <p class="font-medium">{{ ucfirst($transaction->payment_status) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Payment Method:</p>
                            <p class="font-medium capitalize">{{ $transaction->payment_method }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Booking ID:</p>
                            <p class="font-medium">{{ $transaction->booking->booking_id }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Info -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Customer Information</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p><span class="font-medium">Name:</span> {{ $transaction->booking->user->name }}</p>
                        <p><span class="font-medium">Email:</span> {{ $transaction->booking->user->email }}</p>
                    </div>
                </div>
                
                <!-- Booking Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Booking Information</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p><span class="font-medium">Rental Unit:</span> {{ $transaction->booking->rentalUnit->address }}</p>
                        <p><span class="font-medium">Check-in:</span> {{ $transaction->booking->start_date->format('d M Y') }}</p>
                        <p><span class="font-medium">Check-out:</span> {{ $transaction->booking->end_date->format('d M Y') }}</p>
                        <p><span class="font-medium">Duration:</span> {{ $transaction->booking->start_date->diffInDays($transaction->booking->end_date) }} nights</p>
                    </div>
                </div>
                
                <!-- Transaction Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Transaction Details</h3>
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
                                @php $hasDamageItems = false; @endphp
                                @foreach($transaction->transactionDetails as $detail)
                                    @php 
                                        $isDamageItem = $detail->checklist_id !== null;
                                        if ($isDamageItem) $hasDamageItems = true;
                                    @endphp
                                    <tr class="{{ $isDamageItem ? 'damage-item' : '' }}">
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
                
                @if($transaction->notes)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Notes</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700">{{ $transaction->notes }}</p>
                        </div>
                    </div>
                @endif
                
                <!-- Footer -->
                <div class="border-t border-gray-200 pt-6 mt-8 text-center">
                    <p class="text-gray-600 mb-2">Thank you for choosing Nilaya Resort!</p>
                    <p class="text-sm text-gray-500">This is a computer-generated receipt and does not require a signature.</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-print when the page loads
        window.onload = function() {
            // Delay printing to ensure the page is fully loaded
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</body>
</html>