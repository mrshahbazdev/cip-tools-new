<div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting | {{ tenant('id') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f9fafb 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
        }
        .gradient-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
        .hover-lift { transition: all 0.3s ease; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); }
        .mobile-hidden { display: none; }
        @media (max-width: 1024px) {
            .sidebar-toggle { display: block !important; }
            .mobile-hidden { display: none; }
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <button onclick="document.querySelector('aside').classList.toggle('hidden');" class="sidebar-toggle fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-md lg:hidden">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <div class="flex min-h-screen">
        @include('components.partials.sidebar-nav')

        <div class="flex-1 flex flex-col">
            @include('components.partials.top-header')

            <main class="flex-1 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-6">
                        Branding & Configuration
                    </h1>
                    
                    @if ($currentTenant->is_active)
                        @if (session()->has('success'))
                            <div class="mb-4 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 animate-fade-in">
                                <p class="font-medium text-green-800 text-lg">{{ session('success') }}</p>
                            </div>
                        @endif

                        <form wire:submit.prevent="saveSettings" class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 space-y-6">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Slogan / Motto</label>
                                <input type="text" wire:model.defer="slogan" placeholder="e.g. Thought together and made together."
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/50 @error('slogan') border-red-400 @enderror">
                                @error('slogan') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Proposer Incentive Text</label>
                                <textarea wire:model.defer="incentive_text" rows="3" placeholder="Specify the type of remuneration offered (e.g., $500 bonus upon implementation)."
                                          class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/50 @error('incentive_text') border-red-400 @enderror"></textarea>
                                @error('incentive_text') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Project Logo (Max 1MB)</label>
                                <input type="file" wire:model="logo" class="w-full p-2 border border-gray-300 rounded-lg">
                                @error('logo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

                                @if ($currentTenant->logo_url)
                                    <p class="mt-2 text-xs text-gray-500">Current Logo is set. <a href="{{ $currentTenant->logo_url }}" target="_blank" class="text-indigo-600">View</a></p>
                                @endif
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150">
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    
                    @else
                        <div class="bg-red-50 border border-red-200 p-8 rounded-xl shadow-lg text-center">
                            <h3 class="text-2xl font-bold text-red-700 mb-4">Feature Locked: Upgrade Required</h3>
                            <p class="text-gray-600 mb-6">
                                Please complete your membership payment to unlock branding, slogan, and incentive text configuration.
                            </p>
                            <a href="{{ route('tenant.billing') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150">
                                Go to Billing
                            </a>
                        </div>
                    @endif

                </div>
            </main>
        </div>
    </div>

<script>
    // Helper function to toggle password visibility (Keep this!)
    function togglePasswordVisibility(fieldId) {
         const input = document.getElementById(fieldId);
         if (input) {
             input.type = input.type === 'password' ? 'text' : 'password';
         }
    }
    
    // JS for sidebar toggle and hover effects (kept outside Livewire methods)
    document.querySelector('.sidebar-toggle')?.addEventListener('click', function() {
         document.querySelector('aside').classList.toggle('hidden');
         document.querySelector('aside').classList.toggle('flex');
         document.querySelector('aside').classList.toggle('fixed');
         document.querySelector('aside').classList.toggle('inset-0');
         document.querySelector('aside').classList.toggle('z-40');
    });
    
    document.addEventListener('DOMContentLoaded', function() {
         const cards = document.querySelectorAll('.hover-lift');
         cards.forEach(card => {
             card.addEventListener('mouseenter', function() {
                 this.style.transition = 'all 0.3s ease';
             });
         });
    });
</script>
</body>
</html>
</div>