@extends('tyro-dashboard::layouts.admin')
@section('title', 'Roles')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span>Roles</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Roles</h1>
            <p class="page-description">User Management & Permission</p>
        </div>
        <a href="{{ route($dashboardRoute::name('roles.create')) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 6px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            New Role
        </a>
    </div>
</div>

{{-- Filters Section --}}
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route($dashboardRoute::name('roles.index')) }}" method="GET">
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
                <div class="form-group" style="flex: 1; min-width: 250px; max-width: 450px; margin-bottom: 0;">
                      <label class="form-label">Role Search</label>
                    <input type="text" name="search" class="form-input" placeholder="Enter role name..." value="{{ $filters['search'] ?? '' }}">
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn btn-secondary">Search</button>
                    @if(!empty($filters['search']))
                        <a href="{{ route($dashboardRoute::name('roles.index')) }}" class="btn btn-ghost">মুছুন</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Roles Table --}}
<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($roles->count())
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                         <th>Role Name</th>
                        <th>Slug (Slug)</th>
                        <th style="text-align: center;">Total User</th>
                        <th style="text-align: center;">Permission Count</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>
                            <a href="{{ route($dashboardRoute::name('roles.show'), $role->id) }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
                                <div style="width: 32px; height: 32px; border-radius: 0.5rem; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center;">
                                    <svg style="width: 16px; height: 16px; color: white;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <span style="font-weight: 500; font-size: 0.9375rem; color: var(--foreground);">{{ $role->name }}</span>
                            </a>
                        </td>
                        <td>
                            <code style="padding: 0.25rem 0.5rem; background-color: var(--muted); border-radius: 0.25rem; font-size: 0.8125rem;">{{ $role->slug }}</code>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-primary">{{ $role->users_count }} Perdon</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-success">{{ $role->privileges_count }} Permission</span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <a href="{{ route($dashboardRoute::name('roles.show'), $role->id) }}" class="action-btn" title="View Details">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route($dashboardRoute::name('roles.edit'), $role->id) }}" class="action-btn" title="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                @if(!in_array($role->slug, $protectedRoles))
                                    <form action="{{ route($dashboardRoute::name('roles.destroy'), $role->id) }}" method="POST" id="delete-role-form-{{ $role->id }}" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="button" class="action-btn action-btn-danger" title="ডিলিট" onclick="event.preventDefault(); showDanger('রোল ডিলিট', 'আপনি কি নিশ্চিত? এই রোলের অধীনে থাকা সকল ইউজার তাদের পারমিশন হারাবে।').then(c => { if(c) document.getElementById('delete-role-form-{{ $role->id }}').submit(); })">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="action-btn" style="cursor: not-allowed; opacity: 0.5;" title="এটি প্রোটেক্টেড রোল, ডিলিট করা যাবে না">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($roles->hasPages())
        <div class="pagination">
            {{ $roles->links() }}
        </div>
        @endif
        
        @else
        <div class="empty-state">
            <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <h3 class="empty-state-title">No roles found</h3>
            <p class="empty-state-description">There are no roles added yet. Click the button above to create one.</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput && searchInput.value) {
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        }
    });
</script>
@endpush
@endsection