@extends($isAdmin ? 'tyro-dashboard::layouts.admin' : 'tyro-dashboard::layouts.user')

@section('title', 'My Profile')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span>My Profile</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">My Profile</h1>
            <p class="page-description">Manage your account settings and preferences.</p>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Profile Information -->
    <div class="card" style="display: flex; flex-direction: column;">
        <div class="card-header">
            <h3 class="card-title">Profile Information</h3>
        </div>
        <form action="{{ route($dashboardRoute::name('profile.update')) }}" method="POST" enctype="multipart/form-data" style="flex: 1; display: flex; flex-direction: column;">
            @csrf
            @method('PUT')
            <div class="card-body" style="flex: 1;">
                <!-- Profile Photo Upload Section -->
                <div class="form-group">
                    <label class="form-label">Profile Photo</label>
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border);">
                        @else
                        <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--primary); color: var(--primary-foreground); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 600;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        @endif

                        <div style="flex: 1;">
                            <input type="file" name="photo" class="form-input" style="padding: 0.5rem;" accept="image/*">
                            <p class="form-hint">Allowed types: jpg, png, gif, webp. Max size: 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Name and Email -->
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer" style="margin-top: auto;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="card" style="display: flex; flex-direction: column;">
        <div class="card-header">
            <h3 class="card-title">Update Password</h3>
        </div>
        <form action="{{ route($dashboardRoute::name('profile.password')) }}" method="POST" style="flex: 1; display: flex; flex-direction: column;">
            @csrf
            @method('PUT')
            <div class="card-body" style="flex: 1;">
                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-input @error('current_password') is-invalid @enderror" required>
                    @error('current_password')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror" required>
                    @error('password')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                </div>
            </div>
            <div class="card-footer" style="margin-top: auto;">
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>
</div>

<!-- Two-Factor Authentication -->
<form id="delete-photo-form" action="{{ route($dashboardRoute::name('profile.photo.delete')) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@if(config('tyro-login.two_factor.enabled'))
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h3 class="card-title">Two-Factor Authentication (2FA)</h3>
    </div>
    <div class="card-body">
        @if($user->two_factor_secret)
        <p style="margin-bottom: 1rem; color: var(--muted-foreground);">
            Two-factor authentication is currently <strong>enabled</strong> for your account.
        </p>
        <form action="{{ route($dashboardRoute::name('profile.2fa.reset')) }}" method="POST" id="reset-profile-2fa-form">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-warning" onclick="event.preventDefault(); showConfirm('Reset 2FA', 'Are you sure you want to reset your 2FA? You will need to set it up again.').then(confirmed => { if(confirmed) document.getElementById('reset-profile-2fa-form').submit(); })">
                Reset 2FA Configuration
            </button>
        </form>
        @else
        <p style="margin-bottom: 1rem; color: var(--muted-foreground);">
            Two-factor authentication is currently <strong>disabled</strong> for your account.
        </p>

        <button type="button" class="btn btn-secondary" disabled>Reset 2FA Configuration</button>
        @endif
    </div>
</div>
@endif

<!-- Account Information -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h3 class="card-title">Account Information</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
            <div>
                <label class="form-label" style="margin-bottom: 0.25rem;">Account ID</label>
                <p style="font-size: 0.875rem; color: var(--muted-foreground);">#{{ $user->id }}</p>
            </div>
            <div>
                <label class="form-label" style="margin-bottom: 0.25rem;">Member Since</label>
                <p style="font-size: 0.875rem; color: var(--muted-foreground);">{{ $user->created_at->format('F d, Y') }}</p>
            </div>
            @if(method_exists($user, 'roles') && $user->roles->count())
            <div>
                <label class="form-label" style="margin-bottom: 0.25rem;">Roles</label>
                <div class="badge-list">
                    @foreach($user->roles as $role)
                    <span class="badge badge-primary">{{ $role->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif
            <div>
                <label class="form-label" style="margin-bottom: 0.25rem;">Status</label>
                <p>
                    @if(method_exists($user, 'isSuspended') && $user->isSuspended())
                    <span class="badge badge-danger">Suspended</span>
                    @else
                    <span class="badge badge-success">Active</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection