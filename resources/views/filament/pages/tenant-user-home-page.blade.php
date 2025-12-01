<x-filament-panels::page>
    <div class="fi-user-welcome-page">
        <h1 class="text-3xl font-bold text-gray-950 dark:text-white">
            Welcome to the User Dashboard.
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">
            This is your secure area. You currently have limited access.
        </p>

        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-3">Your Permissions:</h2>
            <p class="text-sm text-gray-600">
                You are a standard user for project {{ tenant('id') }}.
                <br>
                Please contact the project administrator if you require full dashboard access.
            </p>
        </div>
    </div>
</x-filament-panels::page>
