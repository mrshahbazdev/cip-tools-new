<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #f9fafb 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.95); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full">
        <div class="glass-card p-8 rounded-lg border border-gray-200">

            <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">Forgot Password?</h2>
            <p class="text-gray-600 text-center mb-6">Enter your email to receive the reset link.</p>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm bg-green-100 text-green-700 p-3 rounded-xl border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input id="email" type="email" name="email" required autofocus
                           class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                           value="{{ old('email') }}">
                    @error('email')<span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>@enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition duration-150 shadow-md">
                        Send Password Reset Link
                    </button>
                </div>

                <p class="text-center text-sm mt-4">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        &larr; Back to Login
                    </a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
