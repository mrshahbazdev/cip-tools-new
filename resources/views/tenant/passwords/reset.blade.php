<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #f9fafb 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.95); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full">
        <div class="glass-card p-8 rounded-lg border border-gray-200">

            <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">Reset Your Password</h2>

            @if (session('status'))
                 <div class="mb-4 font-medium text-sm bg-green-100 text-green-700 p-3 rounded-xl border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            @error('email')
                <div class="mb-4 font-medium text-sm bg-red-100 text-red-700 p-3 rounded-xl border border-red-200">
                    {{ $message }}
                </div>
            @enderror

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input id="email" type="email" name="email" required class="w-full p-3 border rounded-xl" value="{{ $email ?? old('email') }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input id="password" type="password" name="password" required class="w-full p-3 border rounded-xl @error('password') border-red-500 @enderror">
                    @error('password')<span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full p-3 border rounded-xl">
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition duration-150 shadow-md">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
