@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-3xl text-green-500"></i>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Pengajuan Berhasil!</h1>
            
            <p class="text-gray-600 mb-6">
                Terima kasih telah mengajukan pembelian properti. Pengajuan Anda telah berhasil dikirim dan akan segera diproses oleh tim kami.
            </p>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Detail Pengajuan:</h2>
                <p class="text-gray-600 mb-1">Kode Pengajuan: <span class="font-medium">{{ $purchase->purchase_code }}</span></p>
                <p class="text-gray-600 mb-1">Properti: <span class="font-medium">{{ $purchase->rentalUnit->address }}</span></p>
                <p class="text-gray-600 mb-1">Harga: <span class="font-medium">Rp {{ number_format($purchase->purchase_amount, 0, ',', '.') }}</span></p>
                <p class="text-gray-600 mb-1">Tanggal Pengajuan: <span class="font-medium">{{ $purchase->created_at->format('d F Y, H:i') }}</span></p>
                <p class="text-gray-600">Status: <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ ucfirst($purchase->status) }}</span></p>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 text-left">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Dokumen Anda akan diverifikasi oleh pihak bank. Proses verifikasi biasanya memakan waktu 3-5 hari kerja. Anda dapat memantau status pengajuan Anda di halaman "Pengajuan Saya".
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                <a href="{{ route('properties.my-purchases') }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded transition duration-300">
                    Lihat Pengajuan Saya
                </a>
                <a href="{{ route('properties.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded transition duration-300">
                    Kembali ke Daftar Properti
                </a>
            </div>
        </div>
    </div>
</div>
@endsection