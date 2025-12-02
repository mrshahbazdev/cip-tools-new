<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen antialiased">

    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <h1 class="text-xl font-bold text-indigo-700">
                {{ strtoupper(tenant('id')) }} Control Panel
            </h1>

            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-600 hidden sm:block">
                    Admin: {{ auth()->user()->email }}
                </span>
                
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm py-1.5 px-4 rounded-lg transition duration-150 shadow-md">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                Project Overview
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Total Team Members</p>
                    <p class="text-4xl font-bold text-indigo-600 mt-1">
                        {{ \App\Models\TenantUser::where('tenant_id', tenant('id'))->count() }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Subscription Status</p>
                    <p class="text-xl font-bold text-green-500 mt-2">
                        @php $status = \App\Models\Tenant::find(tenant('id'))->plan_status ?? 'N/A'; @endphp
                        <span class="text-2xl uppercase {{ $status === 'trial' ? 'text-orange-500' : 'text-green-600' }}">{{ $status }}</span>
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Storage Used</p>
                    <p class="text-4xl font-bold text-gray-700 mt-1">20 MB</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <p class="text-sm font-medium text-gray-500">Project ID</p>
                    <p class="text-xl font-mono text-gray-700 mt-2">{{ tenant('id') }}</p>
                </div>
            </div>

            <div class="mt-10 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Quick Management</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <a href="/users" class="flex items-center justify-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-150">
                        <span class="text-indigo-700 font-medium">Manage Users (Pending)</span>
                    </a>
                    
                    <a href="/settings" class="flex items-center justify-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-150">
                        <span class="text-indigo-700 font-medium">Project Settings (Pending)</span>
                    </a>
                    
                    <a href="/billing" class="flex items-center justify-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition duration-150">
                        <span class="text-indigo-700 font-medium">Billing & Plan (Pending)</span>
                    </a>
                </div>
            </div>
            
        </div>
    </main>

</body>
</html>