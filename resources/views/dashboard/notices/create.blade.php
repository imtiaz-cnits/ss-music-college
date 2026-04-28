@extends('tyro-dashboard::layouts.admin')

@section('title', 'Add Notice')

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Add New Notice</h1>
            <p class="page-description">Create a new official announcement.</p>
        </div>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <div class="card-body">
        <form action="{{ route('notices.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Notice Title</label>
                <input type="text" name="title" class="form-input" required placeholder="Enter notice title...">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Notice Date</label>
                <input type="date" name="date" class="form-input" required>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Attach File (PDF, JPG, PNG)</label>
                <input type="file" name="file" class="form-input">
                <p style="font-size: 12px; color: #888; margin-top: 5px;">Max file size: 10MB</p>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Save Notice</button>
                <a href="{{ route('notices.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection