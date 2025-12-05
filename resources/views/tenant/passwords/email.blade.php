<div class="max-w-md mx-auto py-12">
    <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200">
        <h2 class="text-2xl font-bold text-center mb-6">Forgot Password</h2>
        
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded">
                {{ session('status') }}
            </div>
        @endif
        
        @error('email')
            <div class="mb-4 font-medium text-sm text-red-600 bg-red-50 p-3 rounded">
                {{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" required class="mt-1 w-full p-3 border rounded-md">
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-md font-semibold hover:bg-indigo-700">
                    Send Password Reset Link
                </button>
            </div>
        </form>
    </div>
</div>