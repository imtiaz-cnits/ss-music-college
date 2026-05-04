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
</div>
@endsection