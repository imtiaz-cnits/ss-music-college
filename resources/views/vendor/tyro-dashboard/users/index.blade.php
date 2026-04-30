@extends('tyro-dashboard::layouts.admin')
@section('title', 'Users')

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">ইউজার ম্যানেজমেন্ট</h1>
            <p class="page-description">অ্যাডমিন, শিক্ষক এবং সাধারণ ইউজারদের অ্যাকাউন্ট নিয়ন্ত্রণ করুন</p>
        </div>
        <a href="{{ route($dashboardRoute::name('users.create')) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 6px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            নতুন ইউজার
        </a>
    </div>
</div>

{{-- Filters Section --}}
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route($dashboardRoute::name('users.index')) }}" method="GET">
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                    <label class="form-label">সার্চ করুন</label>
                    <input type="text" name="search" class="form-input" placeholder="নাম বা ইমেইল..." value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="form-group" style="width: 180px; margin-bottom: 0;">
                    <label class="form-label">রোল (Role)</label>
                    <select name="role" class="form-select">
                        <option value="">সকল রোল</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->slug }}" {{ ($filters['role'] ?? '') === $role->slug ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="width: 160px; margin-bottom: 0;">
                    <label class="form-label">স্ট্যাটাস</label>
                    <select name="status" class="form-select">
                        <option value="">সকল স্ট্যাটাস</option>
                        <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ ($filters['status'] ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn btn-secondary">ফিল্টার</button>
                    @if(!empty($filters['search']) || !empty($filters['role']) || !empty($filters['status']))
                        <a href="{{ route($dashboardRoute::name('users.index')) }}" class="btn btn-ghost">মুছুন</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Users Table --}}
<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($users->count())
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ইউজার</th>
                        <th>রোলস</th>
                        <th>স্ট্যাটাস</th>
                        <th>যোগদানের তারিখ</th>
                        <th style="text-align: right;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $listUser)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-cell-avatar" style="{{ ($listUser->profile_photo_path || ($listUser->use_gravatar && $listUser->email)) ? 'background: none; padding: 0;' : '' }}">
                                    @if($listUser->profile_photo_path || ($listUser->use_gravatar && $listUser->email))
                                        <img src="{{ $listUser->profile_photo_url }}" alt="{{ $listUser->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                    @else
                                        {{ strtoupper(substr($listUser->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="user-cell-info">
                                    <div class="user-cell-name">{{ $listUser->name }}</div>
                                    <div class="user-cell-email">{{ $listUser->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="badge-list">
                                @forelse($listUser->roles as $role)
                                    <span class="badge badge-primary">{{ $role->name }}</span>
                                @empty
                                    <span class="badge badge-secondary">No roles</span>
                                @endforelse
                            </div>
                        </td>
                        <td>
                            @php
                                $isSuspended = false;
                                if (method_exists($listUser, 'isSuspended')) {
                                    $isSuspended = $listUser->isSuspended();
                                } elseif (isset($listUser->suspended_at) && !is_null($listUser->suspended_at)) {
                                    $isSuspended = true;
                                }
                            @endphp

                            @if($isSuspended)
                                <span class="badge badge-danger">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                    Suspended
                                </span>
                            @else
                                <span class="badge badge-success">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Active
                                </span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 0.875rem;">{{ $listUser->created_at->format('M d, Y') }}</span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <a href="{{ route($dashboardRoute::name('users.edit'), $listUser->id) }}" class="action-btn" title="এডিট">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                @if($listUser->id !== $user->id)
                                    <form action="{{ route($dashboardRoute::name('users.login-as'), $listUser->id) }}" method="POST" id="login-as-form-{{ $listUser->id }}" style="margin:0;">
                                        @csrf
                                        <button type="button" class="action-btn" style="color: var(--primary);" title="এই ইউজার হয়ে লগিন করুন" onclick="event.preventDefault(); showConfirm('লগিন অ্যাজ', 'আপনি কি {{ addslashes($listUser->name) }} হিসেবে লগিন করতে চান?').then(c => { if(c) document.getElementById('login-as-form-{{ $listUser->id }}').submit(); })">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                @if($isSuspended)
                                    <form action="{{ route($dashboardRoute::name('users.unsuspend'), $listUser->id) }}" method="POST" id="unsuspend-form-{{ $listUser->id }}" style="margin:0;">
                                        @csrf
                                        <button type="button" class="action-btn" style="color: var(--success);" title="আন-সাসপেন্ড" onclick="event.preventDefault(); showConfirm('আন-সাসপেন্ড', 'এই ইউজারকে আবার একটিভ করতে চান?').then(c => { if(c) document.getElementById('unsuspend-form-{{ $listUser->id }}').submit(); })">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </form>
                                @elseif(method_exists($listUser, 'suspend'))
                                    <button type="button" class="action-btn" style="color: var(--warning);" title="সাসপেন্ড করুন" onclick="openSuspendModal({{ $listUser->id }}, '{{ addslashes($listUser->name) }}')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                    </button>
                                @endif

                                @if($listUser->id !== $user->id)
                                    <form action="{{ route($dashboardRoute::name('users.destroy'), $listUser->id) }}" method="POST" id="delete-user-form-{{ $listUser->id }}" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="button" class="action-btn action-btn-danger" title="ডিলিট" onclick="event.preventDefault(); showDanger('ইউজার ডিলিট', 'আপনি কি নিশ্চিত? এটি আর ফেরত আনা যাবে না।').then(c => { if(c) document.getElementById('delete-user-form-{{ $listUser->id }}').submit(); })">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="pagination">
            {{ $users->links() }}
        </div>
        @endif
        
        @else
        <div class="empty-state">
            <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <h3 class="empty-state-title">কোনো ইউজার পাওয়া যায়নি</h3>
            <p class="empty-state-description">শুরু করতে নতুন একটি ইউজার অ্যাকাউন্ট তৈরি করুন।</p>
            <a href="{{ route($dashboardRoute::name('users.create')) }}" class="btn btn-primary">নতুন ইউজার তৈরি করুন</a>
        </div>
        @endif
    </div>
</div>

{{-- Suspend Modal --}}
<div class="modal-overlay" id="suspendModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">অ্যাকাউন্ট সাসপেন্ড</h3>
            <button type="button" class="modal-close" onclick="closeModal('suspendModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="suspendForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="alert alert-warning" style="margin-bottom: 1rem; padding: 0.75rem; border-radius: 8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 0.5rem; display: inline-block; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    আপনি <strong id="suspendUserName" style="font-weight: 600;"></strong>-কে সাসপেন্ড করতে যাচ্ছেন।
                </div>
                <div class="form-group">
                    <label for="reason" class="form-label">
                        সাসপেন্ড করার কারণ <span class="form-label-optional">(ঐচ্ছিক)</span>
                    </label>
                    <textarea id="reason" name="reason" class="form-textarea" rows="3" placeholder="এখানে কারণ লিখুন..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('suspendModal')">বাতিল</button>
                <button type="submit" class="btn btn-destructive">সাসপেন্ড করুন</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openSuspendModal(userId, userName) {
        document.getElementById('suspendForm').action = '{{ url(config('tyro-dashboard.route_prefix', 'dashboard')) }}/users/' + userId + '/suspend';
        document.getElementById('suspendUserName').textContent = userName;
        document.getElementById('reason').value = '';
        
        // Show modal Tyro native way
        const modal = document.getElementById('suspendModal');
        modal.classList.add('active');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

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