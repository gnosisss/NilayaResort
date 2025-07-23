<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Document Review Details</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Document assessment and credit scoring information.</p>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Purchase Code</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $bankVerification->propertyPurchase->purchase_code }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Document Status</dt>
                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                    @if($bankVerification->document_status == 'accepted')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Diterima</span>
                    @elseif($bankVerification->document_status == 'revision')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Perlu Revisi</span>
                    @elseif($bankVerification->document_status == 'rejected')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Pending</span>
                    @endif
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Credit Score</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="relative pt-1">
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                            <div style="width:{{ $bankVerification->credit_score }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $bankVerification->credit_score >= 70 ? 'bg-green-500' : ($bankVerification->credit_score >= 40 ? 'bg-yellow-500' : 'bg-red-500') }}"></div>
                        </div>
                        <span class="text-xs font-semibold inline-block text-gray-600">
                            {{ $bankVerification->credit_score }}% ({{ $bankVerification->credit_score >= 70 ? 'Baik' : ($bankVerification->credit_score >= 40 ? 'Cukup' : 'Kurang') }})
                        </span>
                    </div>
                </dd>
            </div>
            
            @if($bankVerification->document_status == 'revision' && $bankVerification->revision_notes)
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Catatan Revisi</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="p-4 border border-yellow-300 bg-yellow-50 rounded-md">
                        {{ $bankVerification->revision_notes }}
                    </div>
                </dd>
            </div>
            @endif
            
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Penilaian Dokumen</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <div class="border border-gray-200 rounded-md divide-y divide-gray-200">
                        @forelse($bankVerification->documentReviews as $review)
                            <div class="p-4">
                                <div class="flex justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium">{{ \App\Models\PropertyDocument::$documentTypes[$review->document_type] ?? $review->document_type }}</h4>
                                    </div>
                                    <div>
                                        @if($review->status == 'accepted')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Diterima</span>
                                        @elseif($review->status == 'revision')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Perlu Revisi</span>
                                        @elseif($review->status == 'rejected')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($review->notes && ($review->status == 'revision' || $review->status == 'rejected'))
                                    <div class="mt-2 p-2 border border-gray-200 bg-gray-50 rounded text-xs">
                                        <p class="font-medium">Catatan:</p>
                                        <p>{{ $review->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-4 text-sm text-gray-500">Belum ada penilaian dokumen.</div>
                        @endforelse
                    </div>
                </dd>
            </div>
            
            @if($bankVerification->documents_verified)
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Status Verifikasi</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Dokumen Terverifikasi</span>
                    @if($bankVerification->credit_approved)
                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Kredit Disetujui</span>
                    @endif
                </dd>
            </div>
            @endif
            
            @if($bankVerification->credit_approved)
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Jumlah Disetujui</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($bankVerification->approved_amount, 0, ',', '.') }}</dd>
            </div>
            @endif
            
            @if($bankVerification->verification_notes)
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Catatan Verifikasi</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $bankVerification->verification_notes }}</dd>
            </div>
            @endif
        </dl>
    </div>
</div>