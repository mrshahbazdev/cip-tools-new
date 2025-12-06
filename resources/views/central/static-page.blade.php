<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? 'Static Page' }} | Cip-Tools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f5ffef; }
        /* Style for rendered HTML content */
        .content-body h1 { font-size: 1.875rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.5rem; }
        .content-body p { margin-bottom: 1rem; line-height: 1.6; }
        .content-body ul { list-style: disc; margin-left: 1.5rem; margin-bottom: 1rem; }
    </style>
</head>
<body class="antialiased">

    <header class="bg-white shadow-md">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <span class="font-extrabold text-xl text-indigo-600 tracking-tight">
                Cip-Tools.com
            </span>
            <a href="/" class="text-sm font-medium text-gray-600 hover:text-indigo-700 transition">
                Home
            </a>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-2xl border border-gray-200">

                <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-3">
                    {{ $page->title ?? 'Page Not Found' }}
                </h1>

                <div class="content-body text-gray-700">
                    {!! $page->body ?? '<p class="italic text-red-500">Content has not been published yet.</p>' !!}
                </div>

                <div class="mt-8 border-t pt-4">
                    <p class="text-sm text-gray-500">Last updated: {{ $page->updated_at->format('F d, Y') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
