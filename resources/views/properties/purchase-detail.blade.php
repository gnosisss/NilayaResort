@extends('layouts.app')

@section('content')
<!-- Hero Section with Breadcrumbs -->
<div class="bg-gradient-to-r from-green-700 to-green-900 text-white py-12 mb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Detail Pengajuan Pembelian</h1>
        <div class="flex items-center text-sm text-green-100">
            <a href="{{ route('properties.index') }}" class="hover:text-amber-300 transition">Properti</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('properties.my-purchases') }}" class="hover:text-amber-300 transition">Pengajuan Pembelian</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span>{{ $purchase->purchase_code }}</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('properties.my-purchases') }}" class="inline-flex items-center text-green-700 hover:text-green-900 font-medium transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Pengajuan Saya
        </a>
    </div>

    <!-- Status Alerts -->
    @if($purchase->status == 'rejected')
    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-8 rounded-lg shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">
                    Maaf, pengajuan pembelian Anda ditolak. Silakan hubungi customer service kami untuk informasi lebih lanjut.
                </p>
            </div>
        </div>
    </div>
    @elseif($purchase->status == 'approved')
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-8 rounded-lg shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    Selamat! Pengajuan pembelian Anda telah disetujui. Tim kami akan segera menghubungi Anda untuk proses selanjutnya.
                </p>
            </div>
        </div>
    </div>
    @elseif($purchase->status == 'verified')
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8 rounded-lg shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-blue-800">
                    Dokumen Anda telah terverifikasi. Pihak bank sedang melakukan analisis kredit. Proses ini biasanya memakan waktu 2-3 hari kerja.
                </p>
            </div>
        </div>
    </div>
    @else
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8 rounded-lg shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-blue-800">
                    Pengajuan Anda sedang dalam proses verifikasi. Proses ini biasanya memakan waktu 3-5 hari kerja. Kami akan memberi tahu Anda jika ada perkembangan.
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="p-6 md:p-8">
            <!-- Application and Property Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <!-- Application Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-green-700 text-white py-4 px-6">
                        <h2 class="text-lg font-semibold">Informasi Pengajuan</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Kode Pengajuan</span>
                            <span class="font-medium text-gray-900">{{ $purchase->purchase_code }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Tanggal Pengajuan</span>
                            <span class="font-medium text-gray-900">{{ $purchase->created_at->format('d F Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Status</span>
                            @if($purchase->status == 'pending')
                            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Menunggu Verifikasi</span>
                            @elseif($purchase->status == 'verified')
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">Dokumen Terverifikasi</span>
                            @elseif($purchase->status == 'approved')
                            <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Disetujui</span>
                            @elseif($purchase->status == 'rejected')
                            <span class="inline-block bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">Ditolak</span>
                            @endif
                        </div>
                        @if($purchase->notes)
                        <div class="pt-2">
                            <span class="text-gray-600 block mb-1">Catatan:</span>
                            <p class="font-medium text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $purchase->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Property Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-amber-500 text-white py-4 px-6">
                        <h2 class="text-lg font-semibold">Detail Properti</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Alamat</span>
                            <span class="font-medium text-gray-900 text-right">{{ $purchase->rentalUnit->address }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Tipe</span>
                            <span class="font-medium text-gray-900">{{ $purchase->rentalUnit->type }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-600">Kategori</span>
                            <span class="font-medium text-gray-900">{{ $purchase->rentalUnit->category->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Harga</span>
                            <span class="font-medium text-green-700 text-lg">Rp {{ number_format($purchase->purchase_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="mb-10">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Dokumen yang Diunggah
                </h2>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        @if($purchase->documents->isEmpty())
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <p class="text-gray-500 text-lg">Tidak ada dokumen yang diunggah.</p>
                        </div>
                        @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($purchase->documents as $document)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow-md transition duration-300">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="flex items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <p class="font-medium text-gray-900">{{ \App\Models\PropertyDocument::$documentTypes[$document->document_type] ?? $document->document_type }}</p>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-1">{{ $document->file_name }}</p>
                                        <p class="text-xs text-gray-400">{{ $document->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        @if($document->status == 'pending')
                                        <span class="mr-3 inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Menunggu</span>
                                        @elseif($document->status == 'verified')
                                        <span class="mr-3 inline-block bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Terverifikasi</span>
                                        @elseif($document->status == 'rejected')
                                        <span class="mr-3 inline-block bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">Ditolak</span>
                                        @endif
                                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-green-700 hover:text-green-900 bg-green-50 hover:bg-green-100 p-2 rounded-full transition duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bank Verification Section -->
            @if($purchase->bankVerification)
            <div class="mb-10">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    Verifikasi Bank
                </h2>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                    <span class="text-gray-600">Status Dokumen</span>
                                    @if($purchase->bankVerification->documents_verified)
                                    <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Terverifikasi</span>
                                    @else
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Menunggu</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                    <span class="text-gray-600">Status Kredit</span>
                                    @if($purchase->bankVerification->credit_approved)
                                    <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Disetujui</span>
                                    @else
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Menunggu</span>
                                    @endif
                                </div>
                            </div>
                            <div class="space-y-4">
                                @if($purchase->bankVerification->credit_score)
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                    <span class="text-gray-600">Skor Kredit</span>
                                    <span class="font-medium text-gray-900">{{ $purchase->bankVerification->credit_score }}</span>
                                </div>
                                @endif
                                @if($purchase->bankVerification->approved_amount)
                                <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                    <span class="text-gray-600">Jumlah yang Disetujui</span>
                                    <span class="font-medium text-green-700">Rp {{ number_format($purchase->bankVerification->approved_amount, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                @if($purchase->bankVerification->verification_notes)
                                <div class="pt-2">
                                    <span class="text-gray-600 block mb-1">Catatan:</span>
                                    <p class="font-medium text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $purchase->bankVerification->verification_notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection