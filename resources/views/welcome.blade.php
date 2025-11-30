<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cip Tools - Project Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', // Indigo 600
                        secondary: '#1E293B', // Slate 800
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-slate-600 font-sans antialiased">

    <nav class="bg-white border-b border-gray-200 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-lg">C</div>
                    <span class="font-bold text-xl text-slate-900 tracking-tight">Cip Tools</span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-medium text-slate-600 hover:text-primary transition">Features</a>
                    <a href="#pricing" class="text-sm font-medium text-slate-600 hover:text-primary transition">Pricing</a>
                    <a href="#" class="text-sm font-medium text-slate-900 hover:text-primary transition">Login</a>
                    <a href="#" class="bg-primary hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md shadow-indigo-200">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-6">
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        New: Multi-Tenant Architecture
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight mb-6">
                        Manage Projects in <br/>
                        <span class="text-primary">Your Own Private Space.</span>
                    </h1>
                    <p class="text-lg text-slate-500 mb-8 max-w-2xl mx-auto lg:mx-0">
                        Get a dedicated subdomain for your team. Isolated database, secure environment, and powerful project management tools.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            30 Days Free Trial
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            No Credit Card Required
                        </div>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-md lg:max-w-full">
                    <div class="absolute -top-10 -right-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>

                    <div class="relative bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-slate-900">Create Your Project</h3>
                            <p class="text-sm text-slate-500">Claim your unique subdomain URL instantly.</p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Project Name</label>
                                <input type="text" placeholder="e.g. Acme Corp" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition bg-gray-50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Desired Subdomain</label>
                                <div class="flex">
                                    <input type="text" placeholder="acme" class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition bg-gray-50">
                                    <span class="inline-flex items-center px-3 border border-l-0 border-gray-300 bg-gray-100 text-gray-500 text-sm rounded-r-lg">
                                        .cip-tools.de
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                                <input type="email" placeholder="you@company.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition bg-gray-50">
                            </div>

                            <button class="w-full bg-primary hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-indigo-200/50 flex justify-center items-center gap-2">
                                Start Free Trial
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                        <p class="text-center text-xs text-slate-400 mt-4">
                            By creating an account, you agree to our Terms & Conditions.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900">Why choose Cip Tools?</h2>
                <p class="mt-4 text-slate-500">Everything you need to manage your organization efficiently.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-primary mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Isolated Database</h3>
                    <p class="text-slate-500 text-sm">Every tenant gets their own database. Your data is strictly separated from others for maximum security.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Secure Subdomains</h3>
                    <p class="text-slate-500 text-sm">Get your own branding with <code>company.cip-tools.de</code>. Easy access for all your employees.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center text-pink-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">High Performance</h3>
                    <p class="text-slate-500 text-sm">Built on latest Laravel technology. Experience blazing fast speeds and real-time updates.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2025 Cip Tools. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
