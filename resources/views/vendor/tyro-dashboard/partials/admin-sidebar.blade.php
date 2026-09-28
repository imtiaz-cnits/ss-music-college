<aside class="sidebar flex flex-col" id="sidebar" style="display: flex; flex-direction: column;">
    <div class="sidebar-header">
        <a href="{{ route($dashboardRoute::name('index')) }}" class="sidebar-logo">
            <div class="sidebar-logo-icon" style="background: transparent; padding: 0;">
                <img src="{{ asset('assets/image/logo.png') }}" alt="SS Music College Logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <span class="sidebar-logo-text">
                SS Music College
            </span>
        </a>
        <button type="button" class="mobile-sidebar-close-btn" onclick="toggleSidebar()" aria-label="Close sidebar" style="background: transparent; border: none; color: var(--sidebar-foreground, var(--muted-foreground)); cursor: pointer; padding: 0.375rem; border-radius: 6px; display: none; align-items: center; justify-content: center; transition: all 0.15s ease; flex-shrink: 0; margin-left: auto;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="sidebar-nav sidebar-accordion"
        data-sidebar-accordion
        data-sidebar-accordion-compact="{{ config('tyro-dashboard.branding.sidebar_accordion_compact', false) ? 'true' : 'false' }}" style="flex-grow: 1;">

        <div class="sidebar-section">
            <div class="sidebar-section-title">Menu</div>

            <a href="{{ route($dashboardRoute::name('index')) }}" class="sidebar-link {{ request()->routeIs($dashboardRoute::pattern('index')) ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route($dashboardRoute::name('profile')) }}" class="sidebar-link {{ request()->routeIs($dashboardRoute::pattern('profile*')) ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                My Profile
            </a>

            @if(!empty($commonMenuItems))
            @foreach($commonMenuItems as $item)
            <a href="{{ route($item['route'] ?? '#') }}" class="sidebar-link {{ request()->routeIs($item['route'] ?? '') ? 'active' : '' }}">
                @if(isset($item['icon']))
                {!! $item['icon'] !!}
                @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                @endif
                {{ $item['title'] ?? 'Menu Item' }}
            </a>
            @endforeach
            @endif

            @if(!empty($userMenuItems))
            @foreach($userMenuItems as $item)
            <a href="{{ route($item['route'] ?? '#') }}" class="sidebar-link {{ request()->routeIs($item['route'] ?? '') ? 'active' : '' }}">
                @if(isset($item['icon']))
                {!! $item['icon'] !!}
                @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                @endif
                {{ $item['title'] ?? 'Menu Item' }}
            </a>
            @endforeach
            @endif
        </div>

        {{-- Our College Dropdown --}}
        <div class="sidebar-section">
            <div class="sidebar-section-title">Our College</div>

            <a href="{{ route('notices.index') }}" class="sidebar-link {{ request()->routeIs('notices.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                Notice Management
            </a>

            <a href="{{ route('dashboard.events.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.events.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Event Management
            </a>

            <a href="{{ route('dashboard.governing-body-approval.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.governing-body-approval.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Governing Body Approval
            </a>

            <a href="{{ route('dashboard.accreditation-renewal.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.accreditation-renewal.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Accreditation Renewal
            </a>

            <a href="{{ route('dashboard.acceptance-renewal.index') }}" class="sidebar-link {{ request()->routeIs('dashboard.acceptance-renewal.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Acceptance Renewal
            </a>
        </div>

        {{-- Students Dropdown --}}
        <div class="sidebar-section">
            <div class="sidebar-section-title">Students</div>

            <a href="{{ route('dashboard.students.index') }}" class="sidebar-link {{ request()->is('*/students*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.22 4 2.22V20" />
                </svg>
                Students Lists
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Administration</div>
            <a href="{{ route($dashboardRoute::name('users.index')) }}" class="sidebar-link {{ request()->routeIs($dashboardRoute::pattern('users.*')) ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Users
            </a>
            <a href="{{ route($dashboardRoute::name('roles.index')) }}" class="sidebar-link {{ request()->routeIs($dashboardRoute::pattern('roles.*')) ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Roles
            </a>
            <a href="{{ route($dashboardRoute::name('privileges.index')) }}" class="sidebar-link {{ request()->routeIs($dashboardRoute::pattern('privileges.*')) ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                Privileges
            </a>

            @if(!empty($adminMenuItems))
            @foreach($adminMenuItems as $item)
            <a href="{{ route($item['route'] ?? '#') }}" class="sidebar-link {{ request()->routeIs($item['route'] ?? '') ? 'active' : '' }}">
                @if(isset($item['icon']))
                {!! $item['icon'] !!}
                @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                @endif
                {{ $item['title'] ?? 'Menu Item' }}
            </a>
            @endforeach
            @endif
        </div>

        @if(!empty($allResources ?? config('tyro-dashboard.resources')))
        <div class="sidebar-section">
            <div class="sidebar-section-title">Resources</div>
            @foreach($allResources ?? config('tyro-dashboard.resources', []) as $key => $resource)
            @php
            // Check access (logic duplicated from Controller for view)
            $canAccess = true;
            if (isset($resource['roles']) && !empty($resource['roles'])) {
            $canAccess = false;
            $user = auth()->user();
            if ($user && method_exists($user, 'tyroRoleSlugs')) {
            $userRoles = $user->tyroRoleSlugs();
            // Check allowed roles
            foreach ($resource['roles'] as $role) {
            if (in_array($role, $userRoles)) {
            $canAccess = true;
            break;
            }
            }
            // Check readonly roles (if not already allowed)
            if (!$canAccess && isset($resource['readonly']) && !empty($resource['readonly'])) {
            foreach ($resource['readonly'] as $role) {
            if (in_array($role, $userRoles)) {
            $canAccess = true;
            break;
            }
            }
            }
            }
            }
            @endphp

            @if($canAccess)
            <a href="{{ route($dashboardRoute::name('resources.index'), $key) }}" class="sidebar-link {{ request()->is('*resources/'.$key.'*') ? 'active' : '' }}">
                @if(isset($resource['icon']))
                {!! $resource['icon'] !!}
                @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                @endif
                {{ $resource['title'] }}
            </a>
            @endif
            @endforeach
        </div>
        @endif
    </nav>

    <!-- Logout Button Placed at the Bottom -->
    <div class="sidebar-section" style="margin-top: auto; padding: 0rem 0.5rem; border-top: 1px solid var(--sidebar-border); margin-bottom: 0;">
        <form action="{{ route('tyro-login.logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="sidebar-link" style="width: 100%; text-align: left; background: transparent; border: none; cursor: pointer; color: #ef4444; padding: 1rem 0.5rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>