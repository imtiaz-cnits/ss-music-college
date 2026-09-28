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
                <input type="text" name="title" class="form-control form-input" value="{{ old('title', $event->title) }}" required>
            </div>

            <!-- Date Picker -->
            <div class="form-group mb-3">
                <label class="form-label">Date</label>
                <input type="text" id="datepicker" name="event_date" class="form-control form-input" value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control form-input">{{ old('description', $event->description) }}</textarea>
            </div>

            <!-- ইমেজ প্রিভিউ ও আপলোড -->
            <div class="form-group mb-4">
                <label class="form-label">Current Images:</label>
                <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 10px;">
                    @foreach($event->images as $image)
                    <div style="width: 120px; border: 1px solid var(--border); border-radius: 8px; padding: 8px; background: var(--card); text-align: center; display: flex; flex-direction: column; gap: 5px;">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Event Image" style="width: 100%; height: 100px; object-fit: cover; border-radius: 6px;">
                        
                        <!-- Featured Radio -->
                        <div style="display: flex; align-items: center; justify-content: center; gap: 5px; font-size: 0.8rem; margin-top: 5px;">
                            <input type="radio" name="featured_image_id" value="{{ $image->id }}" id="featured_{{ $image->id }}" {{ $image->is_featured ? 'checked' : '' }}>
                            <label for="featured_{{ $image->id }}" style="margin: 0; cursor: pointer;">Featured</label>
                        </div>
                        
                        <!-- Sort Order -->
                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem;">
                            <span>Order:</span>
                            <input type="number" name="sort_orders[{{ $image->id }}]" value="{{ $image->sort_order }}" style="width: 50px; padding: 2px 5px; border: 1px solid var(--border); border-radius: 4px; text-align: center;" min="0">
                        </div>

                        <!-- Delete Checkbox -->
                        <div style="display: flex; align-items: center; justify-content: center; gap: 5px; font-size: 0.8rem; color: var(--danger); border-top: 1px solid var(--border); padding-top: 5px; margin-top: 2px;">
                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_{{ $image->id }}">
                            <label for="delete_{{ $image->id }}" style="margin: 0; cursor: pointer; color: #da1e37;">Delete</label>
                        </div>
                    </div>
                    @endforeach
                </div>

                <label class="form-label mt-3">Upload More Images (Optional - will be appended to the current event images)</label>
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
            defaultDate: "{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}"
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