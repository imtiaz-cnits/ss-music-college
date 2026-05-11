@extends('tyro-dashboard::layouts.admin')
@section('title', 'Galleries')

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Gallery Management</h1>
        </div>
        <a href="{{ route('galleries.create') }}" class="btn btn-primary">Add New Image</a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($galleries->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galleries as $gallery)
                    <tr>
                        <td><img src="{{ asset('storage/' . $gallery->image) }}" width="80" class="rounded"></td>
                        <td>{{ $gallery->title }}</td>
                        <td style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="empty-state-title">No images found</h3>
            <p class="empty-state-description">There are no images added yet. Click the button above to create one.</p>
        </div>
        @endif
    </div>
</div>
@endsection