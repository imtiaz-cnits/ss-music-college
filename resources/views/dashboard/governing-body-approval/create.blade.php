@extends('tyro-dashboard::layouts.admin')

@section('title', 'Add Governing Body Approval')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<a href="{{ route('dashboard.governing-body-approval.index') }}">Governing Body Approval</a>
<span class="breadcrumb-separator">/</span>
<span>Add Approval</span>
@endsection

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar { font-family: inherit; }
</style>

<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Add Governing Body Approval</h1>
            <p class="page-description">Add a new official approval document.</p>
        </div>
        <a href="{{ route('dashboard.governing-body-approval.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 6px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Approvals
        </a>
    </div>
</div>

<div class="card" style="max-width: 100%;">
    <div class="card-body">
        <form action="{{ route('dashboard.governing-body-approval.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-input" required placeholder="Enter approval title...">
            </div>

            <div class="form-group mb-3">
                <label for="description" class="form-label">Details / Notes (Optional)</label>
                <textarea name="description" id="description" class="form-input" rows="4" placeholder="Write additional details here...">{{ old('description') }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Approval Date</label>
                <input type="text" id="datepicker" name="date" class="form-input bg-white" required placeholder="Select date...">
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Attach Image / File (PDF, PNG, JPG, WEBP)</label>
                <input type="file" name="file" class="form-input">
                <p style="font-size: 12px; color: #888; margin-top: 5px;">Max file size: 10MB</p>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Save Approval</button>
                <a href="{{ route('dashboard.governing-body-approval.index') }}" class="btn btn-ghost">Cancel</a>
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
            defaultDate: new Date()
        });
    });
</script>
@endsection
