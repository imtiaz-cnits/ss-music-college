@extends('tyro-dashboard::layouts.admin')

@section('title', 'Edit Acceptance Renewal')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<a href="{{ route('dashboard.acceptance-renewal.index') }}">Acceptance Renewal</a>
<span class="breadcrumb-separator">/</span>
<span>Edit Renewal</span>
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar { font-family: inherit; }
</style>

<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Edit Acceptance Renewal (মঞ্জুরি নবায়ন)</h1>
            <p class="page-description">Update date or document for acceptance renewal.</p>
        </div>
        <a href="{{ route('dashboard.acceptance-renewal.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 6px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Acceptance Renewal
        </a>
    </div>
</div>

<div class="card" style="max-width: 100%;">
    <div class="card-body">
        <form action="{{ route('dashboard.acceptance-renewal.update', $renewal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Date</label>
                <input type="text" id="datepicker" name="date" class="form-input bg-white" value="{{ old('date', \Carbon\Carbon::parse($renewal->date)->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Attach New Image / File (Optional)</label>
                <input type="file" name="file" class="form-input">

                @if($renewal->file)
                <div style="font-size: 13px; color: #059669; margin-top: 8px; display: flex; align-items: center; gap: 5px; background: #ecfdf5; padding: 8px 12px; border-radius: 6px; width: max-content;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Currently attached:</span>
                    <a href="{{ asset('storage/' . $renewal->file) }}" target="_blank" style="color: #4f46e5; text-decoration: underline; font-weight: 500;">View existing file</a>
                </div>
                @endif
                <p style="font-size: 12px; color: #888; margin-top: 8px;">Leave blank to keep the existing file. Max file size: 10MB</p>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Update Renewal</button>
                <a href="{{ route('dashboard.acceptance-renewal.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/bn.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F, Y",
            locale: "en",
            defaultDate: "{{ old('date', \Carbon\Carbon::parse($renewal->date)->format('Y-m-d')) }}"
        });
    });
</script>
@endsection
