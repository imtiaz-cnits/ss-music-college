@extends('tyro-dashboard::layouts.admin')
@section('title', 'Edit Image')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group mb-3">
                <label>Image Title</label>
                <input type="text" name="title" class="form-control form-input" value="{{ $gallery->title }}" required>
            </div>
            <div class="form-group mb-3">
                <label>Update Image (Optional)</label>
                <input type="file" name="image" class="form-control form-input">
                <img src="{{ asset('storage/' . $gallery->image) }}" width="100" class="mt-2 rounded">
            </div>
            <button type="submit" class="btn btn-primary">Update Image</button>
        </form>
    </div>
</div>
@endsection