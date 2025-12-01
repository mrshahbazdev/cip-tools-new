<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ tenant('id') }} | Dashboard Access</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <span class="font-extrabold text-xl text-indigo-600 tracking-tight">
                {{ strtoupper(tenant('id')) }}
            </span>
            <a href="/app-dashboard/login" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition">
                Sign In
            </a>
        </div>
    </nav>

    <div class="pt-24 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                Welcome to the <span class="text-indigo-600">{{ tenant('id') }}</span> Workspace.
            </h1>

            <p class="text-xl text-gray-500 mb-10 max-w-2xl mx-auto">
                This is a secure, isolated workspace. Please login or register to access your project tools.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">

                <a href="/app-dashboard/login" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-semibold rounded-lg shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                    Login to Dashboard
                </a>

                <a href="/register" class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-semibold rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-100 transition duration-150">
                    Create New Account
                </a>
            </div>

            <p class="mt-12 text-sm text-gray-400">
                Are you the main administrator? Access your project's data, users, and settings after logging in.
            </p>
        </div>
    </div>

</body>
</html>
