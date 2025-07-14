@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('properties.show', $property->unit_id) }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail Properti
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Ajukan Pembelian Properti</h1>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Detail Properti:</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 mb-1">Alamat:</p>
                        <p class="font-medium">{{ $property->address }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Tipe:</p>
                        <p class="font-medium">{{ $property->type }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Kategori:</p>
                        <p class="font-medium">{{ $property->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Harga:</p>
                        <p class="font-medium text-indigo-600">Rp {{ number_format($property->sale_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('properties.purchase.store', $property->unit_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Silakan unggah dokumen-dokumen berikut untuk melanjutkan proses pembelian properti. Semua dokumen harus dalam format PDF, JPG, atau PNG dengan ukuran maksimal 10MB.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($documentTypes as $key => $label)
                    <div class="border rounded-lg p-4">
                        <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $label }} @if(in_array($key, ['KTP', 'KK', 'SLIP_GAJI', 'NPWP'])) <span class="text-red-500">*</span> @endif</label>
                        <input type="file" id="{{ $key }}" name="{{ $key }}" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" @if(in_array($key, ['KTP', 'KK', 'SLIP_GAJI', 'NPWP'])) required @endif>
                        @error($key)
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endforeach
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                    <textarea id="notes" name="notes" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Tambahkan catatan atau informasi tambahan jika diperlukan"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300">
                        Kirim Pengajuan Pembelian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection