<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace | {{ strtoupper(tenant('id')) }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #06b6d4 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(6, 182, 212, 0.08) 100%);
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(99, 102, 241, 0.15);
        }
        
        .feature-card {
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%);
            transform: translate(40%, -40%);
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    <nav class="glass-card border-b border-gray-200 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="h-9 w-9 rounded-lg bg-gradient-to-br from-indigo-500 to-cyan-500 flex items-center justify-center shadow-md">
                        <i class="fas fa-cube text-white text-sm"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg text-gray-800 tracking-tight">
                            {{ strtoupper(tenant('id')) }}
                        </span>
                        <span class="text-xs text-gray-500 ml-1">WORKSPACE</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="#" class="hidden md:inline text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-1">
                        Features
                    </a>
                    <a href="#" class="hidden md:inline text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-1">
                        About
                    </a>
                    <a href="/login" class="text-sm font-medium bg-gradient-to-r from-indigo-600 to-indigo-500 text-white px-4 py-2 rounded-lg shadow hover:shadow-md transition-all duration-200 hover-lift">
                        <i class="fas fa-sign-in-alt mr-2"></i>Log In
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Hero Section -->
    <main class="pt-28 pb-20 min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Column - Text Content -->
                <div class="text-left">
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 mb-6">
                        <i class="fas fa-rocket mr-1.5"></i> EXCLUSIVE WORKSPACE
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-bold tracking-tight mb-6 leading-tight">
                        Welcome to
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-500 to-cyan-500 mt-2">
                            {{ strtoupper(tenant('id')) }}
                        </span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 max-w-lg">
                        A secure, collaborative environment where innovation thrives. Join your team to submit ideas, track progress, and drive meaningful change.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-12">
                        <a href="/login" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-xl shadow-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 transition-all duration-200 hover-lift pulse-animation">
                            <i class="fas fa-lock mr-3"></i>
                            Access Workspace
                        </a>
                        
                        <a href="/register" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold rounded-xl border-2 border-gray-300 text-gray-800 bg-white hover:bg-gray-50 hover:border-indigo-300 transition-all duration-200 hover-lift">
                            <i class="fas fa-user-plus mr-3"></i>
                            Create Account
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-2">
                            <div class="h-5 w-5 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <span class="text-sm text-gray-600">Secure Access</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="h-5 w-5 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-shield-alt text-blue-600 text-xs"></i>
                            </div>
                            <span class="text-sm text-gray-600">Team Collaboration</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="h-5 w-5 rounded-full bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-lightbulb text-purple-600 text-xs"></i>
                            </div>
                            <span class="text-sm text-gray-600">Innovation Hub</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Visual/Illustration -->
                <div class="relative">
                    <div class="glass-card rounded-2xl p-8 hero-gradient border border-gray-100">
                        <!-- Floating elements for visual interest -->
                        <div class="absolute top-6 right-10 h-16 w-16 rounded-full bg-gradient-to-br from-cyan-500 to-blue-500 opacity-20 floating"></div>
                        <div class="absolute bottom-10 left-8 h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 opacity-20 floating" style="animation-delay: 1s;"></div>
                        
                        <div class="text-center mb-8">
                            <div class="h-24 w-24 rounded-2xl bg-gradient-to-br from-indigo-500 to-cyan-500 mx-auto flex items-center justify-center shadow-xl mb-6">
                                <i class="fas fa-cubes text-white text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Exclusive Workspace</h3>
                            <p class="text-gray-600">Private domain access only</p>
                        </div>
                        
                        <!-- Feature List -->
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                                <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center mr-4">
                                    <i class="fas fa-users text-indigo-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Team Collaboration</p>
                                    <p class="text-sm text-gray-500">Work securely with your team</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                                <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center mr-4">
                                    <i class="fas fa-lightbulb text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Idea Submission</p>
                                    <p class="text-sm text-gray-500">Share and track innovative ideas</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                                <div class="h-10 w-10 rounded-lg bg-green-50 flex items-center justify-center mr-4">
                                    <i class="fas fa-chart-line text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Progress Tracking</p>
                                    <p class="text-sm text-gray-500">Monitor project development</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose This Workspace?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    A dedicated environment designed for secure collaboration and innovation.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass-card p-6 rounded-2xl feature-card hover-lift">
                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center mb-6 shadow-md">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Secure & Private</h3>
                    <p class="text-gray-600">
                        Your workspace is isolated and accessible only to registered team members with proper authentication.
                    </p>
                </div>
                
                <div class="glass-card p-6 rounded-2xl feature-card hover-lift">
                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center mb-6 shadow-md">
                        <i class="fas fa-brain text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Idea Management</h3>
                    <p class="text-gray-600">
                        Submit, discuss, and track innovative ideas in a structured environment designed for creativity.
                    </p>
                </div>
                
                <div class="glass-card p-6 rounded-2xl feature-card hover-lift">
                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center mb-6 shadow-md">
                        <i class="fas fa-chart-network text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Team Collaboration</h3>
                    <p class="text-gray-600">
                        Work together seamlessly with your team members in a purpose-built collaborative space.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="glass-card rounded-2xl p-12 border border-gray-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Ready to Innovate?</h2>
                <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                    Join your team in {{ strtoupper(tenant('id')) }} workspace and start contributing to meaningful projects today.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/login" class="inline-flex items-center justify-center px-10 py-4 text-lg font-semibold rounded-xl shadow-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 transition-all duration-200 hover-lift">
                        <i class="fas fa-sign-in-alt mr-3"></i>
                        Access Workspace
                    </a>
                    
                    <a href="/register" class="inline-flex items-center justify-center px-10 py-4 text-lg font-semibold rounded-xl border-2 border-indigo-200 text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-all duration-200 hover-lift">
                        <i class="fas fa-user-plus mr-3"></i>
                        Register New Account
                    </a>
                </div>
                
                <p class="mt-10 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1.5"></i>
                    Access is restricted to registered users of the {{ strtoupper(tenant('id')) }} domain.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-indigo-500 to-cyan-500 flex items-center justify-center">
                        <i class="fas fa-cube text-white text-sm"></i>
                    </div>
                    <div>
                        <span class="font-bold text-gray-800">{{ strtoupper(tenant('id')) }}</span>
                        <span class="text-xs text-gray-500 ml-1">Workspace</span>
                    </div>
                </div>
                
                <div class="text-sm text-gray-500">
                    &copy; 2023 {{ strtoupper(tenant('id')) }} Workspace. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Simple hover effect enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const hoverElements = document.querySelectorAll('.hover-lift');
            hoverElements.forEach(el => {
                el.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s ease';
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
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observe feature cards
            document.querySelectorAll('.feature-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>