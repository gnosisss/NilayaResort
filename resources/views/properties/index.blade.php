@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl overflow-hidden mb-12">
        <div class="absolute inset-0 opacity-20 bg-pattern"></div>
        <div class="relative z-10 px-8 py-12 md:py-16 md:px-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-black mb-4 text-shadow-gold">Properti Eksklusif Untuk Dijual</h1>
            <p class="text-primary-100 text-lg max-w-2xl mb-6 golden-green-text">Temukan hunian impian Anda di lokasi strategis dengan fasilitas premium dan lingkungan yang nyaman.</p>
            <div class="w-24 h-1 bg-white rounded-full"></div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 rounded-lg text-green-700 p-5 mb-8 flex items-center shadow-sm" role="alert">
        <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Property Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($properties as $property)
        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
            <!-- Property Image -->
            <div class="relative overflow-hidden">
                @if($property->images->isNotEmpty())
                <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" alt="{{ $property->address }}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105">
                @else
                <div class="w-full h-56 bg-gray-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                <!-- Property Type Badge -->
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-500 bg-opacity-90 text-white">
                        {{ $property->type }}
                    </span>
                </div>
            </div>
            
            <!-- Property Details -->
            <div class="p-6 flex-grow flex flex-col">
                <div class="mb-auto">
                    <div class="flex items-center mb-2">
                        <span class="text-xs font-medium text-primary-600 bg-primary-50 rounded-full px-2 py-1">{{ $property->category->name }}</span>
                    </div>
                    <h2 class="text-xl font-bold golden-green-text mb-3 line-clamp-2">{{ $property->address }}</h2>
                    
                    <!-- Price -->
                    <div class="mt-4 mb-6">
                        <span class="text-2xl font-bold text-gold">Rp {{ number_format($property->sale_price, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <!-- Action Button -->
                <a href="{{ route('properties.show', $property->unit_id) }}" class="mt-4 inline-flex w-full items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-lg text-black bg-primary-600 hover:bg-gold-green focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold transition-colors duration-300">
                    Lihat Detail
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-xl shadow-sm p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
            </svg>
            <p class="text-gray-500 text-lg font-medium">Tidak ada properti yang tersedia untuk dijual saat ini.</p>
            <p class="text-gray-400 mt-2">Silakan periksa kembali nanti untuk penawaran terbaru.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Add custom styles for this page -->
<style>
.bg-pattern {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Warna Nilaya Resort */
.golden-green-text {
    color: #2e8b57;
    text-shadow: 0 0 1px rgba(218, 165, 32, 0.3);
}

.text-gold {
    color: #daa520;
}

.text-shadow-gold {
    text-shadow: 0 0 2px rgba(218, 165, 32, 0.5);
}

.bg-gold-green {
    background-color: #1a5d38;
    border: 1px solid rgba(218, 165, 32, 0.5);
}

.focus\:ring-gold:focus {
    --tw-ring-color: rgba(218, 165, 32, 0.5);
}
</style>
@endsection