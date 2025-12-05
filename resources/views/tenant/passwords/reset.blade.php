<div class="max-w-md mx-auto py-12">
    <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200">
        <h2 class="text-2xl font-bold text-center mb-6">Reset Password</h2>
        
        @if (session('status'))
             <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" required class="mt-1 w-full p-3 border rounded-md" value="{{ $email ?? old('email') }}">
                @error('email')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input id="password" type="password" name="password" required class="mt-1 w-full p-3 border rounded-md">
                @error('password')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>
            
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 w-full p-3 border rounded-md">
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-md font-semibold hover:bg-indigo-700">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>