@extends('tyro-dashboard::layouts.admin')
@section('title', 'Student Management')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span>Students</span>
@endsection

@section('content')
<!-- Custom Styles for Filter Layout, Avatars & Mobile Cards -->
<style>
    /* Dropdown Grid Layout */
    .dropdown-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 columns on desktop */
        gap: 0.75rem;
    }
    @media (max-width: 768px) {
        .dropdown-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 columns on mobile */
        }
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        align-items: flex-start !important;
    }
    .filter-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--muted-foreground);
        letter-spacing: 0.05em;
        margin-bottom: 0.2rem;
        display: block;
        text-align: left !important;
        width: 100%;
    }
    
    /* Search Bar styling */
    .search-row {
        margin-top: 1rem;
        width: 100%;
    }
    .search-input-wrapper {
        position: relative;
        width: 100%;
    }
    .search-icon {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--muted-foreground);
        pointer-events: none;
    }

    /* Custom Dropdown Styling */
    .custom-dropdown {
        position: relative;
        width: 100%;
    }
    .custom-dropdown-toggle {
        display: flex;
        align-items: center;
        position: relative;
        cursor: pointer;
        width: 100%;
    }
    .custom-dropdown-search {
        width: 100%;
        background-color: var(--background);
        border: 1px solid var(--border);
        color: var(--foreground);
        font-family: inherit;
        font-size: 0.95rem;
        height: 38px;
        padding: 0.5rem 2.5rem 0.5rem 0.75rem;
        border-radius: 6px;
        cursor: pointer;
        outline: none;
        box-sizing: border-box;
        text-align: left;
    }
    .custom-dropdown-search:focus {
        border-color: var(--primary);
    }
    .custom-dropdown-arrow {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--muted-foreground);
        pointer-events: none;
        transition: transform 0.2s;
    }
    .custom-dropdown.open .custom-dropdown-arrow {
        transform: translateY(-50%) rotate(180deg);
    }
    .custom-dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        margin-top: 0.25rem;
        background-color: var(--card);
        border: 1px solid var(--border);
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        max-height: 250px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .custom-dropdown:not(.open) .custom-dropdown-menu {
        display: none;
    }
    .custom-dropdown.open .custom-dropdown-menu {
        display: flex;
    }
    .custom-dropdown-actions {
        display: flex;
        padding: 0.5rem;
        gap: 0.25rem;
        border-bottom: 1px solid var(--border);
        background-color: var(--muted);
        box-sizing: border-box;
    }
    .custom-dropdown-add-input {
        flex: 1;
        background-color: var(--background);
        border: 1px solid var(--border);
        color: var(--foreground);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
        outline: none;
        min-width: 0;
    }
    .custom-dropdown-add-btn {
        background-color: var(--primary);
        color: var(--primary-foreground);
        border: none;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }
    .custom-dropdown-add-btn:hover {
        opacity: 0.9;
    }
    .custom-dropdown-list {
        list-style: none;
        padding: 0;
        margin: 0;
        overflow-y: auto;
        max-height: 180px;
    }
    .custom-dropdown-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        cursor: pointer;
        color: var(--foreground);
        transition: background-color 0.15s;
    }
    .custom-dropdown-item:hover {
        background-color: var(--muted);
    }
    .custom-dropdown-item.active {
        background-color: var(--primary);
        color: var(--primary-foreground);
    }
    .custom-dropdown-delete-btn {
        background: transparent;
        border: none;
        color: var(--muted-foreground);
        cursor: pointer;
        font-size: 1.1rem;
        padding: 0 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        line-height: 1;
        transition: color 0.15s;
    }
    .custom-dropdown-item.active .custom-dropdown-delete-btn {
        color: var(--primary-foreground);
    }
    .custom-dropdown-delete-btn:hover {
        color: #ef4444 !important;
    }
    

    
    @media (max-width: 768px) {
        .search-row {
            flex-direction: column;
            align-items: stretch !important;
            gap: 0.75rem !important;
        }
        .search-row .filter-group {
            width: 100% !important;
        }
    }

    /* Avatar Styling */
    .avatar-wrapper {
        position: relative;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
        background-color: var(--muted);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .student-meta {
        font-size: 0.85rem;
        color: var(--muted-foreground);
        margin: 0.15rem 0 0 0;
    }
    .student-meta span {
        color: var(--foreground);
        font-weight: 500;
    }
    
    .class-badge {
        color: var(--primary);
        font-weight: 700;
        font-size: 0.95rem;
    }
    .roll-badge {
        background-color: var(--accent);
        color: var(--muted-foreground);
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.15rem 0.45rem;
        border-radius: 4px;
        margin-left: 0.5rem;
        text-transform: uppercase;
        border: 1px solid var(--border);
    }
    .academic-details-sub {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem 1rem;
        font-size: 0.825rem;
        color: var(--muted-foreground);
        margin-top: 0.35rem;
    }
    .academic-details-sub span {
        color: var(--foreground);
        font-weight: 500;
        margin-right: 0.25rem;
    }
    @media (max-width: 768px) {
        .card-body-adaptive {
            padding: 1rem !important;
        }
    }

    /* Modal Styling Details */
    .modal-detail-card {
        background: var(--muted);
        padding: 0.75rem;
        border-radius: 6px;
        border: 1px solid var(--border);
    }
    .modal-detail-label {
        color: var(--muted-foreground);
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }
    .modal-detail-value {
        color: var(--foreground);
        font-weight: 600;
    }

    /* Responsive Mobile Box/Card Layout for Table */
    @media (max-width: 768px) {
        #studentTable thead {
            display: none; /* Hide standard headers */
        }
        #studentTable, #studentTable tbody {
            display: block;
            width: 100% !important;
        }
        #studentTable tbody tr {
            display: block;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            position: relative;
            box-sizing: border-box !important;
        }
        #studentTable td {
            display: block;
            padding: 0.5rem 0;
            border: none;
            width: 100% !important;
            text-align: left !important;
        }
        
        /* SL Positioning inside Card Box */
        #studentTable td.sl-column {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            font-size: 0.85rem;
            color: var(--muted-foreground);
            background-color: var(--muted);
            width: 26px !important;
            height: 26px;
            border-radius: 50%;
            display: flex !important;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 1px solid var(--border);
            padding: 0 !important;
        }
        
        /* Left Float for Student Photo on Mobile */
        #studentTable td:nth-child(2) {
            float: left;
            width: 60px !important;
            margin-right: 1rem;
            padding-top: 0;
        }
        
        /* Student Info placed next to floated Photo */
        #studentTable td:nth-child(3) {
            margin-left: 75px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.75rem;
            margin-bottom: 0.75rem;
            min-height: 70px;
            width: calc(100% - 75px) !important;
            box-sizing: border-box !important;
        }
        
        /* Clear float for Academic details */
        #studentTable td:nth-child(4) {
            clear: both;
            padding-top: 0.25rem;
        }
        
        /* Action Buttons styling on mobile */
        #studentTable td:nth-child(5) {
            border-top: 1px solid var(--border);
            padding-top: 0.75rem;
            margin-top: 0.75rem;
        }
        
        #studentTable .action-buttons {
            justify-content: flex-end;
        }
    }
