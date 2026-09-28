@extends('tyro-dashboard::layouts.admin')
@section('title', 'Events')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span>Events</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Event Management</h1>
        </div>
        <a href="{{ route('dashboard.events.create') }}" class="btn btn-primary">Add New Event</a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($events->count() > 0)
        <!-- Search and Sort row -->
        <div class="search-row" style="display: flex; gap: 1rem; align-items: flex-end; padding: 1.25rem 1.25rem 0 1.25rem; margin-bottom: 20px; width: 100%; box-sizing: border-box;">
            <div class="filter-group" style="flex: 1;">
                <div class="search-input-wrapper" style="position: relative; width: 100%;">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted-foreground); pointer-events: none;">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="searchEvent" class="form-input" placeholder="Search by title..." style="padding-left: 2.5rem; width: 100%;">
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
            <table class="table" id="eventsTable">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Title</th>
                        <th style="width: 15%;">Image</th>
                        <th style="width: 15%;">Date</th>
                        <th style="text-align: right; width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $key => $event)
                    <tr style="vertical-align: middle;">
                        <td class="sl-column" style="vertical-align: middle;">{{ $key + 1 }}</td>
                        <td>{{ Str::limit($event->title, 40) }}</td>
                        <td>
                            @if($event->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $event->images->first()->image_path) }}" width="60" height="40" style="object-fit: cover; border-radius: 4px; display: block;">
                            @else
                            <span style="color: #94a3b8; font-size: 13px;">No Image</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($event->event_date)->locale('en')->format('d M, Y') }}</td>

                        <td style="text-align: right;">
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                <!-- Preview Button -->
                                <button type="button" class="btn btn-sm btn-info" onclick="previewEvent('{{ addslashes($event->title) }}', '{{ \Carbon\Carbon::parse($event->event_date)->locale('en')->format('d F, Y') }}', '{{ $event->images->isNotEmpty() ? asset('storage/' . $event->images->first()->image_path) : '' }}')">
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
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination controls -->
        <div class="pagination-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; border-top: 1px solid var(--border); background-color: var(--card); flex-wrap: wrap; gap: 0.75rem;">
            <div class="pagination-info" style="font-size: 0.875rem; color: var(--muted-foreground);">
                Showing <span id="paginationStart">0</span> to <span id="paginationEnd">0</span> of <span id="paginationTotal">0</span> entries
            </div>
            <div class="pagination-buttons" id="paginationButtons" style="display: flex; align-items: center; gap: 0.35rem;">
                <!-- Dynamically populated buttons -->
            </div>
        </div>
        @else
        <div class="empty-state">
            <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="empty-state-title">No events found</h3>
            <p class="empty-state-description">There are no events added yet. Click the button above to create one.</p>
        </div>
        @endif
    </div>
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
            <h3 style="margin: 0; font-size: 18px; color: var(--foreground);">Event Preview</h3>
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
        const imgEl = document.getElementById('previewImage');
        if (imageUrl) {
            imgEl.src = imageUrl;
            imgEl.style.display = 'block';
        } else {
            imgEl.src = '';
            imgEl.style.display = 'none';
        }

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

    // Events client-side filtering and pagination scripting
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchEvent');
        const pageSizeSelect = document.getElementById('pageSizeSelect');
        const tableRows = document.querySelectorAll('#eventsTable tbody tr');

        if (!searchInput || !pageSizeSelect || tableRows.length === 0) return;

        let currentPage = 1;
        let pageSize = 10;

        function filterTable() {
            const searchText = searchInput.value.toLowerCase().trim();
            const selectedSizeVal = pageSizeSelect.value;
            pageSize = selectedSizeVal === 'all' ? Infinity : parseInt(selectedSizeVal, 10);

            const matchedRows = [];
            tableRows.forEach(row => {
                const title = row.cells[0].textContent.toLowerCase();
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
                    row.querySelector('.sl-column').textContent = index + 1;
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
            prevBtn.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            `;
            if (currentPage > 1) {
                prevBtn.addEventListener('click', () => {
                    currentPage--;
                    filterTable();
                });
            }
            container.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.type = 'button';
                pageBtn.className = `pagination-btn ${currentPage === i ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.addEventListener('click', () => {
                    currentPage = i;
                    filterTable();
                });
                container.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = `pagination-btn ${currentPage === totalPages ? 'disabled' : ''}`;
            nextBtn.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            `;
            if (currentPage < totalPages) {
                nextBtn.addEventListener('click', () => {
                    currentPage++;
                    filterTable();
                });
            }
            container.appendChild(nextBtn);
        }

        pageSizeSelect.addEventListener('change', () => {
            currentPage = 1;
            filterTable();
        });

        searchInput.addEventListener('input', () => {
            currentPage = 1;
            filterTable();
        });

        filterTable();
    });
</script>
@endsection