<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} | {{ tenant('id') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #f9fafb 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.25); box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08); }
        .gradient-header { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); }
        @media (max-width: 1024px) { .sidebar-toggle { display: block !important; } .mobile-hidden { display: none; } }
    </style>
</head>
<body class="antialiased min-h-screen">
    
    <button onclick="document.querySelector('aside').classList.toggle('hidden');" class="sidebar-toggle fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-md lg:hidden">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <div class="flex min-h-screen">
        
        @include('components.partials.sidebar-nav')

        <div class="flex-1 flex flex-col">
            
            @include('components.partials.top-header')

            <main class="flex-1 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    
    <script>
        document.querySelector('.sidebar-toggle')?.addEventListener('click', function() {
             const sidebar = document.querySelector('aside');
             sidebar.classList.toggle('hidden');
             sidebar.classList.toggle('flex');
             sidebar.classList.toggle('fixed');
             sidebar.classList.toggle('inset-0');
             sidebar.classList.toggle('z-40');
        });
        document.addEventListener('click', function(event) {
             const sidebar = document.querySelector('aside');
             const toggleBtn = document.querySelector('.sidebar-toggle');
             
             if (window.innerWidth < 1024 && sidebar && sidebar.classList.contains('fixed') && !sidebar.contains(event.target) && toggleBtn && !toggleBtn.contains(event.target)) {
                 sidebar.classList.add('hidden');
                 sidebar.classList.remove('flex');
             }
        });
    </script>
</body>
</html>