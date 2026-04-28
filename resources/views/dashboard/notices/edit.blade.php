@extends('tyro-dashboard::layouts.admin')

@section('title', 'Edit Notice')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<a href="{{ route('notices.index') }}">Notices</a>
<span class="breadcrumb-separator">/</span>
<span>Edit Notice</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Edit Notice</h1>
            <p class="page-description">Update the details or file for this official announcement.</p>
        </div>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <div class="card-body">
        <form action="{{ route('notices.update', $notice->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Notice Title</label>
                <input type="text" name="title" class="form-input" value="{{ $notice->title }}" required placeholder="Enter notice title...">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Notice Date</label>
                <input type="date" name="date" class="form-input" value="{{ \Carbon\Carbon::parse($notice->date)->format('Y-m-d') }}" required>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Attach New File (Optional)</label>
                <input type="file" name="file" class="form-input">
                
                @if($notice->file)
                    <div style="font-size: 13px; color: #059669; margin-top: 8px; display: flex; align-items: center; gap: 5px; background: #ecfdf5; padding: 8px 12px; border-radius: 6px; width: max-content;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Currently attached:</span> 
                        <a href="{{ asset('storage/' . $notice->file) }}" target="_blank" style="color: #4f46e5; text-decoration: underline; font-weight: 500;">View existing file</a>
                    </div>
                @endif
                <p style="font-size: 12px; color: #888; margin-top: 8px;">Leave blank to keep the existing file. Max file size: 10MB (PDF, JPG, PNG)</p>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Update Notice</button>
                <a href="{{ route('notices.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection