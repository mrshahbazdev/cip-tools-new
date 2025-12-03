<div class="antialiased min-h-screen">
    
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
        @media (max-width: 1024px) {
            .sidebar-toggle { display: block !important; }
            .mobile-hidden { display: none; }
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    @php
        $loggedInUser = auth()->user();
    @endphp

    <button onclick="document.querySelector('aside').classList.toggle('hidden');" class="sidebar-toggle fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-md lg:hidden">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <div class="flex min-h-screen">
        <aside class="hidden lg:flex w-64 flex-col glass-card border-r border-gray-200 z-40">
            <div class="p-6">
                <h2 class="text-xl font-extrabold text-gray-800">{{ strtoupper(tenant('id')) }}</h2>
                <p class="text-sm text-gray-500 mt-1">Workspace</p>
            </div>
            
            <nav class="flex-1 px-4">
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Main</h3>
                    <a href="/dashboard" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('tenant.users.manage') }}" class="flex items-center space-x-3 p-3 rounded-lg bg-indigo-50 text-indigo-700 mb-2 font-medium">
                        <i class="fas fa-users"></i>
                        <span>Team Management</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-lightbulb"></i>
                        <span>Project Ideas</span>
                    </a>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xs uppercase font-semibold text-gray-500 mb-3">Settings</h3>
                    <a href="/settings" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-cog"></i>
                        <span>Project Settings</span>
                    </a>
                    <a href="{{ route('tenant.billing') }}" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 mb-2 font-medium">
                        <i class="fas fa-credit-card"></i>
                        <span>Billing & Plan</span>
                    </a>
                </div>
            </nav>
            
            <div class="mt-auto p-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm font-medium text-blue-800">Admin: {{ $loggedInUser->name ?? 'Project Admin' }}</p>
                    <p class="text-xs text-blue-600 mt-1">{{ $loggedInUser->email }}</p>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="glass-card border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <h1 class="text-lg font-semibold text-gray-800">Team Management</h1>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="h-9 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition duration-150 flex items-center space-x-2">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span class="mobile-hidden">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    @if (session()->has('message'))
                        <div class="mb-4 p-4 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 animate-fade-in">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-green-800 text-lg">{{ session('message') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mb-10">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                    Team Management
                                </h1>
                                <p class="text-gray-600 mt-1">
                                    Manage users in <span class="font-semibold text-indigo-600">{{ strtoupper(tenant('id')) }}</span> workspace
                                </p>
                            </div>
                            <button wire:click="create()" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/40 transition-all duration-300 flex items-center gap-2 group">
                                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Team Member
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-gradient-to-br from-white to-gray-50 p-5 rounded-2xl border border-gray-200 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $users->total() }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                                        <i class="fas fa-users text-indigo-600"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-white to-gray-50 p-5 rounded-2xl border border-gray-200 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Admin Users</p>
                                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $users->where('is_tenant_admin', true)->count() }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-xl bg-purple-50 flex items-center justify-center">
                                        <i class="fas fa-lock text-purple-600"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-white to-gray-50 p-5 rounded-2xl border border-gray-200 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Standard Users</p>
                                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $users->where('is_tenant_admin', false)->count() }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-xl bg-blue-50 flex items-center justify-center">
                                        <i class="fas fa-user-alt text-blue-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl border border-gray-200 overflow-hidden mt-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50/80">
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                    <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-100 to-blue-100 flex items-center justify-center mr-3">
                                                    <span class="font-semibold text-indigo-700 text-sm">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">Member since {{ $user->created_at->format('M d, Y') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_tenant_admin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                @if($user->is_tenant_admin)
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                                    Admin
                                                @else
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                                    Standard
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <button wire:click="edit({{ $user->id }})" class="text-gray-600 hover:text-indigo-700 p-2 rounded-lg hover:bg-indigo-50 transition-all duration-200 group" title="Edit User">
                                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                
                                                @if(!$user->is_tenant_admin)
                                                    <button wire:click="delete({{ $user->id }})" onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()" class="text-gray-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-all duration-200 group" title="Remove User">
                                                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($users->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200 glass-card rounded-b-2xl mt-0">
                                {{ $users->links() }}
                            </div>
                        @endif
                    </div>
                    
                </div>
            </main>
        </div>
    </div>

@if($isModalOpen)
    <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-2xl w-full max-w-md border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ $userId ? 'Edit Team Member' : 'Add Team Member' }}
                    </h3>
                    <button wire:click="$set('isModalOpen', false)" 
                        class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form wire:submit.prevent="store" class="p-6 space-y-6">
                <div class="space-y-5">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center justify-between">
                            <span>Full Name</span>
                            <span class="text-xs text-gray-400">Required</span>
                        </label>
                        <div class="relative">
                            <input type="text" wire:model="name" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white @error('name') border-red-400 focus:ring-red-500/30 @enderror"
                                placeholder="John Doe">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('name') 
                            <div class="flex items-center gap-1 mt-2 text-red-500 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <input type="email" wire:model="email" {{ $userId ? 'readonly' : '' }}
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white @error('email') border-red-400 focus:ring-red-500/30 @enderror {{ $userId ? 'bg-gray-50' : '' }}"
                                placeholder="user@company.com">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('email') 
                            <div class="flex items-center gap-1 mt-2 text-red-500 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-xs font-normal text-gray-400">({{ $userId ? 'Leave blank to keep current' : 'Required' }})</span>
                        </label>
                        <div class="relative">
                            <input type="password" wire:model="password" id="modal-password" 
                                class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all duration-200 bg-white @error('password') border-red-400 focus:ring-red-500/30 @enderror"
                                placeholder="••••••••">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <button type="button" onclick="togglePasswordVisibility('modal-password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg id="eye-icon-modal" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password') 
                            <div class="flex items-center gap-1 mt-2 text-red-500 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" wire:click="$set('isModalOpen', false)" 
                        class="px-5 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-600 transition-all duration-300 shadow-md">
                        {{ $userId ? 'Update Member' : 'Add Member' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

<script>
    // Helper function to toggle password visibility
    function togglePasswordVisibility(fieldId) {
        const input = document.getElementById(fieldId);
        const eyeIcon = document.getElementById('eye-icon-modal'); // Assuming the eye icon has this ID
        
        if (input && eyeIcon) {
            if (input.type === 'password') {
                input.type = 'text';
                // Change icon to show 'open eye' (Simple representation)
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            } else {
                input.type = 'password';
                // Change icon back to show 'closed eye' (Simple representation)
                 eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
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
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
         const sidebar = document.querySelector('aside');
         const toggleBtn = document.querySelector('.sidebar-toggle');
         
         if (window.innerWidth < 1024 && 
             sidebar && sidebar.classList.contains('fixed') && 
             !sidebar.contains(event.target) && 
             toggleBtn && !toggleBtn.contains(event.target)) {
             sidebar.classList.add('hidden');
             sidebar.classList.remove('flex');
         }
    });
    
    // Add hover effects to cards
    document.addEventListener('DOMContentLoaded', function() {
         const cards = document.querySelectorAll('.hover-lift');
         cards.forEach(card => {
             card.addEventListener('mouseenter', function() {
                 this.style.transition = 'all 0.3s ease';
             });
         });
    });
</script>
</div>