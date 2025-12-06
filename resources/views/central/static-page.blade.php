<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title ?? 'Static Page' }} | Cip-Tools</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .content-body {
            width: 100%;
            max-width: 100%;
            line-height: 1.8;
            color: #4b5563;
        }

        .content-body h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
            color: #1f2937;
            line-height: 1.3;
        }

        .content-body h2 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            color: #374151;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .content-body h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #4b5563;
        }

        .content-body p {
            margin-bottom: 1.5rem;
            font-size: 1.125rem;
            line-height: 1.8;
            color: #4b5563;
        }

        .content-body ul, .content-body ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .content-body ul {
            list-style-type: disc;
        }

        .content-body ol {
            list-style-type: decimal;
        }

        .content-body li {
            margin-bottom: 0.75rem;
            font-size: 1.125rem;
            line-height: 1.7;
        }

        .content-body a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 2px solid #c7d2fe;
            transition: all 0.2s ease;
        }

        .content-body a:hover {
            color: #4338ca;
            border-bottom-color: #4f46e5;
        }

        .content-body strong {
            font-weight: 700;
            color: #1f2937;
        }

        .content-body em {
            font-style: italic;
            color: #6b7280;
        }

        .content-body blockquote {
            border-left: 4px solid #4f46e5;
            padding-left: 1.5rem;
            margin: 2rem 0;
            color: #6b7280;
            font-style: italic;
        }

        .content-body code {
            background-color: #f3f4f6;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-family: 'Monaco', 'Courier New', monospace;
            font-size: 0.875rem;
            color: #dc2626;
        }

        .content-body pre {
            background-color: #1f2937;
            color: #e5e7eb;
            padding: 1.5rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1.5rem 0;
        }

        .content-body img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 2rem 0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .content-body table {
            width: 100%;
            margin: 2rem 0;
            border-collapse: collapse;
        }

        .content-body table th {
            background-color: #f9fafb;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        .content-body table td {
            padding: 1rem;
            border: 1px solid #e5e7eb;
        }

        .content-body table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.15);
        }

        .footer-sticky {
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .content-body h1 {
                font-size: 2rem;
            }

            .content-body h2 {
                font-size: 1.5rem;
            }

            .content-body p {
                font-size: 1rem;
            }

            .content-body {
                padding: 0 0.5rem;
            }
        }
    </style>
