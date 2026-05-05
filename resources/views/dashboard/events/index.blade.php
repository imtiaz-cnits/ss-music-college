@extends('tyro-dashboard::layouts.admin')
@section('title', 'Events')

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">ইভেন্ট ম্যানেজমেন্ট</h1>
        </div>
        <a href="{{ route('dashboard.events.create') }}" class="btn btn-primary">নতুন ইভেন্ট যুক্ত করুন</a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>টাইটেল</th>
                    <th>ইমেজ</th>
                    <th>তারিখ</th>
                    <th style="text-align: right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr style="vertical-align: middle;">
                    <td>{{ Str::limit($event->title, 40) }}</td>
                    <td>
                        @if($event->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $event->images->first()->image_path) }}" width="60" height="40" style="object-fit: cover; border-radius: 4px; display: block;">
                        @else
                        <img src="{{ asset('assets/image/blog_card_img_01.png') }}" width="60" height="40" style="object-fit: cover; border-radius: 4px; display: block;">
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M, Y') }}</td>

                    <td style="text-align: right;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                            <!-- Preview Button -->
                            <button type="button" class="btn btn-sm btn-info" onclick="previewEvent('{{ addslashes($event->title) }}', '{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F, Y') }}', '{{ $event->images->isNotEmpty() ? asset('storage/' . $event->images->first()->image_path) : asset('assets/image/blog_card_img_01.png') }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>

                            <!-- Edit Button -->
                            <a href="{{ route('dashboard.events.edit', $event->id) }}" class="btn btn-sm btn-secondary">Edit</a>

                            <!-- Delete Button -->
                            <form action="{{ route('dashboard.events.destroy', $event->id) }}" method="POST" style="margin: 0; display: flex;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('ডিলিট করতে চান?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-3">কোনো ইভেন্ট নেই</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($events->hasPages())
    <div class="card-footer">
        {{ $events->links() }}
    </div>
    @endif
</div>
<!-- Preview Modal HTML & CSS -->
<style>
    #eventPreviewModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        display: flex;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    #eventPreviewModal.show {
        opacity: 1;
        visibility: visible;
    }

    .event-modal-box {
        background: var(--card);
        width: 850px;
        max-width: 90%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transform: scale(0.95) translateY(-10px);
        transition: transform 0.3s ease;
    }

    #eventPreviewModal.show .event-modal-box {
        transform: scale(1) translateY(0);
    }
</style>

<div id="eventPreviewModal">
    <!-- ভেতরের কন্টেন্ট -->
    <div class="event-modal-box">
        <div style="padding: 15px 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; color: var(--foreground);">ইভেন্ট প্রিভিউ</h3>
            <button onclick="closePreviewModal()" style="border: none; background: transparent; font-size: 26px; cursor: pointer; color: var(--foreground); line-height: 1;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <img id="previewImage" src="" alt="Event" style="width: 100%; height: 350px; object-fit: cover; border-radius: 6px; margin-bottom: 15px;">
            <h4 id="previewTitle" style="margin: 0 0 10px 0; color: var(--foreground); font-size: 20px;"></h4>
            <span id="previewDate" style="background: var(--muted); padding: 5px 10px; border-radius: 4px; font-size: 14px; color: var(--foreground);"></span>
        </div>
    </div>
</div>

<script>
    // Open Modal
    function previewEvent(title, date, imageUrl) {
        document.getElementById('previewTitle').innerText = title;
        document.getElementById('previewDate').innerText = date;
        document.getElementById('previewImage').src = imageUrl;

        document.getElementById('eventPreviewModal').classList.add('show');
    }

    // Close Modal
    function closePreviewModal() {
        document.getElementById('eventPreviewModal').classList.remove('show');
    }

    // Outside Click to Close
    document.getElementById('eventPreviewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePreviewModal();
        }
    });
</script>
@endsection