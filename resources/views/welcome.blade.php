<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cip Tools - Advanced Project Management</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="antialiased bg-gray-900 text-white font-sans">

    <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center font-bold text-white">C</div>
                    <span class="font-bold text-xl tracking-tight">Cip Tools</span>
                </div>
                <div class="hidden md:block">
                    <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Features</a>
                    <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Pricing</a>
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium ml-2 transition">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 tracking-tight mb-6">
                Manage Projects with <br/> Your Own Space.
            </h1>
            <p class="mt-4 text-lg text-gray-400 max-w-2xl mx-auto mb-10">
                Create your isolated workspace, manage team activities, and control everything with our advanced multi-tenant system. Start your 30-day free trial now.
            </p>

            <div class="bg-gray-800 border border-gray-700 p-8 rounded-2xl shadow-2xl max-w-md mx-auto relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-cyan-500"></div>
                <h3 class="text-xl font-bold mb-4">Start Your Free Project</h3>

                <div class="space-y-4 text-left">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Project Name</label>
                        <input type="text" disabled placeholder="e.g. My Company" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-gray-300 focus:outline-none focus:border-indigo-500 transition cursor-not-allowed opacity-50">
                    </div>
                    <button disabled class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition opacity-50 cursor-not-allowed">
                        Create Project (Coming Next)
                    </button>
                </div>
            </div>
        </div>

        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none opacity-20">
            <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute top-20 right-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        </div>
    </div>

</body>
</html>
