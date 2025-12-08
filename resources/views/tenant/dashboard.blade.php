@extends('components.layouts.tenant-app-layout', ['title' => 'Project Overview'])

{{-- Layout Title set: Project Overview | [Tenant ID] --}}
{{-- Full HTML structure and Navigation is now handled by tenant-app-layout.blade.php --}}

@section('content')

    @php
        // ZAROORI IMPORTS
        use App\Models\ProjectIdea; // ProjectIdea Model import karein

        // Tenant record retrieval
        $currentTenant = \App\Models\Tenant::find(tenant('id'));
        $loggedInUser = auth()->user();

        // 1. Calculate Days Remaining
        $trialEndDate = $currentTenant->trial_ends_at;
        $hoursRemaining = $trialEndDate ? now()->diffInHours($trialEndDate, false) : 0;
        $cleanDaysRemaining = $hoursRemaining > 0 ? ceil($hoursRemaining / 24) : 0;

        // 2. Status Determination Logic (Omitted for brevity)
        if ($currentTenant->plan_status === 'active') {
            $statusText = 'ACTIVE';
            $statusColor = 'bg-green-100 text-green-800';
            $remainingText = ($trialEndDate === null) ? 'Lifetime Access' : ($cleanDaysRemaining . ' days remaining');
        } elseif ($cleanDaysRemaining > 0) {
            $statusText = 'TRIAL';
            $statusColor = 'bg-orange-100 text-orange-800';
            $remainingText = $cleanDaysRemaining . ' days remaining';
        } else {
            $statusText = 'EXPIRED';
            $statusColor = 'bg-red-100 text-red-800';
            $remainingText = 'Access Blocked';
        }

        // 3. Stats and Branding
        $totalUsers = \App\Models\TenantUser::where('tenant_id', tenant('id'))->count();
        $slogan = ($currentTenant->plan_status === 'active') ? ($currentTenant->slogan ?? 'Thought together and made together.') : 'Upgrade required to customize your branding.';
        $incentive = ($currentTenant->plan_status === 'active') ? ($currentTenant->incentive_text ?? 'Please specify remuneration.') : 'Configuration is currently locked. Upgrade required.';

        // CRITICAL FIX: DYNAMIC IDEA COUNT CALCULATION
        $activeTeamId = session('active_team_id'); // Session se active team ID lo

        $totalIdeasCount = ProjectIdea::query()
            // Tenant ID filter (Safety check)
            ->where('tenant_id', tenant('id'))

            // IMPORTANT: Apply Team Scoping ONLY if an active team is selected
            ->when($activeTeamId, function ($query, $teamId) {
                // Ensure the user is not trying to scope by a non-existent team ID
                if ($teamId) {
                    $query->where('team_id', $teamId);
                }
            })

            ->count();
        // Fallback for display
        $ideasDisplayCount = ($totalIdeasCount > 0) ? $totalIdeasCount : 0;

    @endphp

    <div class="space-y-8">

        <div class="gradient-header text-white p-6 md:p-10 rounded-xl shadow-xl hover-lift relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
            <div class="relative z-10">
                <h2 class="text-2xl md:text-3xl font-bold tracking-tight mb-2">
                    <i class="fas fa-quote-left mr-1"></i> {{ $slogan }}
                </h2>
                <p class="text-indigo-100 text-lg opacity-90">
                    Project ID: {{ strtoupper(tenant('id')) }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="glass-card p-6 rounded-2xl stat-card hover-lift">
                <p class="text-sm font-medium text-gray-500 mb-2">Total Collaborators</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>

            <div class="glass-card p-6 rounded-2xl stat-card hover-lift">
                <p class="text-sm font-medium text-gray-500 mb-2">Subscription Status</p>
                <span class="status-badge {{ $statusColor }} mt-2">{{ $statusText }}</span>
                <p class="text-md text-gray-700 mt-4 font-semibold">{{ $remainingText }}</p>
            </div>

            <div class="glass-card p-6 rounded-2xl stat-card hover-lift">
                <p class="text-sm font-medium text-gray-500 mb-2">Project Ideas</p>
                {{-- DISPLAY FIXED COUNT --}}
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $ideasDisplayCount }}</p>
            </div>

            <a href="{{ route('tenant.users.manage') }}" class="glass-card p-6 rounded-2xl flex flex-col justify-center items-center bg-gradient-to-r from-indigo-500 to-indigo-600 text-white hover-lift transition-all duration-300">
                <div class="h-12 w-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center mb-2">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <p class="font-semibold text-lg">Manage Team</p>
                <p class="text-sm opacity-90 mt-1">Add or remove members</p>
            </a>
        </div>

        <div class="glass-card p-6 rounded-2xl border-l-4 border-yellow-500 shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Proposer Incentive & Liability</h3>
            <p class="text-gray-700">
                <strong class="font-medium">Incentive:</strong> {{ $incentive }}
            </p>
            <div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100">
                <p class="text-sm text-red-700">
                    <i class="fas fa-info-circle mr-1"></i>
                    <strong>Note:</strong> The bonus is not provided by Cip-Tools.com but by the project manager. The project manager is fully liable for it.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            <a href="/settings" class="glass-card p-5 rounded-xl flex items-center gap-3 hover:border-indigo-300 hover-lift">
                <div class="h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center"><i class="fas fa-cog text-indigo-600"></i></div>
                <p class="font-medium text-gray-800">Project Settings</p>
            </a>
            <a href="{{ route('tenant.billing') }}" class="glass-card p-5 rounded-xl flex items-center gap-3 hover:border-indigo-300 hover-lift">
                <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center"><i class="fas fa-credit-card text-blue-600"></i></div>
                <p class="font-medium text-gray-800">Billing & Plan</p>
            </a>
            <a href="/reports" class="glass-card p-5 rounded-xl flex items-center gap-3 hover:border-indigo-300 hover-lift">
                <div class="h-10 w-10 rounded-lg bg-green-50 flex items-center justify-center"><i class="fas fa-chart-line text-green-600"></i></div>
                <p class="font-medium text-gray-800">View Reports</p>
            </a>
            <a href="/pipeline" class="glass-card p-5 rounded-xl flex items-center gap-3 hover:border-indigo-300 hover-lift">
                <div class="h-10 w-10 rounded-lg bg-purple-50 flex items-center justify-center"><i class="fas fa-search text-purple-600"></i></div>
                <p class="font-medium text-gray-800">Innovation Pipeline</p>
            </a>
        </div>

    </div>
@endsection
