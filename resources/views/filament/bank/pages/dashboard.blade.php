<x-filament-panels::page>
    <div class="p-4 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold text-blue-600 mb-4">Bank Verification Dashboard</h1>
        <p class="mb-4">Welcome to the Bank Officer Dashboard. From here, you can verify and process property purchase transactions.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <h2 class="text-lg font-semibold text-blue-700">Pending Verifications</h2>
                <p class="text-gray-600">Review and process pending property purchase verifications</p>
            </div>
            
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <h2 class="text-lg font-semibold text-blue-700">Completed Verifications</h2>
                <p class="text-gray-600">View history of completed verifications</p>
            </div>
        </div>
        
        <div class="bg-blue-100 p-4 rounded-lg border border-blue-300">
            <h3 class="font-medium text-blue-800">Bank Officer Notes</h3>
            <p class="text-blue-700">This panel is for bank verification purposes only. All verification actions are logged and audited.</p>
        </div>
    </div>
</x-filament-panels::page>