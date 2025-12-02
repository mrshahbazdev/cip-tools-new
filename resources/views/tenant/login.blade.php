<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tenant Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: sans-serif; background-color: #f3f4f6; }</style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-xl border border-gray-200">
        <h2 class="text-2xl font-bold text-center text-gray-900">Sign in to {{ tenant('id') }}</h2>

        @if($errors->any())
            <div class="p-3 text-sm text-red-700 bg-red-100 rounded-lg">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" action="{{ route('tenant.login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" required class="mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('email') }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required class="mt-1 w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sign in
                </button>
            </div>
        </form>
        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ url('/register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Register here</a>
        </p>
    </div>
</body>
</html>