</head>
<body class="antialiased">

    @php
        $staticPages = App\Models\StaticPage::where('is_published', true)->orderBy('title')->get();
        $primaryColor = '#4F46E5';
    @endphp

    <!-- Navigation -->
    <nav class="glass-card border-b border-gray-200/60 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-200">
                        <span class="text-white font-bold text-lg">C</span>
                    </div>
                    <div>
                        <span class="font-bold text-xl text-gray-900 tracking-tight">Cip Tools</span>
                        <span class="block text-xs text-gray-500">Innovation Platform</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    @foreach($staticPages as $p)
                        <a href="/{{ $p->slug }}"
                           class="text-sm font-medium transition-all duration-200 px-3 py-2 rounded-lg
                           @if($p->slug === ($page->slug ?? ''))
                               bg-gradient-to-r from-indigo-50 to-indigo-100 text-indigo-700 font-semibold
                           @else
                               text-gray-600 hover:text-indigo-600 hover:bg-gray-50
                           @endif">
                            {{ $p->title }}
                        </a>
                    @endforeach

                    <a href="/admin/login" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition px-3 py-2">
                        Admin Login
                    </a>

                    <a href="/" class="bg-gradient-to-r from-indigo-600 to-indigo-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-300 shadow-md hover:shadow-lg hover:from-indigo-700 hover:to-indigo-600 flex items-center gap-2">
                        <i class="fas fa-home"></i>
                        Go to Home
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-16 pt-24 pb-32">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 shadow-xl mb-6">
                    <i class="fas fa-file-alt text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    <span class="gradient-text">{{ $page->title ?? 'Page Not Found' }}</span>
                </h1>
                <p class="text-gray-600 text-lg max-w-3xl mx-auto">
                    {{ $page->excerpt ?? 'Detailed information and resources' }}
                </p>
            </div>

            <!-- Content Card -->
            <div class="glass-card rounded-2xl p-8 md:p-12 border border-gray-200/60 hover-lift">
                <!-- Last Updated & Breadcrumb -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 md:mb-0">
                        <a href="/" class="hover:text-indigo-600">Home</a>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="font-medium text-gray-700">{{ $page->title ?? 'Page' }}</span>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="far fa-calendar text-indigo-500"></i>
                        <span>Last updated: {{ $page->updated_at->format('F d, Y') ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="content-body prose prose-lg max-w-none">
                    {!! $page->body ?? '<div class="text-center py-12"><i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i><p class="text-xl text-gray-600 italic">Content has not been published yet.</p></div>' !!}
                </div>

                <!-- Table of Contents (if headings exist) -->
                @if(preg_match_all('/<h[2-3][^>]*>(.*?)<\/h[2-3]>/i', $page->body ?? '', $matches))
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-list text-indigo-600"></i>
                            On This Page
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($matches[0] as $index => $heading)
                                @php
                                    $headingText = strip_tags($heading);
                                    $anchor = Str::slug($headingText);
                                @endphp
                                <a href="#{{ $anchor }}" class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="h-8 w-8 rounded-md bg-indigo-100 flex items-center justify-center">
                                        <i class="fas fa-bookmark text-indigo-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium text-gray-700">{{ $headingText }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Pages -->
                @if($staticPages->count() > 1)
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-link text-indigo-600"></i>
                            Explore More Pages
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($staticPages->where('slug', '!=', $page->slug ?? '')->take(3) as $relatedPage)
                                <a href="/{{ $relatedPage->slug }}"
                                   class="p-4 rounded-xl border border-gray-200 hover:border-indigo-300 hover:bg-gradient-to-r from-indigo-50 to-white transition-all duration-300 group">
                                    <div class="flex items-start gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                            <i class="fas fa-file-alt text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 group-hover:text-indigo-700">{{ $relatedPage->title }}</h4>
                                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ Str::limit($relatedPage->excerpt, 80) }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
    @php
        // Fetch dynamic content and static pages
        $staticPages = App\Models\StaticPage::where('is_published', true)->orderBy('title')->get();

        // Fetch settings dynamically (assuming Super Admin has populated them)
        $settings = [
            'email' => App\Models\Setting::getValue('contact_email'),
            'phone' => App\Models\Setting::getValue('contact_phone'),
            'twitter' => App\Models\Setting::getValue('social_twitter_url'),
            'linkedin' => App\Models\Setting::getValue('social_linkedin_url'),
            'github' => App\Models\Setting::getValue('social_github_url'),
        ];

        // Fallbacks if setting is not found
        $settings = array_map(fn($v) => $v ?? 'N/A', $settings);
    @endphp
    <!-- Footer -->
    <footer class="footer-sticky bg-gradient-to-br from-gray-900 to-gray-800 text-gray-400 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-white text-lg mb-4">Cip Tools</h3>
                    <p class="text-sm text-gray-400">
                        Empowering teams to innovate, collaborate, and transform ideas into reality.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-400 hover:text-white transition">Home</a></li>
                        @foreach($staticPages->take(4) as $p)
                            <li><a href="/{{ $p->slug }}" class="text-gray-400 hover:text-white transition">{{ $p->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-4">Legal & Support</h4>
                    <ul class="space-y-2">
                        <li><a href="/privacy" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="/terms" class="text-gray-400 hover:text-white transition">Terms of Service</a></li>
                        <li><a href="mailto:{{ $settings['email'] }}" class="text-gray-400 hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-4">Contact & Connect</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-indigo-400"></i>
                            <span>{{ $settings['email'] }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-indigo-400"></i>
                            <span>{{ $settings['phone'] }}</span>
                        </li>
                    </ul>
                    <div class="flex gap-3 mt-4">
                        {{-- Dynamic Social Media Icons --}}
                        @if($settings['twitter'] !== 'N/A')
                            <a href="{{ $settings['twitter'] }}" target="_blank" class="h-10 w-10 rounded-lg bg-gray-800 hover:bg-gray-700 flex items-center justify-center transition"><i class="fab fa-twitter text-gray-400"></i></a>
                        @endif
                        @if($settings['linkedin'] !== 'N/A')
                            <a href="{{ $settings['linkedin'] }}" target="_blank" class="h-10 w-10 rounded-lg bg-gray-800 hover:bg-gray-700 flex items-center justify-center transition"><i class="fab fa-linkedin text-gray-400"></i></a>
                        @endif
                        @if($settings['github'] !== 'N/A')
                            <a href="{{ $settings['github'] }}" target="_blank" class="h-10 w-10 rounded-lg bg-gray-800 hover:bg-gray-700 flex items-center justify-center transition"><i class="fab fa-github text-gray-400"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-800 text-center">
                <p>&copy; 2025 Cip Tools. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-6 right-6 h-12 w-12 rounded-full bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center hover:scale-110">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Add IDs to headings for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            const headings = document.querySelectorAll('.content-body h2, .content-body h3');
            headings.forEach((heading, index) => {
                const text = heading.textContent.trim().toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-');
                heading.id = `section-${index}-${text}`;
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Mobile menu toggle
            document.querySelector('button.md\\:hidden')?.addEventListener('click', function() {
                const nav = document.querySelector('.hidden.md\\:flex');
                if (nav) {
                    nav.classList.toggle('hidden');
                    nav.classList.toggle('flex');
                    nav.classList.toggle('flex-col');
                    nav.classList.toggle('absolute');
                    nav.classList.toggle('top-16');
                    nav.classList.toggle('left-0');
                    nav.classList.toggle('right-0');
                    nav.classList.toggle('bg-white');
                    nav.classList.toggle('p-6');
                    nav.classList.toggle('shadow-xl');
                    nav.classList.toggle('z-40');
                }
            });
        });
    </script>
</body>
</html>
