@extends('tyro-dashboard::layouts.admin')
@section('title', 'Galleries')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span>Galleries</span>
@endsection

@section('content')
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Gallery Management</h1>
        </div>
        <a href="{{ route('galleries.create') }}" class="btn btn-primary">Add New Image</a>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($galleries->count() > 0)
        <!-- Search and Sort row -->
        <div class="search-row" style="display: flex; gap: 1rem; align-items: flex-end; padding: 1.25rem 1.25rem 0 1.25rem; margin-bottom: 20px; width: 100%; box-sizing: border-box;">
            <div class="filter-group" style="flex: 1;">
                <div class="search-input-wrapper" style="position: relative; width: 100%;">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted-foreground); pointer-events: none;">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="searchGallery" class="form-input" placeholder="Search by title..." style="padding-left: 2.5rem; width: 100%;">
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
            <table class="table" id="galleryTable">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 15%;">Image</th>
                        <th>Title</th>
                        <th style="text-align: right; width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galleries as $key => $gallery)
                    <tr style="vertical-align: middle;">
                        <td class="sl-column" style="vertical-align: middle;">{{ $key + 1 }}</td>
                        <td style="vertical-align: middle;"><img src="{{ asset('storage/' . $gallery->image) }}" width="80" class="rounded" style="display: block;"></td>
                        <td style="vertical-align: middle; font-weight: 500; color: var(--foreground);">{{ $gallery->title }}</td>
                        <td style="text-align: right; vertical-align: middle;">
                            <div class="action-buttons" style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" style="display:inline; margin: 0;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="empty-state-title">No images found</h3>
            <p class="empty-state-description">There are no images added yet. Click the button above to create one.</p>
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchGallery');
        const pageSizeSelect = document.getElementById('pageSizeSelect');
        const tableRows = document.querySelectorAll('#galleryTable tbody tr');

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
@endpush
@endsection