</style>

<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Student Management</h1>
            <p class="page-description">Monitor, filter, and manage registered student accounts.</p>
        </div>
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <button class="btn btn-primary" onclick="alert('Add Student action clicked')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 6px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Add Student
            </button>
            <button class="btn btn-secondary" onclick="exportFilteredStudents()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px; margin-right: 6px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export
            </button>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body" style="padding: 1.25rem;">
        <div class="dropdown-grid">
            <!-- Session -->
            <div class="filter-group">
                <label class="filter-label">Session</label>
                <div class="custom-dropdown" id="sessionDropdown" data-selected-value="">
                    <div class="custom-dropdown-toggle">
                        <input type="text" class="custom-dropdown-search" placeholder="All Sessions" value="All Sessions" readonly>
                        <span class="custom-dropdown-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                    <div class="custom-dropdown-menu">
                        <div class="custom-dropdown-actions">
                            <input type="text" class="custom-dropdown-add-input" placeholder="Type new or search...">
                            <button type="button" class="custom-dropdown-add-btn" title="Add Option">+</button>
                        </div>
                        <ul class="custom-dropdown-list">
                            <li data-value="" class="custom-dropdown-item active">All Sessions</li>
                            <li data-value="2023-2024" class="custom-dropdown-item">
                                <span>2023-2024</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                            <li data-value="2024-2025" class="custom-dropdown-item">
                                <span>2024-2025</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                            <li data-value="2026-2027" class="custom-dropdown-item">
                                <span>2026-2027</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Class -->
            <div class="filter-group">
                <label class="filter-label">Class</label>
                <div class="custom-dropdown" id="classDropdown" data-selected-value="">
                    <div class="custom-dropdown-toggle">
                        <input type="text" class="custom-dropdown-search" placeholder="All Classes" value="All Classes" readonly>
                        <span class="custom-dropdown-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                    <div class="custom-dropdown-menu">
                        <div class="custom-dropdown-actions">
                            <input type="text" class="custom-dropdown-add-input" placeholder="Type new or search...">
                            <button type="button" class="custom-dropdown-add-btn" title="Add Option">+</button>
                        </div>
                        <ul class="custom-dropdown-list">
                            <li data-value="" class="custom-dropdown-item active">All Classes</li>
                            <li data-value="Class One" class="custom-dropdown-item">
                                <span>Class One</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                            <li data-value="Class Two" class="custom-dropdown-item">
                                <span>Class Two</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Branch -->
            <div class="filter-group">
                <label class="filter-label">Branch</label>
                <div class="custom-dropdown" id="branchDropdown" data-selected-value="">
                    <div class="custom-dropdown-toggle">
                        <input type="text" class="custom-dropdown-search" placeholder="All Branches" value="All Branches" readonly>
                        <span class="custom-dropdown-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                    <div class="custom-dropdown-menu">
                        <div class="custom-dropdown-actions">
                            <input type="text" class="custom-dropdown-add-input" placeholder="Type new or search...">
                            <button type="button" class="custom-dropdown-add-btn" title="Add Option">+</button>
                        </div>
                        <ul class="custom-dropdown-list">
                            <li data-value="" class="custom-dropdown-item active">All Branches</li>
                            <li data-value="Main Branch" class="custom-dropdown-item">
                                <span>Main Branch</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Shift -->
            <div class="filter-group">
                <label class="filter-label">Shift</label>
                <div class="custom-dropdown" id="shiftDropdown" data-selected-value="">
                    <div class="custom-dropdown-toggle">
                        <input type="text" class="custom-dropdown-search" placeholder="All Shifts" value="All Shifts" readonly>
                        <span class="custom-dropdown-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                    <div class="custom-dropdown-menu">
                        <div class="custom-dropdown-actions">
                            <input type="text" class="custom-dropdown-add-input" placeholder="Type new or search...">
                            <button type="button" class="custom-dropdown-add-btn" title="Add Option">+</button>
                        </div>
                        <ul class="custom-dropdown-list">
                            <li data-value="" class="custom-dropdown-item active">All Shifts</li>
                            <li data-value="Morning Shift" class="custom-dropdown-item">
                                <span>Morning Shift</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                            <li data-value="Day Shift" class="custom-dropdown-item">
                                <span>Day Shift</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section -->
            <div class="filter-group">
                <label class="filter-label">Section</label>
                <div class="custom-dropdown" id="sectionDropdown" data-selected-value="">
                    <div class="custom-dropdown-toggle">
                        <input type="text" class="custom-dropdown-search" placeholder="All Sections" value="All Sections" readonly>
                        <span class="custom-dropdown-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                    <div class="custom-dropdown-menu">
                        <div class="custom-dropdown-actions">
                            <input type="text" class="custom-dropdown-add-input" placeholder="Type new or search...">
                            <button type="button" class="custom-dropdown-add-btn" title="Add Option">+</button>
                        </div>
                        <ul class="custom-dropdown-list">
                            <li data-value="" class="custom-dropdown-item active">All Sections</li>
                            <li data-value="Section A" class="custom-dropdown-item">
                                <span>Section A</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                            <li data-value="Section B" class="custom-dropdown-item">
                                <span>Section B</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Gender -->
            <div class="filter-group">
                <label class="filter-label">Gender</label>
                <div class="custom-dropdown" id="genderDropdown" data-selected-value="">
                    <div class="custom-dropdown-toggle">
                        <input type="text" class="custom-dropdown-search" placeholder="All Genders" value="All Genders" readonly>
                        <span class="custom-dropdown-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </div>
                    <div class="custom-dropdown-menu">
                        <div class="custom-dropdown-actions">
                            <input type="text" class="custom-dropdown-add-input" placeholder="Type new or search...">
                            <button type="button" class="custom-dropdown-add-btn" title="Add Option">+</button>
                        </div>
                        <ul class="custom-dropdown-list">
                            <li data-value="" class="custom-dropdown-item active">All Genders</li>
                            <li data-value="Male" class="custom-dropdown-item">
                                <span>Male</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                            <li data-value="Female" class="custom-dropdown-item">
                                <span>Female</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search and Sort row -->
        <div class="search-row" style="display: flex; gap: 1rem; align-items: flex-end; width: 100%;">
            <div class="filter-group" style="flex: 1;">
                <label class="filter-label">Search Student</label>
                <div class="search-input-wrapper">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="searchStudent" class="form-input" placeholder="Name, ID or Mobile..." style="padding-left: 2.5rem; width: 100%;">
                </div>
            </div>
            <div class="filter-group" style="width: 150px; flex-shrink: 0;">
                <label class="filter-label">Show List</label>
                <select id="pageSizeSelect" class="form-select" style="height: 38px; width: 100%;">
                    <option value="10">10 Rows</option>
                    <option value="30" selected>30 Rows</option>
                    <option value="50">50 Rows</option>
                    <option value="100">100 Rows</option>
                    <option value="all">All Rows</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-body card-body-adaptive" style="padding: 0;">
        <div class="table-container">
            <table class="table" id="studentTable">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 10%;">Photo</th>
                        <th style="width: 35%;">Student Info</th>
                        <th style="width: 35%;">Academic Details</th>
                        <th style="text-align: right; width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1: Md. Anowar Hossain -->
                    <tr data-name="Md. Anowar Hossain" data-id="24010600441" data-mob="01788428280" data-session="2024-2025" data-class="Class One" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section A" data-gender="Male">
                        <td class="sl-column">1</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <path d="M32 42c8.837 0 16 7.163 16 16H16c0-8.837 7.163-16 16-16z" fill="var(--primary)" opacity="0.85"/>
                                    <circle cx="32" cy="24" r="10" fill="var(--primary)" opacity="0.85"/>
                                    <text x="32" y="36" fill="var(--primary-foreground)" font-size="9" font-family="'Inter', sans-serif" font-weight="bold" text-anchor="middle">Photo</text>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Md. Anowar Hossain') }}</div>
                            <p class="student-meta">ID: <span>24010600441</span></p>
                            <p class="student-meta">Mob: <span>01788428280</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class One</span>
                                <span class="roll-badge">Roll: 41</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Male</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Md. Anowar Hossain')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Md. Anowar Hossain')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2: Sakib Al Hasan -->
                    <tr data-name="Sakib Al Hasan" data-id="STD20260030" data-mob="01943502146" data-session="2023-2024" data-class="Class One" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section A" data-gender="Male">
                        <td class="sl-column">2</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="var(--primary)"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Sakib Al Hasan') }}</div>
                            <p class="student-meta">ID: <span>STD20260030</span></p>
                            <p class="student-meta">Mob: <span>01943502146</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class One</span>
                                <span class="roll-badge">Roll: 30</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Male</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Sakib Al Hasan')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Sakib Al Hasan')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3: Tasnuva Ahmed -->
                    <tr data-name="Tasnuva Ahmed" data-id="STD20260029" data-mob="01999808926" data-session="2024-2025" data-class="Class One" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section A" data-gender="Female">
                        <td class="sl-column">3</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <ellipse cx="32" cy="28" rx="10" ry="12" fill="#fed7aa"/>
                                    <path d="M14 56c0-7 8-11 18-11s18 4 18 11H14z" fill="#be185d"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Tasnuva Ahmed') }}</div>
                            <p class="student-meta">ID: <span>STD20260029</span></p>
                            <p class="student-meta">Mob: <span>01999808926</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class One</span>
                                <span class="roll-badge">Roll: 29</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Female</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Tasnuva Ahmed')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Tasnuva Ahmed')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4: Arifur Rahman -->
                    <tr data-name="Arifur Rahman" data-id="STD20260028" data-mob="01952090912" data-session="2026-2027" data-class="Class One" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section A" data-gender="Male">
                        <td class="sl-column">4</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="#0d9488"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Arifur Rahman') }}</div>
                            <p class="student-meta">ID: <span>STD20260028</span></p>
                            <p class="student-meta">Mob: <span>01952090912</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class One</span>
                                <span class="roll-badge">Roll: 28</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Male</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Arifur Rahman')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Arifur Rahman')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 5: Fiza Rahman -->
                    <tr data-name="Fiza Rahman" data-id="STD20260027" data-mob="01959270550" data-session="2026-2027" data-class="Class One" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section A" data-gender="Female">
                        <td class="sl-column">5</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <ellipse cx="32" cy="28" rx="10" ry="12" fill="#fed7aa"/>
                                    <path d="M14 56c0-7 8-11 18-11s18 4 18 11H14z" fill="#6d28d9"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Fiza Rahman') }}</div>
                            <p class="student-meta">ID: <span>STD20260027</span></p>
                            <p class="student-meta">Mob: <span>01959270550</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class One</span>
                                <span class="roll-badge">Roll: 27</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Female</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Fiza Rahman')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Fiza Rahman')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 6: Kazi Nabil Ahmed -->
                    <tr data-name="Kazi Nabil Ahmed" data-id="STD20260026" data-mob="01712345678" data-session="2023-2024" data-class="Class Two" data-branch="Main Branch" data-shift="Day Shift" data-section="Section B" data-gender="Male">
                        <td class="sl-column">6</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="#0f172a"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Kazi Nabil Ahmed') }}</div>
                            <p class="student-meta">ID: <span>STD20260026</span></p>
                            <p class="student-meta">Mob: <span>01712345678</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class Two</span>
                                <span class="roll-badge">Roll: 12</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section B</span>
                                Shift: <span>Day Shift</span>
                                Gender: <span>Male</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Kazi Nabil')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Kazi Nabil Ahmed')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 7: Nusrat Jahan -->
                    <tr data-name="Nusrat Jahan" data-id="STD20260025" data-mob="01812345678" data-session="2024-2025" data-class="Class Two" data-branch="Main Branch" data-shift="Day Shift" data-section="Section B" data-gender="Female">
                        <td class="sl-column">7</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <ellipse cx="32" cy="28" rx="10" ry="12" fill="#fed7aa"/>
                                    <path d="M14 56c0-7 8-11 18-11s18 4 18 11H14z" fill="#db2777"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Nusrat Jahan') }}</div>
                            <p class="student-meta">ID: <span>STD20260025</span></p>
                            <p class="student-meta">Mob: <span>01812345678</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class Two</span>
                                <span class="roll-badge">Roll: 15</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section B</span>
                                Shift: <span>Day Shift</span>
                                Gender: <span>Female</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Nusrat Jahan')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Nusrat Jahan')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 8: Farhan Tanvir -->
                    <tr data-name="Farhan Tanvir" data-id="STD20260024" data-mob="01512345678" data-session="2026-2027" data-class="Class One" data-branch="Main Branch" data-shift="Day Shift" data-section="Section B" data-gender="Male">
                        <td class="sl-column">8</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="#0284c7"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Farhan Tanvir') }}</div>
                            <p class="student-meta">ID: <span>STD20260024</span></p>
                            <p class="student-meta">Mob: <span>01512345678</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class One</span>
                                <span class="roll-badge">Roll: 20</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section B</span>
                                Shift: <span>Day Shift</span>
                                Gender: <span>Male</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Farhan Tanvir')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Farhan Tanvir')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 9: Sadia Afrin -->
                    <tr data-name="Sadia Afrin" data-id="STD20260023" data-mob="01612345678" data-session="2024-2025" data-class="Class Two" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section A" data-gender="Female">
                        <td class="sl-column">9</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <ellipse cx="32" cy="28" rx="10" ry="12" fill="#fed7aa"/>
                                    <path d="M14 56c0-7 8-11 18-11s18 4 18 11H14z" fill="#4f46e5"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Sadia Afrin') }}</div>
                            <p class="student-meta">ID: <span>STD20260023</span></p>
                            <p class="student-meta">Mob: <span>01612345678</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class Two</span>
                                <span class="roll-badge">Roll: 08</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Female</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Sadia Afrin')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Sadia Afrin')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 10: Abrar Zahin -->
                    <tr data-name="Abrar Zahin" data-id="STD20260022" data-mob="01312345678" data-session="2023-2024" data-class="Class Two" data-branch="Main Branch" data-shift="Day Shift" data-section="Section B" data-gender="Male">
                        <td class="sl-column">10</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="#047857"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Abrar Zahin') }}</div>
                            <p class="student-meta">ID: <span>STD20260022</span></p>
                            <p class="student-meta">Mob: <span>01312345678</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class Two</span>
                                <span class="roll-badge">Roll: 03</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section B</span>
                                Shift: <span>Day Shift</span>
                                Gender: <span>Male</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Abrar Zahin')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Abrar Zahin')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 11: Mehnaz Chowdhury -->
                    <tr data-name="Mehnaz Chowdhury" data-id="STD20260021" data-mob="01412345678" data-session="2026-2027" data-class="Class Two" data-branch="Main Branch" data-shift="Day Shift" data-section="Section B" data-gender="Female">
                        <td class="sl-column">11</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <ellipse cx="32" cy="28" rx="10" ry="12" fill="#fed7aa"/>
                                    <path d="M14 56c0-7 8-11 18-11s18 4 18 11H14z" fill="#ea580c"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Mehnaz Chowdhury') }}</div>
                            <p class="student-meta">ID: <span>STD20260021</span></p>
                            <p class="student-meta">Mob: <span>01412345678</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class Two</span>
                                <span class="roll-badge">Roll: 05</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section B</span>
                                Shift: <span>Day Shift</span>
                                Gender: <span>Female</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Mehnaz Chowdhury')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Mehnaz Chowdhury')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 12: Imtiaz Ahmed -->
                    <tr data-name="Imtiaz Ahmed" data-id="STD20260020" data-mob="01912345678" data-session="2024-2025" data-class="Class One" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section B" data-gender="Male">
                        <td class="sl-column">12</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="#dc2626"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Imtiaz Ahmed') }}</div>
                            <p class="student-meta">ID: <span>STD20260020</span></p>
                            <p class="student-meta">Mob: <span>01912345678</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class One</span>
                                <span class="roll-badge">Roll: 18</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section B</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Male</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Imtiaz Ahmed')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Imtiaz Ahmed')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 13: Jannatul Ferdous -->
                    <tr data-name="Jannatul Ferdous" data-id="STD20260019" data-mob="01787654321" data-session="2023-2024" data-class="Class Two" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section A" data-gender="Female">
                        <td class="sl-column">13</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <ellipse cx="32" cy="28" rx="10" ry="12" fill="#fed7aa"/>
                                    <path d="M14 56c0-7 8-11 18-11s18 4 18 11H14z" fill="#0891b2"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Jannatul Ferdous') }}</div>
                            <p class="student-meta">ID: <span>STD20260019</span></p>
                            <p class="student-meta">Mob: <span>01787654321</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class Two</span>
                                <span class="roll-badge">Roll: 02</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Female</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Jannatul Ferdous')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Jannatul Ferdous')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 14: Tahsan Khan -->
                    <tr data-name="Tahsan Khan" data-id="STD20260018" data-mob="01887654321" data-session="2026-2027" data-class="Class One" data-branch="Main Branch" data-shift="Day Shift" data-section="Section A" data-gender="Male">
                        <td class="sl-column">14</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="#475569"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Tahsan Khan') }}</div>
                            <p class="student-meta">ID: <span>STD20260018</span></p>
                            <p class="student-meta">Mob: <span>01887654321</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class One</span>
                                <span class="roll-badge">Roll: 09</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Day Shift</span>
                                Gender: <span>Male</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Tahsan Khan')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Tahsan Khan')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 15: Sajida Islam -->
                    <tr data-name="Sajida Islam" data-id="STD20260017" data-mob="01587654321" data-session="2024-2025" data-class="Class Two" data-branch="Main Branch" data-shift="Morning Shift" data-section="Section A" data-gender="Female">
                        <td class="sl-column">15</td>
                        <td>
                            <div class="avatar-wrapper">
                                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                    <ellipse cx="32" cy="28" rx="10" ry="12" fill="#fed7aa"/>
                                    <path d="M14 56c0-7 8-11 18-11s18 4 18 11H14z" fill="#059669"/>
                                </svg>
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">{{ __('Sajida Islam') }}</div>
                            <p class="student-meta">ID: <span>STD20260017</span></p>
                            <p class="student-meta">Mob: <span>01587654321</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">Class Two</span>
                                <span class="roll-badge">Roll: 14</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>Section A</span>
                                Shift: <span>Morning Shift</span>
                                Gender: <span>Female</span>
                            </div>
                        </td>
                        <td class="action-column" style="text-align: right;">
                            <div class="action-buttons" style="justify-content: flex-end;">
                                <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn" title="Edit" onclick="alert('Editing Sajida Islam')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, 'Sajida Islam')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
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
    </div>
