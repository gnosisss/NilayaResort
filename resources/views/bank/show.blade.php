@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-700 to-green-900 text-white py-12 mb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-2 mb-4">
            <a href="{{ route('bank.index') }}" class="inline-flex items-center text-green-100 hover:text-white transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Pengajuan
            </a>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Verifikasi Pengajuan Pembelian</h1>
        <p class="text-green-100">Kode Pengajuan: {{ $purchase->purchase_code }}</p>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-lg shadow-sm" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="p-6 md:p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Informasi Pengajuan
                    </h2>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                            <div class="text-sm text-gray-500">Status Pengajuan</div>
                            @if($purchase->status == 'pending')
                            <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1.5"></span>
                                Menunggu Verifikasi
                            </span>
                            @elseif($purchase->status == 'verified')
                            <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-1.5"></span>
                                Dokumen Terverifikasi
                            </span>
                            @elseif($purchase->status == 'approved')
                            <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                Disetujui
                            </span>
                            @elseif($purchase->status == 'rejected')
                            <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-red-100 text-red-800">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-1.5"></span>
                                Ditolak
                            </span>
                            @endif
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 text-sm">Kode Pengajuan:</span>
                                <span class="font-medium text-gray-900">{{ $purchase->purchase_code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 text-sm">Tanggal Pengajuan:</span>
                                <span class="font-medium text-gray-900">{{ $purchase->created_at->format('d F Y, H:i') }}</span>
                            </div>
                            @if($purchase->notes)
                            <div class="pt-3 mt-3 border-t border-gray-100">
                                <span class="text-gray-600 text-sm block mb-1">Catatan:</span>
                                <p class="text-gray-800 text-sm bg-gray-50 p-2 rounded">{{ $purchase->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Pelanggan
                    </h2>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                        <div class="flex items-center mb-4 pb-3 border-b border-gray-100">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xl mr-3">
                                {{ substr($purchase->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $purchase->user->name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $purchase->user->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-600">{{ $purchase->user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Detail Properti
                </h2>
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center text-green-600 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $purchase->rentalUnit->type }}</h3>
                                <p class="text-gray-500 text-sm">{{ $purchase->rentalUnit->category->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Harga Properti</div>
                            <div class="text-xl font-bold text-green-600">Rp {{ number_format($purchase->purchase_amount, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <span class="text-gray-600 text-sm font-medium block mb-1">Alamat Properti:</span>
                                <p class="text-gray-800">{{ $purchase->rentalUnit->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Dokumen yang Diunggah
                </h2>
                <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                    @if($purchase->documents->isEmpty())
                    <div class="py-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Dokumen</h3>
                        <p class="text-gray-500 max-w-md mx-auto">Pelanggan belum mengunggah dokumen apapun untuk pengajuan ini.</p>
                    </div>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($purchase->documents as $document)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900 line-clamp-1">{{ \App\Models\PropertyDocument::$documentTypes[$document->document_type] ?? $document->document_type }}</h3>
                                            <p class="text-xs text-gray-500">{{ $document->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    @if($document->status == 'pending')
                                    <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1.5"></span>
                                        Menunggu
                                    </span>
                                    @elseif($document->status == 'verified')
                                    <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                        Terverifikasi
                                    </span>
                                    @elseif($document->status == 'rejected')
                                    <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-red-100 text-red-800">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-1.5"></span>
                                        Ditolak
                                    </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 mb-3 line-clamp-1">{{ $document->file_name }}</p>
                                <div class="flex justify-end">
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium rounded-md transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat Dokumen
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Verifikasi Dokumen
                    </h2>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                        @if($purchase->bankVerification && $purchase->bankVerification->documents_verified)
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        Dokumen telah diverifikasi pada {{ $purchase->bankVerification->updated_at->format('d F Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @else
                        <form action="{{ route('bank.verify-documents', $purchase->purchase_id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="verification_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Verifikasi</label>
                                <textarea id="verification_notes" name="verification_notes" rows="3" class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Tambahkan catatan verifikasi jika diperlukan"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Verifikasi Dokumen
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Analisis Kredit
                    </h2>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                        @if($purchase->bankVerification && $purchase->bankVerification->credit_approved)
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-5 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        Kredit telah disetujui pada {{ $purchase->bankVerification->updated_at->format('d F Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <p class="text-sm font-medium text-gray-500 mb-1">Skor Kredit</p>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <p class="text-xl font-bold text-gray-800">{{ $purchase->bankVerification->credit_score }}</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <p class="text-sm font-medium text-gray-500 mb-1">Jumlah Disetujui</p>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($purchase->bankVerification->approved_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <p class="text-sm font-medium text-gray-500 mb-2">Catatan Analisis</p>
                            <p class="text-sm text-gray-700">{{ $purchase->bankVerification->verification_notes ?: 'Tidak ada catatan' }}</p>
                        </div>
                        @else
                        <form action="{{ route('bank.approve-credit', $purchase->purchase_id) }}" method="POST">
                            @csrf
                            <div class="mb-5">
                                <label for="credit_score" class="block text-sm font-medium text-gray-700 mb-2">Skor Kredit</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="number" id="credit_score" name="credit_score" min="0" max="100" step="0.01" class="block w-full pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-lg transition duration-150 ease-in-out" placeholder="Masukkan skor kredit" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('credit_score')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="approved_amount" class="block text-sm font-medium text-gray-700 mb-2">Jumlah yang Disetujui</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" id="approved_amount" name="approved_amount" min="0" step="0.01" class="block w-full pl-12 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-lg transition duration-150 ease-in-out" placeholder="0" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('approved_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="verification_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Analisis Kredit</label>
                                <textarea id="verification_notes" name="verification_notes" rows="4" class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Tambahkan catatan analisis kredit jika diperlukan"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Setujui Kredit
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            @if(!$purchase->bankVerification || (!$purchase->bankVerification->documents_verified && !$purchase->bankVerification->credit_approved))
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tolak Pengajuan
                </h2>
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-5 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Perhatian: Tindakan ini akan menolak pengajuan pembelian properti dan tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('bank.reject', $purchase->purchase_id) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                            <textarea id="rejection_reason" name="rejection_reason" rows="4" class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Jelaskan alasan penolakan pengajuan ini secara detail..." required></textarea>
                            @error('rejection_reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak Pengajuan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection