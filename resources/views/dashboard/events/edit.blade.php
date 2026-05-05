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
            <h1 class="page-title">ইভেন্ট এডিট করুন</h1>
        </div>
        <a href="{{ route('dashboard.events.index') }}" class="btn btn-secondary">পেছনে যান</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('dashboard.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label class="form-label">ইভেন্টের টাইটেল</label>
                <input type="text" name="title" class="form-control form-input" value="{{ $event->title }}" required>
            </div>

            <!-- Date Picker -->
            <div class="form-group mb-3">
                <label class="form-label">তারিখ</label>
                <input type="text" id="datepicker" name="event_date" class="form-control form-input" value="{{ $event->event_date->format('Y-m-d') }}" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">বিস্তারিত বিবরণ</label>
                <textarea name="description" rows="4" class="form-control form-input">{{ $event->description }}</textarea>
            </div>

            <!-- ইমেজ প্রিভিউ ও আপলোড -->
            <div class="form-group mb-4">
                <label class="form-label">বর্তমান ছবিসমূহ:</label>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">
                    @foreach($event->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Event Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                    @endforeach
                </div>

                <label class="form-label mt-3">নতুন ছবি আপলোড করুন (পুরনো ছবিগুলো মুছে এই নতুন ছবিগুলো যুক্ত হবে)</label>
                <input type="file" name="images[]" multiple accept="image/*" class="form-control form-input" id="imageInput">
                <div id="newImagePreview" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px;"></div>
            </div>

            <!-- ডায়নামিক টেবিল ফিল্ড -->
            <div class="form-group mb-4">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <label class="form-label m-0">কমিটির লিস্ট</label>
                    <button type="button" class="btn btn-sm btn-info" onclick="addTableRow()">+ নতুন রো অ্যাড করুন</button>
                </div>

                <div class="table-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ক্রমিক নং</th>
                                <th>নাম ও পদবি</th>
                                <th>নির্বাচনের ক্ষেত্র</th>
                                <th width="100">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody id="dynamic-table-body">
                            @if($event->content_table && count($event->content_table) > 0)
                            @foreach($event->content_table as $row)
                            <tr>
                                <td><input type="text" name="sl[]" class="form-control form-input" value="{{ $row['sl'] ?? '' }}"></td>
                                <td><input type="text" name="name[]" class="form-control form-input" value="{{ $row['name'] ?? '' }}"></td>
                                <td><input type="text" name="area[]" class="form-control form-input" value="{{ $row['area'] ?? '' }}"></td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeTableRow(this)">মুছুন</button></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td><input type="text" name="sl[]" class="form-control form-input" placeholder="১।"></td>
                                <td><input type="text" name="name[]" class="form-control form-input" placeholder="উদা: মোঃ শফিকুল ইসলাম"></td>
                                <td><input type="text" name="area[]" class="form-control form-input" placeholder="উদা: অভিভাবক সদস্য"></td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeTableRow(this)">মুছুন</button></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">আপডেট করুন</button>
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
            <td><input type="text" name="sl[]" class="form-control form-input" placeholder="ক্রমিক নং"></td>
            <td><input type="text" name="name[]" class="form-control form-input" placeholder="নাম ও পদবি"></td>
            <td><input type="text" name="area[]" class="form-control form-input" placeholder="নির্বাচনের ক্ষেত্র"></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeTableRow(this)">মুছুন</button></td>
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