<x-filament-panels::page>
    <div class="p-4 bg-white rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-teal-600">Customer Dashboard</h1>
            <a href="{{ url('/') }}" class="bg-amber-500 hover:bg-amber-600 text-black px-2.5 py-2.5 rounded-full font-bold transition duration-300 transform hover:scale-105 flex items-center shadow-lg hover:shadow-xl border-2 border-amber-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                <span class="text-lg">Kembali ke Beranda</span>
            </a>
        </div>
        <p class="mb-4">Welcome to your Nilaya Resort Dashboard. From here, you can manage your bookings and payments.</p>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="p-4 bg-teal-50 rounded-lg border border-teal-200 flex flex-col items-center justify-center">
                <div class="text-3xl font-bold text-teal-700 mb-2">{{ \App\Models\Booking::where('user_id', auth()->id())->count() }}</div>
                <p class="text-gray-600 text-center">Total Bookings</p>
            </div>
            
            <div class="p-4 bg-teal-50 rounded-lg border border-teal-200 flex flex-col items-center justify-center">
                <div class="text-3xl font-bold text-amber-600 mb-2">{{ \App\Models\Booking::where('user_id', auth()->id())->where('status', 'confirmed')->count() }}</div>
                <p class="text-gray-600 text-center">Active Bookings</p>
            </div>
            
            <div class="p-4 bg-teal-50 rounded-lg border border-teal-200 flex flex-col items-center justify-center">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ \App\Models\PaymentTransaction::where('user_id', auth()->id())->where('payment_status', 'completed')->count() }}</div>
                <p class="text-gray-600 text-center">Completed Payments</p>
            </div>
            
            <div class="p-4 bg-teal-50 rounded-lg border border-teal-200 flex flex-col items-center justify-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">{{ \App\Models\PaymentTransaction::where('user_id', auth()->id())->where('payment_status', 'pending')->count() }}</div>
                <p class="text-gray-600 text-center">Pending Payments</p>
            </div>
        </div>
        
        <!-- Recent Bookings -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-teal-700 mb-3">Recent Bookings</h2>
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Code</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rental Unit</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(\App\Models\Booking::where('user_id', auth()->id())->orderBy('created_at', 'desc')->take(5)->get() as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $booking->booking_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->rentalUnit->address ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->check_in_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->check_out_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($booking->status == 'confirmed') bg-green-100 text-green-800 
                                        @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($booking->status == 'cancelled') bg-red-100 text-red-800 
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('filament.customer.resources.bookings.view', $booking->booking_id) }}" class="text-teal-600 hover:text-teal-900">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No bookings found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 text-right sm:px-6">
                    <a href="{{ route('filament.customer.resources.bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                        View All Bookings
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recent Payments -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-teal-700 mb-3">Recent Payments</h2>
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Code</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(\App\Models\PaymentTransaction::where('user_id', auth()->id())->orderBy('created_at', 'desc')->take(5)->get() as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->payment_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->payment_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($payment->payment_status == 'completed') bg-green-100 text-green-800 
                                        @elseif($payment->payment_status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($payment->payment_status == 'failed') bg-red-100 text-red-800 
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('filament.customer.resources.payments.view', $payment->payment_id) }}" class="text-teal-600 hover:text-teal-900">View Details</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->start_date ? $booking->start_date->format('d M Y') : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->end_date ? $booking->end_date->format('d M Y') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No payments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 text-right sm:px-6">
                    <a href="{{ route('filament.customer.resources.payments.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                        View All Payments
                    </a>
                </div>
            </div>
        </div>
        
        <div class="bg-teal-100 p-4 rounded-lg border border-teal-300">
            <h3 class="font-medium text-teal-800">Customer Notes</h3>
            <p class="text-teal-700">Need assistance? Contact our customer support team for help with bookings or payments.</p>
        </div>
    </div>
</x-filament-panels::page>
