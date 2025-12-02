<div class="bg-gray-100 min-h-screen antialiased">
    
    <header class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            
            <div class="flex items-center space-x-3">
                <a href="/dashboard" class="text-gray-500 hover:text-indigo-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-800">
                    User Management ({{ tenant('id') }})
                </h1>
            </div>

            <span class="text-sm font-medium text-gray-600">
                Total Users: {{ $users->total() }}
            </span>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <button wire:click="create()" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-150">
                + Add New User
            </button>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_tenant_admin ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $user->is_tenant_admin ? 'Admin (Owner)' : 'Standard User' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 mx-2">Edit</button>
                            {{-- Cannot delete the owner (is_tenant_admin=1) --}}
                            @if(!$user->is_tenant_admin)
                                <button wire:click="delete({{ $user->id }})" onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-900">Delete</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>

        @if($isModalOpen)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
                <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">{{ $userId ? 'Edit User' : 'Create New User' }}</h3>
                    <form wire:submit.prevent="store" class="space-y-4">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model="name" class="mt-1 w-full p-2 border border-gray-300 rounded-md">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model="email" class="mt-1 w-full p-2 border border-gray-300 rounded-md" {{ $userId ? 'readonly' : '' }}>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password ({{ $userId ? 'Leave blank to keep current' : 'Required' }})</label>
                            <input type="password" wire:model="password" class="mt-1 w-full p-2 border border-gray-300 rounded-md">
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="pt-4 flex justify-end space-x-3">
                            <button type="button" wire:click="$set('isModalOpen', false)" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </main>
</div>