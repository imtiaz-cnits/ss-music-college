@extends('tyro-dashboard::layouts.admin')
@section('title', 'Add Image')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label>Image Title</label>
                <input type="text" name="title" class="form-control form-input" required>
            </div>
            <div class="form-group mb-3">
                <label>Upload Image</label>
                <input type="file" name="image" class="form-control form-input" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Image</button>
        </form>
    </div>
</div>
@endsection