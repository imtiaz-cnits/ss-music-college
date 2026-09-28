@extends('tyro-dashboard::layouts.admin')

@section('title', 'Governing Body Approval')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span>Governing Body Approval</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Governing Body Approval Management</h1>
            <p class="page-description">Manage all official governing body approval documents and announcements.</p>
        </div>
        <a href="{{ route('dashboard.governing-body-approval.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 6px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New Approval
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($approvals->count() > 0)
        <!-- Search and Sort row -->
        <div class="search-row" style="display: flex; gap: 1rem; align-items: flex-end; padding: 1.25rem 1.25rem 0 1.25rem; margin-bottom: 20px; width: 100%; box-sizing: border-box;">
            <div class="filter-group" style="flex: 1;">
                <div class="search-input-wrapper" style="position: relative; width: 100%;">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted-foreground); pointer-events: none;">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="searchTable" class="form-input" placeholder="Search by title..." style="padding-left: 2.5rem; width: 100%;">
                </div>
            </div>
            <div class="filter-group" style="width: 150px; flex-shrink: 0;">
                <select id="pageSizeSelect" class="form-select" style="width: 100%;">
                    <option value="10" selected>10 Rows</option>
                    <option value="30">30 Rows</option>
                    <option value="50">50 Rows</option>
                    <option value="100">100 Rows</option>
                    <option value="all">All Rows</option>
                </select>
            </div>
        </div>

        <div class="table-container">
            <table class="table" id="approvalsTable">
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
                    @foreach($approvals as $key => $approval)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td style="font-weight: 500; color: var(--foreground);">{{ $approval->title }}</td>
                        <td>
                            <span class="badge badge-secondary" style="font-size: 0.85rem;">
                                {{ \Carbon\Carbon::parse($approval->date)->locale('en')->format('d M, Y') }}
                            </span>
                        </td>
                        <td>
                            @if($approval->file)
                            <span class="badge badge-success">File Attached</span>
                            @else
                            <span class="badge badge-warning" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a;">No File</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                @if($approval->file)
                                <button type="button" class="action-btn" title="View File" onclick="viewDocumentFile('{{ asset('storage/' . $approval->file) }}', '{{ addslashes($approval->title) }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                @endif

                                <a href="{{ route('dashboard.governing-body-approval.edit', $approval->id) }}" class="action-btn" title="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('dashboard.governing-body-approval.destroy', $approval->id) }}" method="POST" style="margin:0;" id="delete-form-{{ $approval->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="event.preventDefault(); showDanger('Delete Approval', 'Are you sure you want to delete this approval record?').then(c => { if(c) document.getElementById('delete-form-{{ $approval->id }}').submit(); })">
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
        
        <div class="pagination-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; border-top: 1px solid var(--border); background-color: var(--card); flex-wrap: wrap; gap: 0.75rem;">
            <div class="pagination-info" style="font-size: 0.875rem; color: var(--muted-foreground);">
                Showing <span id="paginationStart">0</span> to <span id="paginationEnd">0</span> of <span id="paginationTotal">0</span> entries
            </div>
            <div class="pagination-buttons" id="paginationButtons" style="display: flex; align-items: center; gap: 0.35rem;"></div>
        </div>
        @else
        <div class="empty-state">
            <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="empty-state-title">No approval records found</h3>
            <p class="empty-state-description">There are no governing body approvals added yet. Click the button above to add one.</p>
        </div>
        @endif
    </div>
</div>

