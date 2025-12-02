<!DOCTYPE html>
<html lang="en">
<head>
    <title>Billing & Upgrade | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: sans-serif; background-color: #f3f4f6; }</style>
</head>
<body class="antialiased bg-gray-100">
    <div class="max-w-4xl mx-auto py-12">
        <div class="bg-white p-10 rounded-xl shadow-2xl border border-gray-200 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Upgrade Your Project: {{ tenant('id') }}</h1>
            <p class="text-gray-600 mb-8">Select a plan to continue service after the trial period ends.</p>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 border-4 border-indigo-600 rounded-lg shadow-md bg-indigo-50">
                    <h3 class="text-xl font-semibold text-indigo-700">Basic</h3>
                    <p class="text-3xl font-bold my-4 text-indigo-600">$10/mo</p>
                    <p class="text-sm text-gray-600 mb-6">Limited storage, 5 users.</p>
                    <a href="#" class="w-full block py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Select Plan</a>
                </div>
                <div class="p-6 border border-gray-300 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Pro</h3>
                    <p class="text-3xl font-bold my-4 text-gray-800">$25/mo</p>
                    <p class="text-sm text-gray-600 mb-6">Unlimited users, full features.</p>
                    <a href="#" class="w-full block py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Select Plan</a>
                </div>
                <div class="p-6 border border-gray-300 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Enterprise</h3>
                    <p class="text-3xl font-bold my-4 text-gray-800">Custom</p>
                    <p class="text-sm text-gray-600 mb-6">Dedicated support.</p>
                    <a href="#" class="w-full block py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Contact Sales</a>
                </div>
            </div>
            
            <a href="{{ route('tenant.dashboard') }}" class="mt-8 inline-block text-indigo-600 hover:text-indigo-800 font-medium">
                &larr; Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>