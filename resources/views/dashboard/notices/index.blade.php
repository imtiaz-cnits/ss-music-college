@extends('tyro-dashboard::layouts.admin')

@section('title', 'Notices')

@php
    function convertToBangla($string) {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace($en, $bn, $string);
    }
@endphp

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span>Notices</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Notices Management</h1>
            <p class="page-description">Manage all your college notices and announcements from here.</p>
        </div>
        <a href="{{ route('notices.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 6px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Add New Notice
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($notices->count() > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 45%;">Title</th>
                        <th style="width: 20%;">Date</th>
                        <th style="width: 15%;">Attachment</th>
                        <th style="text-align: right; width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notices as $key => $notice)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td style="font-weight: 500; color: var(--foreground);">{{ $notice->title }}</td>
                        <td>
                            <span class="badge badge-secondary" style="font-size: 0.85rem;">
                                {{ convertToBangla(\Carbon\Carbon::parse($notice->date)->locale('bn')->translatedFormat('d F, Y')) }}
                            </span>
                        </td>
                        <td>
                            @if($notice->file)
                            <!-- File Indicator -->
                            <span class="badge badge-success">File Attached</span>
                            @else
                            <span class="badge badge-warning" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a;">Text Notice</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                
                                @if($notice->file)
                                <!-- View File in Modal Button -->
                                <button type="button" class="action-btn" title="View File" onclick="viewNoticeFile('{{ asset('storage/' . $notice->file) }}', '{{ $notice->title }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                @endif

                                <a href="{{ route('notices.edit', $notice->id) }}" class="action-btn" title="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('notices.destroy', $notice->id) }}" method="POST" style="margin:0;" id="delete-form-{{ $notice->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="event.preventDefault(); showDanger('Delete Notice', 'Are you sure you want to delete this notice?').then(c => { if(c) document.getElementById('delete-form-{{ $notice->id }}').submit(); })">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="empty-state-title">No notices found</h3>
            <p class="empty-state-description">There are no notices added yet. Click the button above to create one.</p>
        </div>
        @endif
    </div>
</div>

<!-- Custom File Viewer Modal -->
<div id="fileViewerModal" class="modal-overlay">
    <div class="modal" style="max-width: 800px; width: 95%;">
        <div class="modal-header">
            <h3 id="fileViewerTitle" class="modal-title">View Notice</h3>
            <button type="button" class="modal-close" onclick="closeModal('fileViewerModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body" style="padding: 0; background: var(--muted); text-align: center; height: 70vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <div id="fileViewerContent" style="width: 100%; height: 100%;">
                <!-- Content will be injected here via JS -->
            </div>
        </div>
        <div class="modal-footer">
            <a id="fileViewerDownloadBtn" href="#" target="_blank" class="btn btn-primary" download>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px; margin-right: 5px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download File
            </a>
            <button type="button" class="btn btn-secondary" onclick="closeModal('fileViewerModal')">Close</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function viewNoticeFile(fileUrl, title) {
        const titleEl = document.getElementById('fileViewerTitle');
        const contentEl = document.getElementById('fileViewerContent');
        const downloadBtn = document.getElementById('fileViewerDownloadBtn');
        
        // Set Title and Download Link
        titleEl.textContent = title;
        downloadBtn.href = fileUrl;

        // Check file extension
        const extension = fileUrl.split('.').pop().toLowerCase();
        
        contentEl.innerHTML = ''; // Clear previous content

        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
            // It's an image
            contentEl.innerHTML = `<img src="${fileUrl}" alt="${title}" style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 1rem;">`;
        } else if (extension === 'pdf') {
            // It's a PDF
            contentEl.innerHTML = `<iframe src="${fileUrl}" style="width: 100%; height: 100%; border: none;"></iframe>`;
        } else {
            // Other file types
            contentEl.innerHTML = `
                <div style="padding: 3rem;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 64px; height: 64px; color: var(--muted-foreground); margin-bottom: 1rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p style="color: var(--foreground); font-weight: 500;">Preview not available for this file type.</p>
                    <p style="color: var(--muted-foreground); font-size: 0.875rem;">Please download the file to view it.</p>
                </div>
            `;
        }

        // Show Modal
        const modal = document.getElementById('fileViewerModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
</script>
@endpush

@endsection