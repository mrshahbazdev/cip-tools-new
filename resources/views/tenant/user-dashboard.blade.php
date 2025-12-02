<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Account | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }</style>
</head>
<body class="antialiased bg-gray-100">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-700">
                {{ strtoupper(tenant('id')) }} Workspace
            </h1>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm py-1.5 px-4 rounded-lg transition">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Welcome, {{ auth()->user()->name }}!
                </h2>
                <p class="text-lg text-gray-600 mb-6">
                    You have successfully logged in to your private workspace.
                </p>
                
                <div class="mt-8 border-t border-gray-200 pt-6 space-y-3">
                    <p class="text-sm text-gray-700 font-medium">
                        <span class="text-indigo-600 mr-2">Email:</span> 
                        {{ auth()->user()->email }}
                    </p>
                    <p class="text-sm text-gray-500">
                        *Aapko Management Dashboard access karne ki ijazat nahi hai.
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>