<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? 'Static Page' }} | Cip-Tools</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Custom Tailwind Configuration (Ensure this matches welcome.blade.php) */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        .content-body h1 { font-size: 2.25rem; font-weight: 800; margin-top: 2rem; margin-bottom: 0.75rem; color: #1e293b; }
        .content-body h2 { font-size: 1.5rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.5rem; color: #334155; }
        .content-body p { margin-bottom: 1.5rem; line-height: 1.7; color: #475569; }
        .content-body ul { list-style: disc; margin-left: 1.75rem; margin-bottom: 1rem; color: #475569; }
        .content-body a { color: #4f46e5; text-decoration: underline; font-weight: 500; }
        .content-body strong { font-weight: 700; color: #1e293b; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="antialiased">

    @php
        // Assuming App\Models\StaticPage is imported in the controller
        $staticPages = App\Models\StaticPage::where('is_published', true)->orderBy('title')->get();
        // Define the colors for nav buttons
        $primaryColor = '#4F46E5';
    @endphp

    <nav class="bg-white shadow-lg border-b border-gray-200 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div style="background-color: {{ $primaryColor }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-lg">C</div>
                    <span class="font-bold text-xl text-slate-900 tracking-tight">Cip Tools</span>
                </div>

                <div class="hidden md:flex items-center space-x-6">

                    {{-- Loop through all published static pages for navigation --}}
                    @foreach($staticPages as $p)
                        {{-- Current page is highlighted --}}
                        <a href="/{{ $p->slug }}" class="text-sm font-medium transition
                           @if($p->slug === ($page->slug ?? '')) text-indigo-600 font-semibold @else text-slate-600 hover:text-indigo-600 @endif">
                            {{ $p->title }}
                        </a>
                    @endforeach

                    <a href="/admin/login" class="text-sm font-medium text-slate-900 hover:text-indigo-600 transition">Admin Login</a>
                    <a href="/" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md shadow-indigo-200">
                        Go to Home
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-16 pt-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-2xl border border-gray-100 hover-lift transition-all duration-300">

                <h1 class="text-4xl font-extrabold text-slate-900 mb-6 border-b pb-3">
                    {{ $page->title ?? 'Page Not Found' }}
                </h1>

                <div class="content-body text-gray-700">
                    {!! $page->body ?? '<p class="italic text-red-500">Content has not been published yet.</p>' !!}
                </div>

                <div class="mt-10 border-t pt-4 text-left">
                    <p class="text-sm text-gray-500">
                        Last updated: {{ $page->updated_at->format('F d, Y') ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2025 Cip Tools. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