</div>

<!-- Student Details Popup Modal -->
<div id="studentDetailsModal" class="modal-overlay">
    <div class="modal" style="max-width: 600px; width: 95%;">
        <div class="modal-header">
            <h3 class="modal-title">Student Profile Details</h3>
            <button type="button" class="modal-close" onclick="closeStudentModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div id="modalStudentContent">
                <!-- Content will be dynamically injected here via JS -->
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeStudentModal()">Close</button>
        </div>
    </div>
</div>

<script>
    // JS for details modal popup
    function openStudentModal(studentData) {
        const modal = document.getElementById('studentDetailsModal');
        const content = document.getElementById('modalStudentContent');
        
        content.innerHTML = `
            <div style="display: flex; gap: 1.5rem; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem;">
                <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 2px solid var(--primary); background: var(--muted); display: flex; align-items: center; justify-content: center;">
                    ${studentData.photoHtml}
                </div>
                <div>
                    <h2 style="margin: 0; font-size: 1.4rem; color: var(--foreground); font-weight: 700;">${studentData.name}</h2>
                    <p style="margin: 0.25rem 0 0 0; color: var(--primary); font-weight: 600; font-size: 1rem;">${studentData.className} (Roll: ${studentData.roll})</p>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; font-size: 0.95rem;">
                <div class="modal-detail-card">
                    <strong class="modal-detail-label">Student ID</strong>
                    <span class="modal-detail-value">${studentData.id}</span>
                </div>
                <div class="modal-detail-card">
                    <strong class="modal-detail-label">Mobile Number</strong>
                    <span class="modal-detail-value">${studentData.mob}</span>
                </div>
                <div class="modal-detail-card">
                    <strong class="modal-detail-label">Academic Session</strong>
                    <span class="modal-detail-value">${studentData.session}</span>
                </div>
                <div class="modal-detail-card">
                    <strong class="modal-detail-label">College Branch</strong>
                    <span class="modal-detail-value">${studentData.branch}</span>
                </div>
                <div class="modal-detail-card">
                    <strong class="modal-detail-label">Shift</strong>
                    <span class="modal-detail-value">${studentData.shift}</span>
                </div>
                <div class="modal-detail-card">
                    <strong class="modal-detail-label">Section</strong>
                    <span class="modal-detail-value">${studentData.section}</span>
                </div>
                <div class="modal-detail-card" style="grid-column: span 2;">
                    <strong class="modal-detail-label">Gender</strong>
                    <span class="modal-detail-value">${studentData.gender}</span>
                </div>
            </div>
        `;
        
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeStudentModal() {
        const modal = document.getElementById('studentDetailsModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function viewStudentDetails(button) {
        const row = button.closest('tr');
        const name = row.getAttribute('data-name');
        const id = row.getAttribute('data-id');
        const mob = row.getAttribute('data-mob');
        const session = row.getAttribute('data-session');
        const className = row.getAttribute('data-class');
        const branch = row.getAttribute('data-branch');
        const shift = row.getAttribute('data-shift');
        const section = row.getAttribute('data-section');
        const gender = row.getAttribute('data-gender');
        
        const photoHtml = row.querySelector('.avatar-wrapper').innerHTML;
        
        // Extract roll from the badge text
        const rollBadgeText = row.querySelector('.roll-badge').textContent;
        const roll = rollBadgeText.replace(/Roll:\s*/i, '');
        
        openStudentModal({
            name, id, mob, session, className, branch, shift, section, gender, photoHtml, roll
        });
    }

    // Dynamic row deletion function
    function deleteStudentRow(button, studentName) {
        if (confirm(`Are you sure you want to delete ${studentName}?`)) {
            const row = button.closest('tr');
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '0';
            row.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                row.remove();
                
                // Re-calculate serial numbers for remaining visible rows
                const rows = document.querySelectorAll('#studentTable tbody tr');
                let visibleCount = 0;
                rows.forEach(r => {
                    if (r.style.display !== 'none') {
                        visibleCount++;
                        r.querySelector('.sl-column').textContent = visibleCount;
                    }
                });
                
                // Show empty state if all rows are removed
                if (rows.length === 0) {
                    const tableContainer = document.querySelector('.table-container');
                    tableContainer.innerHTML = `
                        <div class="empty-state">
                            <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="empty-state-title">No students found</h3>
                            <p class="empty-state-description">All student records have been deleted.</p>
                        </div>
                    `;
                }
            }, 300);
        }
    }

    // Close modal on background click
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('studentDetailsModal');
        if (e.target === modal) {
            closeStudentModal();
        }
    });

    // Custom Dropdown Builder & Management
    function initCustomDropdown(containerId, onSelectCallback) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const toggle = container.querySelector('.custom-dropdown-toggle');
        const searchInput = container.querySelector('.custom-dropdown-search');
        const addInput = container.querySelector('.custom-dropdown-add-input');
        const addBtn = container.querySelector('.custom-dropdown-add-btn');
        const list = container.querySelector('.custom-dropdown-list');

        // Toggle open/close
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelectorAll('.custom-dropdown').forEach(d => {
                if (d !== container) d.classList.remove('open');
            });
            container.classList.toggle('open');
            if (container.classList.contains('open')) {
                addInput.focus();
            }
        });

        // Search options inside list
        addInput.addEventListener('input', function() {
            const query = addInput.value.toLowerCase().trim();
            const items = list.querySelectorAll('.custom-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Add custom option
        function addOption() {
            const val = addInput.value.trim();
            if (!val) return;

            let exists = false;
            let existingItem = null;
            list.querySelectorAll('.custom-dropdown-item').forEach(item => {
                if (item.getAttribute('data-value').toLowerCase() === val.toLowerCase()) {
                    exists = true;
                    existingItem = item;
                }
            });

            if (exists) {
                selectItem(existingItem);
            } else {
                const li = document.createElement('li');
                li.className = 'custom-dropdown-item';
                li.setAttribute('data-value', val);
                li.innerHTML = `
                    <span>${val}</span>
                    <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                `;
                
                li.addEventListener('click', function(e) {
                    selectItem(li);
                });

                li.querySelector('.custom-dropdown-delete-btn').addEventListener('click', function(e) {
                    e.stopPropagation();
                    deleteItem(li);
                });

                list.appendChild(li);
                selectItem(li);
            }

            addInput.value = '';
            list.querySelectorAll('.custom-dropdown-item').forEach(item => item.style.display = 'flex');
        }

        addBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            addOption();
        });

        addInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addOption();
            }
        });

        // Select item
        function selectItem(item) {
            list.querySelectorAll('.custom-dropdown-item').forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            
            const displayVal = item.querySelector('span') ? item.querySelector('span').textContent : item.textContent.trim();
            const val = item.getAttribute('data-value');

            searchInput.value = displayVal;
            container.setAttribute('data-selected-value', val);
            container.classList.remove('open');

            if (onSelectCallback) onSelectCallback(val);
        }

        // Attach click listeners to initial items
        list.querySelectorAll('.custom-dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                selectItem(item);
            });

            const delBtn = item.querySelector('.custom-dropdown-delete-btn');
            if (delBtn) {
                delBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    deleteItem(item);
                });
            }
        });

        // Delete option
        function deleteItem(item) {
            if (confirm(`Are you sure you want to delete option "${item.getAttribute('data-value')}"?`)) {
                const isActive = item.classList.contains('active');
                item.remove();

                if (isActive) {
                    const defaultItem = list.querySelector('.custom-dropdown-item[data-value=""]');
                    if (defaultItem) {
                        selectItem(defaultItem);
                    }
                } else {
                    if (onSelectCallback) onSelectCallback();
                }
            }
        }
    }

    // Global Click Away to Close Custom Dropdowns
    document.addEventListener('click', function() {
        document.querySelectorAll('.custom-dropdown').forEach(d => {
            d.classList.remove('open');
        });
    });

    // Filtering mechanism
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchStudent');
        const pageSizeSelect = document.getElementById('pageSizeSelect');
        const tableRows = document.querySelectorAll('#studentTable tbody tr');

        let currentPage = 1;
        let pageSize = 30;

        function filterTable() {
            const searchText = searchInput.value.toLowerCase().trim();
            const sessionVal = document.getElementById('sessionDropdown').getAttribute('data-selected-value') || '';
            const classVal = document.getElementById('classDropdown').getAttribute('data-selected-value') || '';
            const branchVal = document.getElementById('branchDropdown').getAttribute('data-selected-value') || '';
            const shiftVal = document.getElementById('shiftDropdown').getAttribute('data-selected-value') || '';
            const sectionVal = document.getElementById('sectionDropdown').getAttribute('data-selected-value') || '';
            const genderVal = document.getElementById('genderDropdown').getAttribute('data-selected-value') || '';

            // Update pageSize from select element
            const selectedSizeVal = pageSizeSelect.value;
            pageSize = selectedSizeVal === 'all' ? Infinity : parseInt(selectedSizeVal, 10);

            // Phase 1: Determine which rows match the filters
            const matchedRows = [];
            tableRows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const id = row.getAttribute('data-id').toLowerCase();
                const mob = row.getAttribute('data-mob').toLowerCase();
                const session = row.getAttribute('data-session');
                const className = row.getAttribute('data-class');
                const branch = row.getAttribute('data-branch');
                const shift = row.getAttribute('data-shift');
                const section = row.getAttribute('data-section');
                const gender = row.getAttribute('data-gender');

                const matchesSearch = !searchText || 
                                      name.includes(searchText) || 
                                      id.includes(searchText) || 
                                      mob.includes(searchText);
                
                const matchesSession = !sessionVal || session === sessionVal;
                const matchesClass = !classVal || className === classVal;
                const matchesBranch = !branchVal || branch === branchVal;
                const matchesShift = !shiftVal || shift === shiftVal;
                const matchesSection = !sectionVal || section === sectionVal;
                const matchesGender = !genderVal || gender === genderVal;

                if (matchesSearch && matchesSession && matchesClass && matchesBranch && matchesShift && matchesSection && matchesGender) {
                    row.classList.add('matches-filter');
                    matchedRows.push(row);
                } else {
                    row.classList.remove('matches-filter');
                    row.style.display = 'none';
                }
            });

            // Phase 2: Apply pagination to matching rows
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

            // Update pagination info texts
            const startText = totalMatches === 0 ? 0 : startIndex + 1;
            const endText = Math.min(endIndex, totalMatches);
            document.getElementById('paginationStart').textContent = startText;
            document.getElementById('paginationEnd').textContent = endText;
            document.getElementById('paginationTotal').textContent = totalMatches;

            // Render pagination buttons
            renderPaginationButtons(totalPages);
        }

        function renderPaginationButtons(totalPages) {
            const container = document.getElementById('paginationButtons');
            if (!container) return;
            container.innerHTML = '';

            // Prev Button
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

            // Page numbers
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

            // Next Button
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

        // Initialize our 6 custom dropdown filters
        initCustomDropdown('sessionDropdown', filterTable);
        initCustomDropdown('classDropdown', filterTable);
        initCustomDropdown('branchDropdown', filterTable);
        initCustomDropdown('shiftDropdown', filterTable);
        initCustomDropdown('sectionDropdown', filterTable);
        initCustomDropdown('genderDropdown', filterTable);

        searchInput.addEventListener('input', filterTable);
        filterTable(); // Run initially to configure pagination layout
    });

    // Export Filtered Students function (opens new tab with print and download buttons)
    function exportFilteredStudents() {
        const rows = document.querySelectorAll('#studentTable tbody tr');
        const visibleStudents = [];
        
        rows.forEach(row => {
            if (row.classList.contains('matches-filter')) {
                const sl = row.querySelector('.sl-column').textContent.trim();
                const name = row.getAttribute('data-name');
                const id = row.getAttribute('data-id');
                const mob = row.getAttribute('data-mob');
                const session = row.getAttribute('data-session');
                const className = row.getAttribute('data-class');
                const branch = row.getAttribute('data-branch');
                const shift = row.getAttribute('data-shift');
                const section = row.getAttribute('data-section');
                const gender = row.getAttribute('data-gender');
                
                const rollBadge = row.querySelector('.roll-badge');
                const roll = rollBadge ? rollBadge.textContent.replace(/Roll:\s*/i, '').trim() : '';
                
                visibleStudents.push({
                    sl, name, id, mob, session, className, branch, shift, section, gender, roll
                });
            }
        });

        if (visibleStudents.length === 0) {
            alert("No students to export!");
            return;
        }

        const sessionVal = document.getElementById('sessionDropdown').getAttribute('data-selected-value') || 'All';
        const classVal = document.getElementById('classDropdown').getAttribute('data-selected-value') || 'All';
        const branchVal = document.getElementById('branchDropdown').getAttribute('data-selected-value') || 'All';
        const shiftVal = document.getElementById('shiftDropdown').getAttribute('data-selected-value') || 'All';
        const sectionVal = document.getElementById('sectionDropdown').getAttribute('data-selected-value') || 'All';
        const genderVal = document.getElementById('genderDropdown').getAttribute('data-selected-value') || 'All';
        const searchVal = document.getElementById('searchStudent').value.trim() || 'None';

        let tableRowsHtml = '';
        visibleStudents.forEach((st, idx) => {
            tableRowsHtml += `
                <tr>
                    <td>${idx + 1}</td>
                    <td>
                        <div class="student-name">${st.name}</div>
                        <div class="student-detail">ID: ${st.id}</div>
                        <div class="student-detail">Mob: ${st.mob}</div>
                    </td>
                    <td>
                        <div class="student-name">${st.className}</div>
                        <div class="student-detail">Roll: ${st.roll}</div>
                    </td>
                    <td>
                        <div class="student-detail">Branch: ${st.branch}</div>
                        <div class="student-detail">Shift: ${st.shift}</div>
                        <div class="student-detail">Sec: ${st.section}</div>
                        <div class="student-detail">Gender: ${st.gender}</div>
                    </td>
                </tr>
            `;
        });

        const exportWindow = window.open('', '_blank');
        exportWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Exported Students List - SS Music College</title>
                <style>
                    @import url('https://fonts.googleapis.com/css?family=Inter:400,500,600,700&display=swap');
                    body {
                        font-family: 'Inter', sans-serif;
                        color: #1e293b;
                        background-color: #ffffff;
                        margin: 0;
                        padding: 2rem;
                    }
                    .header {
                        border-bottom: 2px solid #e2e8f0;
                        padding-bottom: 1.5rem;
                        margin-bottom: 1.5rem;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }
                    .logo-section {
                        display: flex;
                        align-items: center;
                        gap: 1rem;
                    }
                    .logo-img {
                        width: 50px;
                        height: 50px;
                    }
                    .title {
                        font-size: 1.5rem;
                        font-weight: 700;
                        color: #0f172a;
                        margin: 0;
                    }
                    .subtitle {
                        font-size: 0.875rem;
                        color: #64748b;
                        margin: 0.25rem 0 0 0;
                    }
                    .action-bar {
                        display: flex;
                        gap: 0.75rem;
                        margin-bottom: 1.5rem;
                    }
                    .btn {
                        padding: 0.5rem 1rem;
                        font-size: 0.875rem;
                        font-weight: 500;
                        border-radius: 6px;
                        border: 1px solid #cbd5e1;
                        background-color: #ffffff;
                        cursor: pointer;
                        display: inline-flex;
                        align-items: center;
                        gap: 0.5rem;
                        color: #334155;
                        transition: all 0.15s ease;
                    }
                    .btn:hover {
                        background-color: #f8fafc;
                        border-color: #94a3b8;
                    }
                    .btn-primary {
                        background-color: #0f172a;
                        color: #ffffff;
                        border-color: #0f172a;
                    }
                    .btn-primary:hover {
                        background-color: #1e293b;
                    }
                    .filter-summary {
                        background-color: #f8fafc;
                        border: 1px solid #e2e8f0;
                        border-radius: 8px;
                        padding: 1rem;
                        margin-bottom: 1.5rem;
                        font-size: 0.85rem;
                        color: #475569;
                        display: grid;
                        grid-template-columns: repeat(4, 1fr);
                        gap: 0.5rem 1rem;
                    }
                    .filter-item strong {
                        color: #0f172a;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        font-size: 0.9rem;
                        margin-bottom: 2rem;
                    }
                    th, td {
                        border: 1px solid #e2e8f0;
                        padding: 0.75rem 1rem;
                        text-align: left;
                    }
                    th {
                        background-color: #f1f5f9;
                        color: #1e293b;
                        font-weight: 600;
                    }
                    .student-name {
                        font-weight: 600;
                        color: #0f172a;
                    }
                    .student-detail {
                        font-size: 0.775rem;
                        color: #64748b;
                        margin-top: 0.15rem;
                    }
                    @media print {
                        .action-bar {
                            display: none !important;
                        }
                        body {
                            padding: 0;
                        }
                        th {
                            background-color: #f1f5f9 !important;
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }
                        table {
                            page-break-inside: auto;
                        }
                        tr {
                            page-break-inside: avoid;
                            page-break-after: auto;
                        }
                        thead {
                            display: table-header-group;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="logo-section">
                        <img src="${window.location.origin}/assets/image/logo.png" class="logo-img" alt="Logo">
                        <div>
                            <h1 class="title">SS Music College</h1>
                            <p class="subtitle">Registered Students List Report</p>
                        </div>
                    </div>
                    <div class="subtitle" style="text-align: right;">
                        Generated: ${new Date().toLocaleDateString()}<br>
                        Records: ${visibleStudents.length}
                    </div>
                </div>

                <div class="action-bar">
                    <button class="btn btn-primary" onclick="window.print()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.617 0-1.11-.461-1.12-1.079L6.34 18m11.32 0h-11.32M9 10.5h.008v.008H9V10.5zm3 0h.008v.008H12V10.5zm3 0h.008v.008H15V10.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        Print Report
                    </button>
                    <button class="btn" onclick="window.print()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download PDF (Save as PDF)
                    </button>
                    <button class="btn" onclick="exportToCSV()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download CSV
                    </button>
                </div>



                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;">SL</th>
                            <th style="width: 45%;">Student Details</th>
                            <th style="width: 25%;">Class & Roll</th>
                            <th style="width: 25%;">Academic Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRowsHtml}
                    </tbody>
                </table>

                <script>
                    function exportToCSV() {
                        const data = [
                            ['SL', 'Student Name', 'Student ID', 'Mobile', 'Class', 'Roll', 'Session', 'Branch', 'Shift', 'Section', 'Gender']
                        ];
                        
                        const rows = document.querySelectorAll('table tbody tr');
                        rows.forEach((r, idx) => {
                            const sl = idx + 1;
                            const name = r.querySelector('.student-name').textContent.trim();
                            const details = r.querySelectorAll('.student-detail');
                            const id = details[0].textContent.replace('ID:', '').trim();
                            const mob = details[1].textContent.replace('Mob:', '').trim();
                            
                            const className = r.querySelector('td:nth-child(3) .student-name').textContent.trim();
                            const roll = r.querySelector('td:nth-child(3) .student-detail').textContent.replace('Roll:', '').trim();
                            
                            const acDetails = r.querySelectorAll('td:nth-child(4) .student-detail');
                            const branch = acDetails[0].textContent.replace('Branch:', '').trim();
                            const shift = acDetails[1].textContent.replace('Shift:', '').trim();
                            const section = acDetails[2].textContent.replace('Sec:', '').trim();
                            const gender = acDetails[3].textContent.replace('Gender:', '').trim();
                            const session = "${sessionVal}";
                            
                            data.push([sl, name, id, mob, className, roll, session, branch, shift, section, gender]);
                        });

                        let csvContent = "";
                        data.forEach(row => {
                            const formattedRow = row.map(val => '"' + val.replace(/"/g, '""') + '"').join(',');
                            csvContent += formattedRow + "\r\n";
                        });

                        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement("a");
                        link.setAttribute("href", url);
                        link.setAttribute("download", "exported_students_list_" + new Date().toISOString().slice(0, 10) + ".csv");
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);
                    }
                ${'</' + 'script>'}
            </body>
            </html>
        `);
        exportWindow.document.close();
    }
</script>
@endsection
