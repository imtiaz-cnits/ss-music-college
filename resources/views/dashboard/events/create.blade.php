@extends('tyro-dashboard::layouts.admin')
@section('title', 'Create Event')

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
            <h1 class="page-title">Create Event</h1>
        </div>
        <a href="{{ route('dashboard.events.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('dashboard.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group mb-3">
                <label class="form-label">Event Title</label>
                <input type="text" name="title" class="form-control form-input" required>
            </div>

            <!-- Date Picker -->
            <div class="form-group mb-3">
                <label class="form-label">Date</label>
                <input type="text" id="datepicker" name="event_date" class="form-control form-input" placeholder="Select Date" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control form-input"></textarea>
            </div>

            <!-- মাল্টিপল ইমেজ ফিল্ড -->
            <div class="form-group mb-4">
                <label class="form-label">Upload Images (You can select multiple images)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="form-control form-input" id="imageInput">
                <div id="newImagePreview" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px;"></div>
            </div>

            <!-- ডায়নামিক টেবিল ফিল্ড -->
            <div class="form-group m-4 pt-5">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <label class="form-label m-0">Committee List (if needed)</label>
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
                            <tr>
                                <td style="padding: 10px 4px 10px 4px !important;"><input type="text" name="sl[]" class="form-control form-input" placeholder="1."></td>
                                <td style="padding: 10px 4px 10px 4px !important;"><input type="text" name="name[]" class="form-control form-input" placeholder="Name and Position"></td>
                                <td style="padding: 10px 4px 10px 4px !important;"><input type="text" name="area[]" class="form-control form-input" placeholder="Selection Area"></td>
                                <td style="padding: 10px 4px 10px 4px !important; text-align: right;"><button type="button" class="btn btn-sm btn-danger w-full" style=" width: 100%; padding: 12px;" onclick="removeTableRow(this)">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Event Save</button>
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

    // Table Row Add/Remove
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

    // Image Preview
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