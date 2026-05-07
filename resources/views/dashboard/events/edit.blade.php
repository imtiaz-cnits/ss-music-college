@extends('tyro-dashboard::layouts.admin')
@section('title', 'Edit Event')

@push('styles')
<!-- Flatpickr CSS for beautiful Datepicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-calendar {
        font-family: inherit;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Edit Event</h1>
        </div>
        <a href="{{ route('dashboard.events.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('dashboard.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label class="form-label">Event Title</label>
                <input type="text" name="title" class="form-control form-input" value="{{ $event->title }}" required>
            </div>

            <!-- Date Picker -->
            <div class="form-group mb-3">
                <label class="form-label">Date</label>
                <input type="text" id="datepicker" name="event_date" class="form-control form-input" value="{{ $event->event_date->format('Y-m-d') }}" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control form-input">{{ $event->description }}</textarea>
            </div>

            <!-- ইমেজ প্রিভিউ ও আপলোড -->
            <div class="form-group mb-4">
                <label class="form-label">Current Images:</label>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">
                    @foreach($event->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Event Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                    @endforeach
                </div>

                <label class="form-label mt-3">Upload New Images (Old images will be deleted and new ones will be added)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="form-control form-input" id="imageInput">
                <div id="newImagePreview" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px;"></div>
            </div>

            <!-- ডায়নামিক টেবিল ফিল্ড -->
            <div class="form-group mb-4">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <label class="form-label m-0">Committee List</label>
                    <button type="button" class="btn btn-sm btn-info" onclick="addTableRow()">+ Add New Row</button>
                </div>

                <div class="table-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Name and Position</th>
                                <th>Selection Area</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody id="dynamic-table-body">
                            @if($event->content_table && count($event->content_table) > 0)
                            @foreach($event->content_table as $row)
                            <tr>
                                <td><input type="text" name="sl[]" class="form-control form-input" value="{{ $row['sl'] ?? '' }}"></td>
                                <td><input type="text" name="name[]" class="form-control form-input" value="{{ $row['name'] ?? '' }}"></td>
                                <td><input type="text" name="area[]" class="form-control form-input" value="{{ $row['area'] ?? '' }}"></td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeTableRow(this)">Delete</button></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td><input type="text" name="sl[]" class="form-control form-input" placeholder="1."></td>
                                <td><input type="text" name="name[]" class="form-control form-input" placeholder="e.g., Mr. Shahidul Islam"></td>
                                <td><input type="text" name="area[]" class="form-control form-input" placeholder="e.g., Committee Member"></td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeTableRow(this)">Delete</button></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</div>

@push('scripts')
<!-- Flatpickr JS -->
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

    function addTableRow() {
        const tbody = document.getElementById('dynamic-table-body');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="sl[]" class="form-control form-input" placeholder="Serial"></td>
            <td><input type="text" name="name[]" class="form-control form-input" placeholder="Name and Position"></td>
            <td><input type="text" name="area[]" class="form-control form-input" placeholder="Selection Area"></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeTableRow(this)">Delete</button></td>
        `;
        tbody.appendChild(tr);
    }

    function removeTableRow(button) {
        button.closest('tr').remove();
    }

    document.getElementById('imageInput').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('newImagePreview');
        previewContainer.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '2px solid var(--border)';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
@endsection