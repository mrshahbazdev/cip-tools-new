<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: sans-serif; background-color: #f3f4f6; }</style>
</head>
<body class="antialiased">
    <div class="p-8 text-center bg-white rounded-lg shadow-lg m-10">
        <h1 class="text-3xl font-bold text-indigo-600 mb-4">
            Welcome to Your Project Dashboard!
        </h1>
        <p class="text-xl text-gray-700">
            You are logged in as: <span class="font-semibold">{{ auth()->user()->email }}</span>
        </p>
        <p class="text-sm text-gray-500 mt-2">
            This is your workspace, served from the main database with tenant ID: <span class="font-mono text-xs">{{ tenant('id') }}</span>
        </p>

        <form method="POST" action="{{ url('/logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition">
                Logout
            </button>
        </form>
    </div>
</body>
</html>
