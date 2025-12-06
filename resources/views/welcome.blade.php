<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cip Tools - Modern Project Management Platform</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'gradient': 'gradient 8s ease infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        gradient: {
                            '0%, 100%': { backgroundPosition: '0% 50%' },
                            '50%': { backgroundPosition: '100% 50%' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient 8s ease infinite;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }

        .feature-card {
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.25);
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            z-index: -1;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #6366f1, transparent);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-white text-gray-600 font-sans antialiased overflow-x-hidden">

    @php
        $staticPages = App\Models\StaticPage::where('is_published', true)->orderBy('title')->get();
    @endphp

    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob w-96 h-96 bg-purple-300 top-20 left-10 animate-float"></div>
        <div class="blob w-80 h-80 bg-blue-300 bottom-40 right-10 animate-float" style="animation-delay: 2s;"></div>
        <div class="blob w-64 h-64 bg-indigo-300 top-1/2 left-1/2 animate-float" style="animation-delay: 4s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="glass-card border-b border-gray-200/60 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-primary-600 to-purple-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
                        <span class="text-white font-bold text-lg">C</span>
                    </div>
                    <div>
                        <span class="font-bold text-xl text-gray-900 tracking-tight">Cip Tools</span>
                        <span class="block text-xs text-gray-500">Innovation Platform</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    @foreach($staticPages as $page)
                        <a href="/{{ $page->slug }}"
                           class="text-sm font-medium transition-all duration-200 px-3 py-2 rounded-lg hover:text-primary-600 hover:bg-gray-50">
                            {{ $page->title }}
                        </a>
                    @endforeach

                    <a href="/admin/login"
                       class="bg-gradient-to-r from-primary-600 to-primary-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/40 hover:from-primary-700 hover:to-primary-600 flex items-center gap-2">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 lg:pt-40 lg:pb-28 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 lg:gap-8 items-center">

                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-primary-50 to-blue-50 border border-primary-100 text-primary-700 text-xs font-semibold mb-8 animate-pulse-slow">
                        <span class="w-2 h-2 rounded-full bg-primary-600"></span>
                        New: Multi-Tenant Architecture
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-8">
                        Manage Projects in
                        <span class="block mt-2 gradient-text">Your Own Private Space.</span>
                    </h1>

                    <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Get a dedicated subdomain for your team. Isolated database, secure environment, and powerful project management tools.
                    </p>

                    <!-- Trust Badges -->
                    <div class="flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start mb-10">
                        <div class="flex items-center gap-3 text-sm">
                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">30 Days Free Trial</p>
                                <p class="text-gray-500">No commitment required</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-sm">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-shield-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">No Credit Card</p>
                                <p class="text-gray-500">Start instantly, upgrade later</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Registration Form -->
                <div class="relative">
                    <div class="glass-card rounded-2xl p-8 border border-gray-200/60 hover-lift">
                        <div class="text-center mb-8">
                            <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-primary-600 to-purple-600 flex items-center justify-center mx-auto mb-4 shadow-xl">
                                <i class="fas fa-rocket text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Launch Your Workspace</h3>
                            <p class="text-gray-600 mt-2">Start your 30-day free trial in seconds</p>
                        </div>

                        <!-- Registration Component -->
                        <div class="transform transition-all duration-300 hover:scale-[1.01]">
                            <livewire:register-tenant />
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute -top-6 -right-6 h-12 w-12 rounded-full bg-gradient-to-r from-primary-500 to-blue-500 opacity-20 animate-float"></div>
                    <div class="absolute -bottom-6 -left-6 h-16 w-16 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 opacity-20 animate-float" style="animation-delay: 2s;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="section-divider"></div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-primary-50 to-purple-50 border border-primary-100 text-primary-700 text-sm font-semibold mb-6">
                    <i class="fas fa-star"></i>
                    Why Choose Cip Tools
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Everything You Need to
                    <span class="gradient-text">Innovate & Collaborate</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    A complete platform designed for modern teams to manage projects, share ideas, and drive innovation.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card glass-card p-8 rounded-2xl border border-gray-200/60">
                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-database text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Isolated Database</h3>
                    <p class="text-gray-600 mb-6">
                        Every tenant gets their own completely isolated database. Your data is strictly separated from others for maximum security and privacy.
                    </p>
                    <div class="flex items-center gap-2 text-sm text-primary-600 font-semibold">
                        <i class="fas fa-lock"></i>
                        Enterprise-grade Security
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card glass-card p-8 rounded-2xl border border-gray-200/60">
                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-globe text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Custom Subdomains</h3>
                    <p class="text-gray-600 mb-6">
                        Get your own branding with <code class="bg-gray-100 px-2 py-1 rounded">company.cip-tools.de</code>. Easy, memorable access for all your team members.
                    </p>
                    <div class="flex items-center gap-2 text-sm text-purple-600 font-semibold">
                        <i class="fas fa-bolt"></i>
                        Instant Setup
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card glass-card p-8 rounded-2xl border border-gray-200/60">
                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-bolt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">High Performance</h3>
                    <p class="text-gray-600 mb-6">
                        Built on latest Laravel technology with real-time capabilities. Experience blazing fast speeds and seamless collaboration.
                    </p>
                    <div class="flex items-center gap-2 text-sm text-blue-600 font-semibold">
                        <i class="fas fa-rocket"></i>
                        Blazing Fast
                    </div>
                </div>
            </div>

            <!-- Additional Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
                <div class="p-6 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200 text-center">
                    <i class="fas fa-users text-primary-600 text-3xl mb-4"></i>
                    <p class="font-semibold text-gray-900">Team Collaboration</p>
                </div>
                <div class="p-6 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200 text-center">
                    <i class="fas fa-chart-line text-purple-600 text-3xl mb-4"></i>
                    <p class="font-semibold text-gray-900">Analytics Dashboard</p>
                </div>
                <div class="p-6 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200 text-center">
                    <i class="fas fa-mobile-alt text-blue-600 text-3xl mb-4"></i>
                    <p class="font-semibold text-gray-900">Mobile Ready</p>
                </div>
                <div class="p-6 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200 text-center">
                    <i class="fas fa-headset text-green-600 text-3xl mb-4"></i>
                    <p class="font-semibold text-gray-900">24/7 Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gradient-to-br from-primary-900 to-primary-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-4xl font-bold mb-2">500+</p>
                    <p class="text-primary-200">Active Workspaces</p>
                </div>
                <div>
                    <p class="text-4xl font-bold mb-2">10K+</p>
                    <p class="text-primary-200">Projects Managed</p>
                </div>
                <div>
                    <p class="text-4xl font-bold mb-2">99.9%</p>
                    <p class="text-primary-200">Uptime SLA</p>
                </div>
                <div>
                    <p class="text-4xl font-bold mb-2">24/7</p>
                    <p class="text-primary-200">Customer Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 to-gray-800 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-primary-600 to-purple-600 flex items-center justify-center">
                            <span class="text-white font-bold">C</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg">Cip Tools</h3>
                            <p class="text-sm text-gray-400">Innovation Platform</p>
                        </div>
                    </div>
                    <p class="text-sm">
                        Empowering teams to innovate, collaborate, and transform ideas into reality.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        @foreach($staticPages->take(4) as $page)
                            <li><a href="/{{ $page->slug }}" class="hover:text-white transition">{{ $page->title }}</a></li>
                        @endforeach
                        <li><a href="/admin/login" class="hover:text-white transition">Admin Login</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="/privacy" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="/terms" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="/cookies" class="hover:text-white transition">Cookie Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Contact</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-primary-400"></i>
                            support@cip-tools.com
                        </li>
                    </ul>
                    <div class="flex gap-3 mt-4">
                        <a href="#" class="h-10 w-10 rounded-lg bg-gray-800 hover:bg-gray-700 flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="h-10 w-10 rounded-lg bg-gray-800 hover:bg-gray-700 flex items-center justify-center transition">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="h-10 w-10 rounded-lg bg-gray-800 hover:bg-gray-700 flex items-center justify-center transition">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="pt-8 border-t border-gray-800 text-center">
                <p>&copy; 2025 Cip Tools. All rights reserved.</p>
                <p class="text-sm mt-2 text-gray-500">Building the future of innovation, one idea at a time.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-8 right-8 h-12 w-12 rounded-full bg-gradient-to-r from-primary-600 to-primary-500 text-white shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center justify-center hover:scale-110 hover-lift">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Mobile menu toggle
        document.querySelector('button.md\\:hidden')?.addEventListener('click', function() {
            const nav = document.querySelector('.hidden.md\\:flex');
            if (nav) {
                nav.classList.toggle('hidden');
                nav.classList.toggle('flex');
                nav.classList.toggle('flex-col');
                nav.classList.toggle('absolute');
                nav.classList.toggle('top-20');
                nav.classList.toggle('left-0');
                nav.classList.toggle('right-0');
                nav.classList.toggle('bg-white');
                nav.classList.toggle('p-6');
                nav.classList.toggle('shadow-xl');
                nav.classList.toggle('z-40');
                nav.classList.toggle('border-b');
                nav.classList.toggle('border-gray-200');
            }
        });

        // Smooth scrolling for anchor links
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

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>
