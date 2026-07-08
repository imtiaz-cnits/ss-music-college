@extends('tyro-dashboard::layouts.admin')
@section('title', 'Dashboard')

@section('breadcrumb')
<span>Dashboard</span>
@endsection

@section('content')

@php
$totalNotices = \App\Models\Notice::count();
$totalEvents = \App\Models\Event::count();
$recentNotices = \App\Models\Notice::orderBy('date', 'desc')->orderBy('id', 'desc')->take(5)->get();
$recentEvents = \App\Models\Event::latest()->take(5)->get();
@endphp

<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Welcome back, {{ auth()->user()->name ?? 'Admin' }}!</h1>
            <p class="page-description">Here's a quick overview of your college application.</p>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">

    <!-- Total Notices Card -->
    <a href="{{ route('notices.index') }}" style="text-decoration: none; color: inherit; display: block;">
        <div class="stat-card" style="cursor: pointer;">
            <div class="stat-icon stat-icon-info">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
            </div>
            <div class="stat-label">Total Notices</div>
            <div class="stat-value">{{ $totalNotices }}</div>
        </div>
    </a>

    <!-- Total Events Card -->
    <a href="{{ route('dashboard.events.index') }}" style="text-decoration: none; color: inherit; display: block;">
        <div class="stat-card" style="cursor: pointer;">
            <div class="stat-icon stat-icon-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="stat-label">Total Events</div>
            <div class="stat-value">{{ $totalEvents }}</div>
        </div>
    </a>

</div>

<!-- Recent Items Grid -->
<div class="grid-2">

    <!-- Recent Notices Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Notices</h3>
            <a href="{{ route('notices.index') }}" class="form-link" style="font-size: 0.875rem;">View All</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <tbody>
                        @forelse($recentNotices as $notice)
                        <tr>
                            <td>
                                <div class="user-cell-name">{{ Str::limit($notice->title, 50) }}</div>
                                <div class="user-cell-email">{{ \Carbon\Carbon::parse($notice->date)->translatedFormat('d F, Y') }}</div>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge badge-success">Published</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align: center; padding: 2rem; color: var(--muted-foreground);">কোনো নোটিশ পাওয়া যায়নি</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Events Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Events</h3>
            <a href="{{ route('dashboard.events.index') }}" class="form-link" style="font-size: 0.875rem;">View All</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-container">
                <table class="table">
                    <tbody>
                        @forelse($recentEvents as $event)
                        <tr>
                            <td>
                                <div class="user-cell-name">{{ Str::limit($event->title, 50) }}</div>
                                <div class="user-cell-email">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F, Y') }}</div>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge badge-primary">Active</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align: center; padding: 2rem; color: var(--muted-foreground);">কোনো ইভেন্ট পাওয়া যায়নি</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection