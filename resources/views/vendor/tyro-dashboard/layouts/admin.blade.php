<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">

    <title>@yield('title', 'Dashboard') - শহীদ সাধন সঙ্গীত মহাবিদ্যালয়</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/image/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @include('tyro-dashboard::partials.styles')
    @stack('styles')
</head>

<body>
    @include('tyro-dashboard::partials.admin-bar')
    <div class="dashboard-layout">
        <!-- Admin Sidebar -->
        @include('tyro-dashboard::partials.admin-sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            @include('tyro-dashboard::partials.topbar')

            <!-- Page Content -->
            <main class="page-content">
                <!-- Flash Messages -->
                @include('tyro-dashboard::partials.flash-messages')

                @hasSection('breadcrumb')
                <nav class="breadcrumb" style="margin-bottom: 1.25rem;">
                    @yield('breadcrumb')
                </nav>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Global Modal -->
    @include('tyro-dashboard::partials.modal')

    @include('tyro-dashboard::partials.scripts')
    @stack('scripts')
</body>

</html>