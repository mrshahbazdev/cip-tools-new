<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? 'Static Page' }} | Cip-Tools</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Modern, subtle background gradient */
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        /* Advanced Typography for RichEditor Content */
        .content-body h1 { font-size: 2.25rem; font-weight: 800; margin-top: 2rem; margin-bottom: 0.75rem; color: #1e293b; }
        .content-body h2 { font-size: 1.5rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.5rem; color: #334155; }
        .content-body p { margin-bottom: 1.5rem; line-height: 1.7; color: #475569; }
        .content-body ul { list-style: disc; margin-left: 1.75rem; margin-bottom: 1rem; color: #475569; }
        .content-body a { color: #4f46e5; text-decoration: underline; font-weight: 500; }
        .content-body strong { font-weight: 700; color: #1e293b; }
    </style>
</head>
<body class="antialiased">

    <header class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="font-extrabold text-xl text-indigo-600 tracking-tight flex items-center gap-2">
                <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">C</div>
                Cip-Tools.com
            </a>
            <a href="/" class="text-sm font-semibold text-gray-700 hover:text-indigo-700 transition">
                &larr; Back to Home
            </a>
        </div>
    </header>

    <main class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-2xl border border-gray-100 hover-lift transition-all duration-300">

                <h1 class="text-4xl font-extrabold text-slate-900 mb-6 border-b pb-3">
                    {{ $page->title ?? 'Page Not Found' }}
                </h1>

                <div class="content-body text-gray-700">
                    {!! $page->body ?? '<p class="italic text-red-500">Content has not been published yet. Please contact the Super Administrator.</p>' !!}
                </div>

                <div class="mt-10 border-t pt-4 text-left">
                    <p class="text-sm text-gray-500">
                        Last updated: {{ $page->updated_at->format('F d, Y') ?? 'N/A' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Page Slug: <code>/{{ $page->slug ?? 'n/a' }}</code>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-6 text-sm text-slate-500">
        &copy; 2025 Cip Tools. All rights reserved.
    </footer>

</body>
</html>