<!-- Custom File Viewer Modal -->
<div id="fileViewerModal" class="modal-overlay">
    <div class="modal" style="max-width: 800px; width: 95%;">
        <div class="modal-header">
            <h3 id="fileViewerTitle" class="modal-title">View Document</h3>
            <button type="button" class="modal-close" onclick="closeModal('fileViewerModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body" style="padding: 0; background: var(--muted); text-align: center; height: 70vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <div id="fileViewerContent" style="width: 100%; height: 100%;"></div>
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
    function viewDocumentFile(fileUrl, title) {
        const titleEl = document.getElementById('fileViewerTitle');
        const contentEl = document.getElementById('fileViewerContent');
        const downloadBtn = document.getElementById('fileViewerDownloadBtn');
        
        titleEl.textContent = title;
        downloadBtn.href = fileUrl;

        const extension = fileUrl.split('.').pop().toLowerCase();
        contentEl.innerHTML = '';

        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
            contentEl.innerHTML = `<img src="${fileUrl}" alt="${title}" style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 1rem;">`;
        } else if (extension === 'pdf') {
            contentEl.innerHTML = `<iframe src="${fileUrl}" style="width: 100%; height: 100%; border: none;"></iframe>`;
        } else {
            contentEl.innerHTML = `
                <div style="padding: 3rem;">
                    <p style="color: var(--foreground); font-weight: 500;">Preview not available for this file type.</p>
                </div>
            `;
        }

        const modal = document.getElementById('fileViewerModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchTable');
        const pageSizeSelect = document.getElementById('pageSizeSelect');
        const tableRows = document.querySelectorAll('#approvalsTable tbody tr');

        if (!searchInput || !pageSizeSelect || tableRows.length === 0) return;

        let currentPage = 1;
        let pageSize = 10;

        function filterTable() {
            const searchText = searchInput.value.toLowerCase().trim();
            const selectedSizeVal = pageSizeSelect.value;
            pageSize = selectedSizeVal === 'all' ? Infinity : parseInt(selectedSizeVal, 10);

            const matchedRows = [];
            tableRows.forEach(row => {
                const title = row.cells[1].textContent.toLowerCase();
                const matchesSearch = !searchText || title.includes(searchText);

                if (matchesSearch) {
                    row.classList.add('matches-filter');
                    matchedRows.push(row);
                } else {
                    row.classList.remove('matches-filter');
                    row.style.display = 'none';
                }
            });

            const totalMatches = matchedRows.length;
            const totalPages = Math.ceil(totalMatches / pageSize) || 1;

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            const startIndex = pageSize === Infinity ? 0 : (currentPage - 1) * pageSize;
            const endIndex = pageSize === Infinity ? Infinity : startIndex + pageSize;

            matchedRows.forEach((row, index) => {
                if (index >= startIndex && index < endIndex) {
                    row.style.display = '';
                    row.querySelector('td:first-child').textContent = index + 1;
                } else {
                    row.style.display = 'none';
                }
            });

            const startText = totalMatches === 0 ? 0 : startIndex + 1;
            const endText = Math.min(endIndex, totalMatches);
            document.getElementById('paginationStart').textContent = startText;
            document.getElementById('paginationEnd').textContent = endText;
            document.getElementById('paginationTotal').textContent = totalMatches;

            renderPaginationButtons(totalPages);
        }

        function renderPaginationButtons(totalPages) {
            const container = document.getElementById('paginationButtons');
            if (!container) return;
            container.innerHTML = '';

            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.className = `pagination-btn ${currentPage === 1 ? 'disabled' : ''}`;
            prevBtn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>`;
            if (currentPage > 1) {
                prevBtn.addEventListener('click', () => { currentPage--; filterTable(); });
            }
            container.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.type = 'button';
                pageBtn.className = `pagination-btn ${currentPage === i ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.addEventListener('click', () => { currentPage = i; filterTable(); });
                container.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = `pagination-btn ${currentPage === totalPages ? 'disabled' : ''}`;
            nextBtn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>`;
            if (currentPage < totalPages) {
                nextBtn.addEventListener('click', () => { currentPage++; filterTable(); });
            }
            container.appendChild(nextBtn);
        }

        pageSizeSelect.addEventListener('change', () => { currentPage = 1; filterTable(); });
        searchInput.addEventListener('input', () => { currentPage = 1; filterTable(); });
        filterTable();
    });
</script>
@endpush
@endsection
