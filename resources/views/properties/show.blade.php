@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back Button -->
    <div class="mb-8">
        <a href="{{ route('properties.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Properti
        </a>
    </div>

    <!-- Property Details Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Property Header for Mobile -->
        <div class="block md:hidden p-6 border-b border-gray-100">
            <h1 class="text-2xl font-bold text-gray-800 mb-3">{{ $property->address }}</h1>
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">{{ $property->type }}</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">{{ $property->category->name }}</span>
            </div>
            <h2 class="text-2xl font-bold text-primary-600">Rp {{ number_format($property->sale_price, 0, ',', '.') }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
            <!-- Image Gallery Section -->
            <div class="p-6">
                @if($property->images->isNotEmpty())
                <!-- Main Image -->
                <div class="mb-6 overflow-hidden rounded-xl">
                    <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" alt="{{ $property->address }}" class="w-full h-auto object-cover hover:scale-105 transition-transform duration-500">
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($property->images->count() > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach($property->images->skip(1)->take(4) as $image)
                    <div class="overflow-hidden rounded-lg cursor-pointer hover:opacity-90 transition-opacity duration-300 border-2 border-transparent hover:border-primary-500">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $property->address }}" class="w-full h-20 object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
                @else
                <!-- No Image Placeholder -->
                <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-xl border border-gray-200">
                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
            </div>

            <!-- Property Details Section -->
            <div class="p-6 md:p-8 bg-gray-50 md:bg-white">
                <!-- Property Header for Desktop -->
                <div class="hidden md:block mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $property->address }}</h1>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">{{ $property->type }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">{{ $property->category->name }}</span>
                    </div>
                    <h2 class="text-3xl font-bold text-primary-600">Rp {{ number_format($property->sale_price, 0, ',', '.') }}</h2>
                </div>

                <!-- Divider -->
                <div class="hidden md:block w-16 h-1 bg-primary-500 rounded-full mb-8"></div>

                <!-- Facilities Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Fasilitas Properti
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($property->facilities as $facility)
                        <div class="flex items-center p-3 bg-white md:bg-gray-50 rounded-lg">
                            <svg class="w-5 h-5 text-primary-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700 font-medium">{{ $facility->name }}</span>
                        </div>
                        @empty
                        <div class="col-span-2 p-4 bg-white md:bg-gray-50 rounded-lg text-center">
                            <p class="text-gray-500">Tidak ada fasilitas yang tercantum</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mt-8">
                    <a href="{{ route('properties.purchase.create', $property->unit_id) }}" class="group relative inline-flex w-full items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-xl text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 overflow-hidden">
                        <span class="absolute right-0 translate-x-full group-hover:translate-x-0 opacity-0 group-hover:opacity-100 transition-all duration-300 ease-out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                        <span class="group-hover:-translate-x-2 transition-transform duration-300 ease-out">Ajukan Pembelian</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add custom styles for this page -->
<style>
/* Smooth hover effects */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

/* Ensure images maintain aspect ratio */
img.object-cover {
    object-fit: cover;
}
</style>
@endsection