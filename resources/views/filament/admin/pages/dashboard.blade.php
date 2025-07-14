<x-filament-panels::page>
    <div class="p-4 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold text-red-600 mb-4">Admin Dashboard</h1>
        <p class="mb-4">Welcome to the Admin Dashboard. From here, you can manage all aspects of the Nilaya Resort system.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                <h2 class="text-lg font-semibold text-red-700">Properties</h2>
                <p class="text-gray-600">Manage all properties and rental units</p>
            </div>
            
            <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                <h2 class="text-lg font-semibold text-red-700">Users</h2>
                <p class="text-gray-600">Manage user accounts and permissions</p>
            </div>
            
            <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                <h2 class="text-lg font-semibold text-red-700">Reports</h2>
                <p class="text-gray-600">View system-wide reports and analytics</p>
            </div>
        </div>
        
        <div class="bg-red-100 p-4 rounded-lg border border-red-300">
            <h3 class="font-medium text-red-800">Administrator Notes</h3>
            <p class="text-red-700">This panel has full system access. All actions are logged for security purposes.</p>
        </div>
    </div>
</x-filament-panels::page>