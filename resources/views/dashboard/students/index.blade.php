@extends('tyro-dashboard::layouts.admin')
@section('title', 'Student Management')

@section('breadcrumb')
<a href="{{ route($dashboardRoute::name('index')) }}">Dashboard</a>
<span class="breadcrumb-separator">/</span>
<span id="breadcrumb-student-parent">Students</span>
<span id="breadcrumb-student-child" style="display: none;"><span class="breadcrumb-separator">/ </span><span> Add Student</span></span>
@endsection

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Custom Styles for Filter Layout, Avatars & Mobile Cards -->
<style>
    /* Premium flatpickr calendar customization */
    .flatpickr-calendar {
        background: var(--card) !important;
        border: 1px solid var(--border) !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -4px rgba(0, 0, 0, 0.3) !important;
        border-radius: 8px !important;
        font-family: 'Outfit', sans-serif !important;
    }
    .flatpickr-calendar .flatpickr-months .flatpickr-month {
        background: transparent !important;
        color: var(--foreground) !important;
    }
    .flatpickr-calendar .flatpickr-current-month,
    .flatpickr-calendar .flatpickr-current-month .numInputWrapper span,
    .flatpickr-calendar .flatpickr-monthDropdown-months {
        color: var(--foreground) !important;
        fill: var(--foreground) !important;
    }
    .flatpickr-calendar .flatpickr-monthDropdown-months option {
        background: var(--card) !important;
        color: var(--foreground) !important;
    }
    .flatpickr-calendar .flatpickr-weekdays {
        background: transparent !important;
    }
    .flatpickr-calendar span.flatpickr-weekday {
        color: var(--muted-foreground) !important;
        font-weight: 600 !important;
    }
    .flatpickr-calendar .flatpickr-day {
        color: var(--foreground) !important;
        border-radius: 6px !important;
    }
    .flatpickr-calendar .flatpickr-day.prevMonthDay,
    .flatpickr-calendar .flatpickr-day.nextMonthDay {
        color: var(--muted-foreground) !important;
        opacity: 0.35;
    }
    .flatpickr-calendar .flatpickr-day:hover,
    .flatpickr-calendar .flatpickr-day:focus {
        background: var(--muted) !important;
        border-color: var(--border) !important;
        color: var(--foreground) !important;
    }
    .flatpickr-calendar .flatpickr-day.today {
        border-color: var(--primary) !important;
        font-weight: 700 !important;
    }
    .flatpickr-calendar .flatpickr-day.today:hover {
        background: var(--muted) !important;
        color: var(--foreground) !important;
    }
    .flatpickr-calendar .flatpickr-day.selected,
    .flatpickr-calendar .flatpickr-day.selected:hover,
    .flatpickr-calendar .flatpickr-day.selected:focus {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
    }
    .flatpickr-calendar .flatpickr-months .flatpickr-prev-month,
    .flatpickr-calendar .flatpickr-months .flatpickr-next-month {
        color: var(--foreground) !important;
        fill: var(--foreground) !important;
    }
    .flatpickr-calendar .flatpickr-months .flatpickr-prev-month:hover,
    .flatpickr-calendar .flatpickr-months .flatpickr-next-month:hover {
        color: var(--primary) !important;
    }
    .flatpickr-calendar .flatpickr-months .flatpickr-prev-month svg,
    .flatpickr-calendar .flatpickr-months .flatpickr-next-month svg {
        fill: currentColor !important;
    }

    /* Passport Size Photo Upload interactive styles */
    .photo-upload-box {
        width: 130px;
        height: 160px;
        border: 2px dashed var(--border);
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
        background-color: var(--muted);
        position: relative;
        transition: all 0.2s ease-in-out;
        box-sizing: border-box;
    }
    .photo-upload-box:hover {
        border-color: var(--primary);
        background-color: rgba(99, 102, 241, 0.05); /* indigo hue */
    }
    .photo-upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Passing Details Table */
    .passing-details-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .passing-details-table th, .passing-details-table td {
        border: 1px solid var(--border);
        padding: 0.6rem;
        text-align: center;
    }
    .passing-details-table th {
        background-color: var(--muted);
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--foreground);
    }
    .passing-details-table td input {
        width: 100%;
        border: 1px solid var(--border);
        background-color: var(--background);
        color: var(--foreground);
        padding: 0.45rem;
        border-radius: 4px;
        text-align: center;
        font-size: 0.85rem;
        box-sizing: border-box;
        outline: none;
    }
    .passing-details-table td input:focus {
        border-color: var(--primary);
    }

    /* Checkbox list and Subject selection */
    .subject-checkbox-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    .subject-checkbox-card {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background-color: var(--muted);
        border: 1px solid var(--border);
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        user-select: none;
    }
    .subject-checkbox-card:hover:not(.disabled) {
        border-color: var(--primary);
        background-color: rgba(99, 102, 241, 0.02);
    }
    .subject-checkbox-card.selected {
        border-color: var(--primary);
        background-color: rgba(99, 102, 241, 0.08);
    }
    .subject-checkbox-card.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .subject-checkbox-card input[type="checkbox"] {
        width: 16px;
        height: 16px;
        margin: 0;
        cursor: pointer;
    }

    /* Form Top Layout */
    .form-top-layout-grid {
        display: grid;
        grid-template-columns: 180px 1fr 340px;
        gap: 1.5rem;
        align-items: start;
    }
    @media (max-width: 992px) {
        .form-top-layout-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Dropdown Grid Layout */
    .dropdown-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 columns layout */
        gap: 0.75rem;
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
    

    /* Export Dropdown */
    .export-dropdown-wrapper {
        position: relative;
        display: inline-block;
    }
    .export-dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        min-width: 185px;
        background-color: var(--card);
        border: 1px solid var(--border);
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        z-index: 2000;
        overflow: hidden;
        animation: exportDropdownIn 0.15s ease;
    }
    .export-dropdown-menu.open {
        display: block;
    }
    @keyframes exportDropdownIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .export-dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        width: 100%;
        padding: 0.6rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--foreground);
        background: transparent;
        border: none;
        cursor: pointer;
        text-align: left;
        transition: background-color 0.15s;
    }
    .export-dropdown-item:hover {
        background-color: var(--muted);
    }
    .export-dropdown-item + .export-dropdown-item {
        border-top: 1px solid var(--border);
    }
    #exportChevron {
        transition: transform 0.2s ease;
    }
    #exportChevron.rotated {
        transform: rotate(180deg);
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

    /* Premium Form Styling */
    .form-container-card {
        background-color: var(--card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        color: var(--foreground);
        margin-bottom: 2rem;
    }
    .form-heading-main {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
        border-bottom: 2px solid var(--border);
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--foreground);
        margin-top: 1.75rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px solid var(--border);
        text-transform: uppercase;
        letter-spacing: 0.03em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .form-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) {
        .form-grid, .form-grid-3, .form-grid-4 {
            grid-template-columns: 1fr;
        }
        .form-container-card {
            padding: 1.25rem;
        }
    }
    .form-input-label {
        font-size: 0.825rem;
        font-weight: 600;
        color: var(--muted-foreground);
        margin-bottom: 0.35rem;
        display: block;
    }
    .form-input-field {
        width: 100%;
        background-color: var(--background);
        border: 1px solid var(--border);
        color: var(--foreground);
        padding: 0.6rem 0.85rem;
        border-radius: 6px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
        font-size: 0.95rem;
    }
    .form-input-field:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .form-select-field {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 2rem;
    }
    .form-checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--muted-foreground);
        cursor: pointer;
        margin-top: 0.5rem;
    }
    .form-checkbox-input {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
    }
    .form-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
    }
    .form-table th, .form-table td {
        border: 1px solid var(--border);
        padding: 0.75rem;
        text-align: left;
    }
    .form-table th {
        background-color: var(--muted);
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--muted-foreground);
        text-transform: uppercase;
    }
    .form-button-row {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        border-top: 1px solid var(--border);
        padding-top: 1.5rem;
        margin-top: 2rem;
    }
    .required-star {
        color: #ef4444;
        margin-left: 0.15rem;
    }
    /* Section specific styles */
    .optional-subjects-wrapper {
        background-color: var(--muted);
        padding: 1.25rem;
        border-radius: 8px;
        border: 1px solid var(--border);
        margin-top: 1rem;
    }
    /* Form section heading — consistent with dashboard card style */
    .form-section-heading {
        font-size: 1rem;
        font-weight: 700;
        color: var(--foreground);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.85rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid var(--border);
    }
    .form-section-heading svg {
        color: var(--primary);
    }
    /* Sub-section label (like "বর্তমান ঠিকানা") */
    .form-sub-section-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--muted-foreground);
        margin-bottom: 0.85rem;
        margin-top: 1.25rem;
    }
    .form-select-field option {
        background-color: var(--card) !important;
        color: var(--foreground) !important;
    }
</style>


<div id="mainListPage">
<div class="page-header">
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Student Management</h1>
            <p class="page-description">Monitor, filter, and manage registered student accounts.</p>
        </div>
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <button class="btn btn-primary" onclick="showAddStudentPage()">
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
                            <li data-value="11th Class" class="custom-dropdown-item">
                                <span>11th Class</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                            <li data-value="12th Class" class="custom-dropdown-item">
                                <span>12th Class</span>
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
                            <li data-value="Humanities" class="custom-dropdown-item">
                                <span>Humanities</span>
                                <button type="button" class="custom-dropdown-delete-btn" title="Delete Option">&times;</button>
                            </li>
                            <li data-value="Music" class="custom-dropdown-item">
                                <span>Music</span>
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
</div> <!-- Closing mainListPage -->


<!-- New Student Registration Page -->
<div id="addStudentPage" style="display: none;">

    <!-- Responsive styles for Photo + Office layout -->
    <style>
        .photo-office-grid {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 1.5rem;
            align-items: stretch;
        }
        .photo-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        .photo-col .photo-upload-box-tall {
            flex: 1;
            width: 100%;
            min-height: 160px;
            cursor: pointer;
            border: 2px dashed var(--border);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: var(--muted);
            transition: border-color 0.2s, background 0.2s;
            position: relative;
            overflow: hidden;
        }
        .photo-col .photo-upload-box-tall:hover {
            border-color: var(--primary);
            background: color-mix(in srgb, var(--primary) 8%, var(--muted));
        }
        .office-col {
            background: var(--muted);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
        }
        .office-fields-grid {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            align-content: start;
        }
        @media (max-width: 768px) {
            .photo-office-grid {
                grid-template-columns: 1fr;
            }
            .photo-col .photo-upload-box-tall {
                min-height: 130px;
            }
            .office-fields-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .office-fields-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Photo + Office Box Card -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body" style="padding: 1.5rem;">
            <div class="photo-office-grid">

                <!-- Passport Photo Upload -->
                <div class="photo-col">
                    <h3 style="font-size: 0.85rem; font-weight: 700; color: var(--foreground); margin: 0; text-align: center; white-space: nowrap; padding: 0 0 0.4rem 0; border-bottom: 1px solid var(--border); width: 100%;">Passport Size Photo</h3>
                    <div id="photo_preview" class="photo-upload-box-tall" onclick="document.getElementById('passport_photo').click()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width: 36px; height: 36px; color: var(--muted-foreground); flex-shrink: 0;">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span style="font-size: 0.72rem; font-weight: 600; color: var(--muted-foreground); text-align: center; line-height: 1.4;">Upload<br>Photo</span>
                    </div>
                    <input type="file" id="passport_photo" accept="image/*" style="display: none;" onchange="handlePhotoUpload(event)">
                </div>

                <!-- Office Use Only Box -->
                <div class="office-col">
                    <div style="font-weight: 800; font-size: 1rem; color: var(--primary); border-bottom: 2px solid var(--border); padding-bottom: 0.6rem; margin-bottom: 1rem; text-align: center; letter-spacing: 0.04em;">
                        Office Use Only:
                    </div>
                    <div class="office-fields-grid">
                        <div>
                            <label class="form-input-label">Class</label>
                            <select id="office_class" class="form-input-field form-select-field" onchange="syncOfficeClass(this)">
                                <option value="11th Class">11th Class</option>
                                <option value="12th Class">12th Class</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-input-label">Section / Group</label>
                            <select id="office_section" class="form-input-field form-select-field" onchange="syncDesiredBranch(this)">
                                <option value="Humanities">Humanities</option>
                                <option value="Music">Music</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-input-label">Roll No.</label>
                            <input type="text" id="office_roll" class="form-input-field" placeholder="e.g. 101">
                        </div>
                        <div>
                            <label class="form-input-label">Academic Year</label>
                            <select id="office_session" class="form-input-field form-select-field">
                                <option value="2024-2025">2024-2025</option>
                                <option value="2023-2024">2023-2024</option>
                                <option value="2026-2027">2026-2027</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-input-label">Admission Date</label>
                            <div style="position: relative;">
                                <input type="text" id="office_admission_date" class="form-input-field" style="padding-right: 2.5rem;" placeholder="Select Date">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Registration Form -->

    <form id="addStudentForm" onsubmit="handleAddStudentSubmit(event)">

        <!-- Main Form Fields (1 to 15) -->
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-body" style="padding: 1.5rem;">
                <h2 class="form-section-heading">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Admission Application Form
                </h2>

                <!-- 1. Student Name (Bengali & English) -->
                <div class="form-grid" style="margin-top: 1rem;">
                    <div>
                        <label class="form-input-label">1. Student Name (Bengali)<span class="required-star">*</span></label>
                        <input type="text" id="student_name_bn" class="form-input-field" placeholder="Enter student's full name in Bengali" required>
                    </div>
                    <div>
                        <label class="form-input-label">Student Name (English CAPITAL LETTER)<span class="required-star">*</span></label>
                        <input type="text" id="student_name_en" class="form-input-field" placeholder="English CAPITAL LETTER name" required>
                    </div>
                </div>

                <!-- 2. Father's Name (Bengali & English) -->
                <div class="form-grid">
                    <div>
                        <label class="form-input-label">2. Father's Name (Bengali)<span class="required-star">*</span></label>
                        <input type="text" id="father_name_bn" class="form-input-field" placeholder="Enter father's name in Bengali" required>
                    </div>
                    <div>
                        <label class="form-input-label">Father's Name (English)<span class="required-star">*</span></label>
                        <input type="text" id="father_name_en" class="form-input-field" placeholder="Father's name in English" required>
                    </div>
                </div>

                <!-- 3. Mother's Name (Bengali & English) -->
                <div class="form-grid">
                    <div>
                        <label class="form-input-label">3. Mother's Name (Bengali)<span class="required-star">*</span></label>
                        <input type="text" id="mother_name_bn" class="form-input-field" placeholder="Enter mother's name in Bengali" required>
                    </div>
                    <div>
                        <label class="form-input-label">Mother's Name (English)<span class="required-star">*</span></label>
                        <input type="text" id="mother_name_en" class="form-input-field" placeholder="Mother's name in English" required>
                    </div>
                </div>

                <!-- 4. Current Address -->
                <p class="form-sub-section-label" style="font-weight: 700; margin-top: 1.5rem; color: var(--foreground);">4. Current Address:</p>
                <div class="form-grid-4">
                    <div>
                        <label class="form-input-label">Village/Street<span class="required-star">*</span></label>
                        <input type="text" id="current_village" class="form-input-field" placeholder="e.g. Shalgaria" required>
                    </div>
                    <div>
                        <label class="form-input-label">Post Office<span class="required-star">*</span></label>
                        <input type="text" id="current_post" class="form-input-field" placeholder="e.g. Pabna" required>
                    </div>
                    <div>
                        <label class="form-input-label">Upazila<span class="required-star">*</span></label>
                        <input type="text" id="current_upazila" class="form-input-field" placeholder="e.g. Pabna Sadar" required>
                    </div>
                    <div>
                        <label class="form-input-label">District<span class="required-star">*</span></label>
                        <input type="text" id="current_district" class="form-input-field" placeholder="e.g. Pabna" required>
                    </div>
                </div>

                <!-- 5. Permanent Address -->
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 0.75rem; margin-top: 1.5rem; flex-wrap:wrap; gap:0.5rem;">
                    <p class="form-sub-section-label" style="margin-bottom:0; font-weight: 700; color: var(--foreground);">5. Permanent Address:</p>
                    <label class="form-checkbox-label">
                        <input type="checkbox" id="same_address_check" class="form-checkbox-input" onchange="copyCurrentAddress()">
                        <span>Same as Current Address</span>
                    </label>
                </div>
                <div class="form-grid-4">
                    <div>
                        <label class="form-input-label">Village/Street<span class="required-star">*</span></label>
                        <input type="text" id="permanent_village" class="form-input-field" placeholder="Village/Street" required>
                    </div>
                    <div>
                        <label class="form-input-label">Post Office<span class="required-star">*</span></label>
                        <input type="text" id="permanent_post" class="form-input-field" placeholder="Post Office" required>
                    </div>
                    <div>
                        <label class="form-input-label">Upazila<span class="required-star">*</span></label>
                        <input type="text" id="permanent_upazila" class="form-input-field" placeholder="Upazila" required>
                    </div>
                    <div>
                        <label class="form-input-label">District<span class="required-star">*</span></label>
                        <input type="text" id="permanent_district" class="form-input-field" placeholder="District" required>
                    </div>
                </div>

                <!-- 6. Guardian (In absence of father) -->
                <div class="form-grid" style="margin-top: 1.5rem;">
                    <div>
                        <label class="form-input-label">6. Father/Guardian Name (in absence of father)</label>
                        <input type="text" id="guardian_name" class="form-input-field" placeholder="e.g. Uncle's or Mother's name">
                    </div>
                </div>

                <!-- 7. Guardian Address -->
                <p class="form-sub-section-label" style="font-weight: 700; margin-top: 1.5rem; color: var(--foreground);">7. Guardian Address:</p>
                <div class="form-grid-4">
                    <div>
                        <label class="form-input-label">Village/Street</label>
                        <input type="text" id="guardian_village" class="form-input-field" placeholder="Village/Street">
                    </div>
                    <div>
                        <label class="form-input-label">Post Office</label>
                        <input type="text" id="guardian_post" class="form-input-field" placeholder="Post Office">
                    </div>
                    <div>
                        <label class="form-input-label">Upazila</label>
                        <input type="text" id="guardian_upazila" class="form-input-field" placeholder="Upazila">
                    </div>
                    <div>
                        <label class="form-input-label">District</label>
                        <input type="text" id="guardian_district" class="form-input-field" placeholder="District">
                    </div>
                </div>

                <!-- 8. Profession & Income -->
                <div class="form-grid" style="margin-top: 1.5rem;">
                    <div>
                        <label class="form-input-label">8. Occupation of Father/Husband/Guardian</label>
                        <input type="text" id="guardian_occupation" class="form-input-field" placeholder="e.g. Business, Service">
                    </div>
                    <div>
                        <label class="form-input-label">Annual Income (BDT)<span class="required-star">*</span></label>
                        <input type="number" id="annual_income" class="form-input-field" placeholder="e.g. 250000" required>
                    </div>
                </div>

                <!-- 9. Nationality, Religion, Community & Gender -->
                <div class="form-grid-4" style="margin-top: 1.5rem;">
                    <div>
                        <label class="form-input-label">9. Nationality</label>
                        <input type="text" id="student_nationality" class="form-input-field" value="Bangladeshi">
                    </div>
                    <div>
                        <label class="form-input-label">Religion<span class="required-star">*</span></label>
                        <select id="student_religion" class="form-input-field form-select-field" required>
                            <option value="Islam">Islam</option>
                            <option value="Hinduism">Hinduism</option>
                            <option value="Christianity">Christianity</option>
                            <option value="Buddhism">Buddhism</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-input-label">Community</label>
                        <input type="text" id="student_community" class="form-input-field" placeholder="e.g. General / Tribal">
                    </div>
                    <div>
                        <label class="form-input-label">Gender<span class="required-star">*</span></label>
                        <select id="student_gender" class="form-input-field form-select-field" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- 10. Date of Birth -->
                <div class="form-grid" style="margin-top: 1.5rem;">
                    <div>
                        <label class="form-input-label">10. Date of Birth (According to SSC/Equivalent certificate)<span class="required-star">*</span></label>
                        <input type="text" id="student_dob" class="form-input-field" placeholder="Select Date of Birth" required>
                    </div>
                </div>

                <!-- 11. SSC Registration & Session -->
                <div class="form-grid" style="margin-top: 1.5rem;">
                    <div>
                        <label class="form-input-label">11. SSC/Equivalent Exam Registration Number<span class="required-star">*</span></label>
                        <input type="text" id="ssc_reg_no" class="form-input-field" placeholder="10 digit registration number" required>
                    </div>
                    <div>
                        <label class="form-input-label">Academic Session<span class="required-star">*</span></label>
                        <input type="text" id="ssc_session" class="form-input-field" placeholder="e.g. 2021-2022" required>
                    </div>
                </div>

                <!-- 12. SSC passing details table -->
                <div style="margin-top: 1.5rem;">
                    <p class="form-sub-section-label" style="font-weight: 700; margin-bottom: 0.5rem; color: var(--foreground);">12. Academic Passing Details:</p>
                    <table class="passing-details-table">
                        <thead>
                            <tr>
                                <th>Exam Name</th>
                                <th>Board Name</th>
                                <th>Exam Center</th>
                                <th>Roll No.</th>
                                <th>Year</th>
                                <th>GPA / Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-weight: 700; background-color: var(--muted); font-size: 0.9rem;">SSC / Equivalent</td>
                                <td><input type="text" id="ssc_board" placeholder="e.g. Rajshahi" required></td>
                                <td><input type="text" id="ssc_center" placeholder="e.g. Pabna-1" required></td>
                                <td><input type="text" id="ssc_roll" placeholder="e.g. 123456" required></td>
                                <td><input type="text" id="ssc_year" placeholder="e.g. 2023" required></td>
                                <td><input type="text" id="ssc_grade" placeholder="e.g. 5.00" required></td>
                            </tr>
                        </tbody>
                    </table>
                </div>                <!-- 13. Previous School info -->
                <p class="form-sub-section-label" style="font-weight: 700; margin-top: 1.5rem; color: var(--foreground);">13. Name & Address of the Institution Last Attended:</p>
                <div class="form-grid-4">
                    <div style="grid-column: span 2;">
                        <label class="form-input-label">(a) Institution Name<span class="required-star">*</span></label>
                        <input type="text" id="prev_inst_name" class="form-input-field" placeholder="Enter school name" required>
                    </div>
                    <div>
                        <label class="form-input-label">(b) Post Office<span class="required-star">*</span></label>
                        <input type="text" id="prev_inst_post" class="form-input-field" placeholder="Post Office" required>
                    </div>
                    <div>
                        <label class="form-input-label">(c) Upazila<span class="required-star">*</span></label>
                        <input type="text" id="prev_inst_upazila" class="form-input-field" placeholder="Upazila" required>
                    </div>
                </div>
                <div class="form-grid-4" style="margin-top: 0.5rem;">
                    <div>
                        <label class="form-input-label">(d) District<span class="required-star">*</span></label>
                        <input type="text" id="prev_inst_district" class="form-input-field" placeholder="District" required>
                    </div>
                </div>

                <!-- 14. Branch choice -->
                <div class="form-grid" style="margin-top: 1.5rem;">
                    <div>
                        <label class="form-input-label">14. Class to which admission is sought</label>
                        <input type="text" id="desired_class" class="form-input-field" value="11th Class" readonly style="background-color: var(--muted); cursor: not-allowed;">
                    </div>
                    <div>
                        <label class="form-input-label">Section / Group (Humanities/Music)<span class="required-star">*</span></label>
                        <select id="desired_branch" class="form-input-field form-select-field" onchange="syncOfficeSection(this)" required>
                            <option value="Humanities">Humanities</option>
                            <option value="Music">Music</option>
                        </select>
                    </div>
                </div>

                <!-- 15. Optional Subjects Choice Wrapper -->
                <div style="margin-top: 1.5rem;">
                    <p class="form-sub-section-label" style="font-weight: 700; color: var(--foreground);">15. Course Subjects: (Elective subjects will be chosen voluntarily)</p>
                    
                    <div id="subjectWrapper" style="border: 1px solid var(--border); border-radius: 8px; padding: 1.25rem; background-color: rgba(99, 102, 241, 0.01);">
                        
                        <!-- Humanities Subject List -->
                        <div id="humanitiesSubjects">
                            <div style="font-size:0.9rem; margin-bottom: 1rem;">
                                <span style="font-weight:700; color: var(--foreground);">(a) Compulsory Subjects:</span> 
                                <span class="badge" style="background-color:var(--muted); color:var(--foreground); padding:0.3rem 0.6rem; border-radius:4px; font-size:0.85rem; margin-right:0.3rem;">Bengali</span>
                                <span class="badge" style="background-color:var(--muted); color:var(--foreground); padding:0.3rem 0.6rem; border-radius:4px; font-size:0.85rem; margin-right:0.3rem;">English</span>
                                <span class="badge" style="background-color:var(--muted); color:var(--foreground); padding:0.3rem 0.6rem; border-radius:4px; font-size:0.85rem; margin-right:0.3rem;">ICT</span>
                            </div>
                            
                            <div style="margin-bottom: 1rem;">
                                <label class="form-input-label" style="font-weight: 700; color: var(--foreground);">
                                    (b) Elective Subjects (Select any three): <span style="color:var(--primary); font-size:0.8rem;">(Maximum 3 choices)</span>
                                </label>
                                <div class="subject-checkbox-grid">
                                    <label class="subject-checkbox-card" id="card_hum_eco">
                                        <input type="checkbox" name="hum_electives" value="Economics" onchange="validateSubjectSelection('humanities')">
                                        <span>Economics</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_hum_civ">
                                        <input type="checkbox" name="hum_electives" value="Civics" onchange="validateSubjectSelection('humanities')">
                                        <span>Civics</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_hum_soc">
                                        <input type="checkbox" name="hum_electives" value="Sociology" onchange="validateSubjectSelection('humanities')">
                                        <span>Sociology</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_hum_log">
                                        <input type="checkbox" name="hum_electives" value="Logic" onchange="validateSubjectSelection('humanities')">
                                        <span>Logic</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_hum_ish">
                                        <input type="checkbox" name="hum_electives" value="Islamic History & Culture" onchange="validateSubjectSelection('humanities')">
                                        <span>Islamic History & Culture</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_hum_his">
                                        <input type="checkbox" name="hum_electives" value="History" onchange="validateSubjectSelection('humanities')">
                                        <span>History</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="form-input-label" style="font-weight: 700; color: var(--foreground);">(c) Fourth Subject (Select any one of the remaining/additional subjects):</label>
                                <select id="hum_fourth_subject" class="form-input-field form-select-field">
                                    <option value="">Select Subject</option>
                                    <option value="Economics">Economics</option>
                                    <option value="Civics">Civics</option>
                                    <option value="Sociology">Sociology</option>
                                    <option value="Logic">Logic</option>
                                    <option value="Islamic History & Culture">Islamic History & Culture</option>
                                    <option value="History">History</option>
                                </select>
                            </div>
                        </div>

                        <!-- Music Subject List -->
                        <div id="musicSubjects" style="display: none;">
                            <div style="font-size:0.9rem; margin-bottom: 1rem;">
                                <span style="font-weight:700; color: var(--foreground);">(a) Compulsory Subjects:</span> 
                                <span class="badge" style="background-color:var(--muted); color:var(--foreground); padding:0.3rem 0.6rem; border-radius:4px; font-size:0.85rem; margin-right:0.3rem;">Bengali</span>
                                <span class="badge" style="background-color:var(--muted); color:var(--foreground); padding:0.3rem 0.6rem; border-radius:4px; font-size:0.85rem; margin-right:0.3rem;">English</span>
                                <span class="badge" style="background-color:var(--muted); color:var(--foreground); padding:0.3rem 0.6rem; border-radius:4px; font-size:0.85rem; margin-right:0.3rem;">ICT</span>
                                <span class="badge" style="background-color:var(--muted); color:var(--foreground); padding:0.3rem 0.6rem; border-radius:4px; font-size:0.85rem; margin-right:0.3rem;">Light Music</span>
                                <span class="badge" style="background-color:var(--muted); color:var(--foreground); padding:0.3rem 0.6rem; border-radius:4px; font-size:0.85rem; margin-right:0.3rem;">Classical Music</span>
                            </div>
                            
                            <div style="margin-bottom: 1rem;">
                                <label class="form-input-label" style="font-weight: 700; color: var(--foreground);">
                                    (b) Elective Subjects (Select any three): <span style="color:var(--primary); font-size:0.8rem;">(Maximum 3 choices)</span>
                                </label>
                                <div class="subject-checkbox-grid">
                                    <label class="subject-checkbox-card" id="card_mus_eco">
                                        <input type="checkbox" name="mus_electives" value="Economics" onchange="validateSubjectSelection('music')">
                                        <span>Economics</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_mus_civ">
                                        <input type="checkbox" name="mus_electives" value="Civics" onchange="validateSubjectSelection('music')">
                                        <span>Civics</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_mus_log">
                                        <input type="checkbox" name="mus_electives" value="Logic" onchange="validateSubjectSelection('music')">
                                        <span>Logic</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_mus_psy">
                                        <input type="checkbox" name="mus_electives" value="Psychology" onchange="validateSubjectSelection('music')">
                                        <span>Psychology</span>
                                    </label>
                                    <label class="subject-checkbox-card" id="card_mus_his">
                                        <input type="checkbox" name="mus_electives" value="History" onchange="validateSubjectSelection('music')">
                                        <span>History</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="form-input-label" style="font-weight: 700; color: var(--foreground);">(c) Fourth Subject (Select any one of the remaining/additional subjects):</label>
                                <select id="mus_fourth_subject" class="form-input-field form-select-field">
                                    <option value="">Select Subject</option>
                                    <option value="Sociology">Sociology</option>
                                    <option value="Economics">Economics</option>
                                    <option value="Civics">Civics</option>
                                    <option value="Logic">Logic</option>
                                    <option value="Psychology">Psychology</option>
                                    <option value="History">History</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Local Guardian Details Section -->
                <p class="form-sub-section-label" style="font-weight: 700; margin-top: 1.5rem; color: var(--foreground);">Local Guardian Details:</p>
                <div class="form-grid-3">
                    <div>
                        <label class="form-input-label">Name<span class="required-star">*</span></label>
                        <input type="text" id="local_guardian_name" class="form-input-field" placeholder="e.g. Karim Miah" required>
                    </div>
                    <div>
                        <label class="form-input-label">Village/Street<span class="required-star">*</span></label>
                        <input type="text" id="local_guardian_village" class="form-input-field" placeholder="Village/Street" required>
                    </div>
                    <div>
                        <label class="form-input-label">Post Office<span class="required-star">*</span></label>
                        <input type="text" id="local_guardian_post" class="form-input-field" placeholder="Post Office" required>
                    </div>
                </div>
                <div class="form-grid-3" style="margin-top: 0.5rem;">
                    <div>
                        <label class="form-input-label">Upazila<span class="required-star">*</span></label>
                        <input type="text" id="local_guardian_upazila" class="form-input-field" placeholder="Upazila" required>
                    </div>
                    <div>
                        <label class="form-input-label">District<span class="required-star">*</span></label>
                        <input type="text" id="local_guardian_district" class="form-input-field" placeholder="District" required>
                    </div>
                    <div>
                        <label class="form-input-label">Mobile Number<span class="required-star">*</span></label>
                        <input type="text" id="local_guardian_mobile" class="form-input-field" placeholder="01XXXXXXXXX" required>
                    </div>
                </div>

                <!-- Submission Controls -->
                <div class="form-button-row" style="margin-top: 2rem;">
                    <button type="button" class="btn btn-secondary" onclick="hideAddStudentPage()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;margin-right:6px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Complete Admission
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>




<!-- Student Details Popup Modal -->
<div id="studentDetailsModal" class="modal-overlay">
    <div class="modal" style="max-width: 600px; width: 95%; max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;">
        <div class="modal-header" style="flex-shrink: 0;">
            <h3 class="modal-title">Student Profile Details</h3>
            <button type="button" class="modal-close" onclick="closeStudentModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body" style="flex: 1; overflow-y: auto; padding: 1.25rem;">
            <div id="modalStudentContent">
                <!-- Content will be dynamically injected here via JS -->
            </div>
        </div>
        <div class="modal-footer" style="flex-shrink: 0;">
            <button type="button" class="btn btn-secondary" onclick="closeStudentModal()">Close</button>
        </div>
    </div>
</div>

<script>
    // JS for details modal popup
    // Global Profiles State Registry
    window.studentProfiles = window.studentProfiles || {};

    // Helper to get profile with fallback for mock rows
    function getStudentProfile(id, row) {
        if (window.studentProfiles[id]) {
            return window.studentProfiles[id];
        }
        
        // Build a mock/fallback profile for pre-existing table rows
        const name = row.getAttribute('data-name') || 'N/A';
        const mob = row.getAttribute('data-mob') || 'N/A';
        const session = row.getAttribute('data-session') || 'N/A';
        const className = row.getAttribute('data-class') || '11th Class';
        const section = row.getAttribute('data-section') || 'Humanities';
        const gender = row.getAttribute('data-gender') || 'Male';
        
        // Extract roll from badge
        const rollBadge = row.querySelector('.roll-badge');
        const roll = rollBadge ? rollBadge.textContent.replace(/Roll:\s*/i, '').trim() : 'N/A';
        
        return {
            id,
            serialNo: 'N/A',
            roll,
            session,
            admissionDate: new Date().toISOString().slice(0, 10),
            nameEn: name,
            nameBn: name, // Fallback
            fatherBn: "Father's Name (Bengali)",
            fatherEn: "Father's Name (English)",
            motherBn: "Mother's Name (Bengali)",
            motherEn: "Mother's Name (English)",
            addresses: {
                current: { village: 'Village', post: 'Post Office', upazila: 'Upazila', district: 'District' },
                permanent: { village: 'Village', post: 'Post Office', upazila: 'Upazila', district: 'District' }
            },
            guardian: {
                name: 'Guardian Name',
                address: { village: 'Village', post: 'Post Office', upazila: 'Upazila', district: 'District' },
                occupation: 'Occupation',
                income: '150000'
            },
            nationality: 'Bangladeshi',
            religion: 'Islam',
            community: 'General',
            gender: gender,
            dob: '2005-01-01',
            ssc: {
                regNo: '1234567890',
                session: '2020-2021',
                board: 'Rajshahi',
                center: 'Pabna',
                roll: '123456',
                year: '2022',
                grade: '5.00'
            },
            prevSchool: { name: 'Previous School', post: 'Post Office', upazila: 'Upazila', district: 'District' },
            desiredClass: className,
            desiredBranch: section,
            subjects: {
                compulsory: section === 'Humanities' ? ["Bengali", "English", "ICT"] : ["Bengali", "English", "ICT", "Light Music", "Classical Music"],
                electives: ["Economics", "Sociology", "Logic"],
                fourth: "Civics"
            },
            localGuardian: {
                name: 'Local Guardian',
                village: 'Village',
                post: 'Post Office',
                upazila: 'Upazila',
                district: 'District',
                mobile: mob
            },
            photoUrl: null
        };
    }

    // JS for details modal popup
    function openStudentModal(studentData) {
        const modal = document.getElementById('studentDetailsModal');
        const content = document.getElementById('modalStudentContent');
        
        let photoHtml = '';
        if (studentData.photoUrl) {
            photoHtml = `<img src="${studentData.photoUrl}" alt="Photo" style="width:100%; height:100%; object-fit:cover;">`;
        } else {
            photoHtml = `
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%; color: var(--muted-foreground);">
                    <rect width="64" height="64" fill="var(--muted)"/>
                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="var(--primary)"/>
                </svg>
            `;
        }

        content.innerHTML = `
            <div style="display: flex; gap: 1.5rem; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid var(--border); padding-bottom: 1.5rem; flex-wrap: wrap;">
                <div style="width: 90px; height: 110px; border-radius: 6px; overflow: hidden; border: 2px solid var(--primary); background: var(--muted); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    ${photoHtml}
                </div>
                <div>
                    <h2 style="margin: 0; font-size: 1.4rem; color: var(--foreground); font-weight: 700;">${studentData.nameEn}</h2>
                    <p style="margin: 0.15rem 0 0.5rem 0; font-size: 1.05rem; color: var(--muted-foreground); font-weight: 600;">${studentData.nameBn}</p>
                    <p style="margin: 0; color: var(--primary); font-weight: 700; font-size: 0.95rem;">
                        ${studentData.desiredClass} | Roll: ${studentData.roll} | Section: ${studentData.desiredBranch}
                    </p>
                </div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem; font-size: 0.9rem; padding-right: 0.25rem;">
                
                <!-- Section: General Info -->
                <div style="background-color: var(--muted); border-radius: 8px; padding: 1rem; border: 1px solid var(--border);">
                    <h4 style="margin: 0 0 0.75rem 0; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; font-size: 0.95rem; font-weight: 700; color: var(--foreground);">General Info</h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                        <div><strong>ID:</strong> ${studentData.id}</div>
                        <div><strong>Serial No:</strong> ${studentData.serialNo}</div>
                        <div><strong>Academic Year:</strong> ${studentData.session}</div>
                        <div><strong>Admission Date:</strong> ${studentData.admissionDate || 'N/A'}</div>
                        <div><strong>Date of Birth:</strong> ${studentData.dob || 'N/A'}</div>
                        <div><strong>Gender:</strong> ${studentData.gender || 'N/A'}</div>
                        <div><strong>Nationality:</strong> ${studentData.nationality}</div>
                        <div><strong>Religion:</strong> ${studentData.religion}</div>
                        <div><strong>Community:</strong> ${studentData.community || 'N/A'}</div>
                    </div>
                </div>

                <!-- Section: Parents -->
                <div style="background-color: var(--muted); border-radius: 8px; padding: 1rem; border: 1px solid var(--border);">
                    <h4 style="margin: 0 0 0.75rem 0; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; font-size: 0.95rem; font-weight: 700; color: var(--foreground);">Parent Information</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div><strong>Father's Name (Bengali):</strong> ${studentData.fatherBn}</div>
                        <div><strong>Father's Name (English):</strong> ${studentData.fatherEn}</div>
                        <div><strong>Mother's Name (Bengali):</strong> ${studentData.motherBn}</div>
                        <div><strong>Mother's Name (English):</strong> ${studentData.motherEn}</div>
                    </div>
                </div>

                <!-- Section: Address -->
                <div style="background-color: var(--muted); border-radius: 8px; padding: 1rem; border: 1px solid var(--border);">
                    <h4 style="margin: 0 0 0.75rem 0; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; font-size: 0.95rem; font-weight: 700; color: var(--foreground);">Address Details</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div>
                            <strong>Current Address:</strong> <br>
                            Village: ${studentData.addresses.current.village}, Post Office: ${studentData.addresses.current.post}, Upazila: ${studentData.addresses.current.upazila}, District: ${studentData.addresses.current.district}
                        </div>
                        <div style="border-top: 1px dashed var(--border); padding-top: 0.5rem;">
                            <strong>Permanent Address:</strong> <br>
                            Village: ${studentData.addresses.permanent.village}, Post Office: ${studentData.addresses.permanent.post}, Upazila: ${studentData.addresses.permanent.upazila}, District: ${studentData.addresses.permanent.district}
                        </div>
                    </div>
                </div>

                <!-- Section: Alternate Guardian -->
                <div style="background-color: var(--muted); border-radius: 8px; padding: 1rem; border: 1px solid var(--border);">
                    <h4 style="margin: 0 0 0.75rem 0; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; font-size: 0.95rem; font-weight: 700; color: var(--foreground);">Guardian Information (if Father is absent)</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div><strong>Guardian Name:</strong> ${studentData.guardian.name || 'N/A'}</div>
                        <div><strong>Occupation:</strong> ${studentData.guardian.occupation || 'N/A'}</div>
                        <div><strong>Annual Income:</strong> ${studentData.guardian.income ? studentData.guardian.income + ' BDT' : 'N/A'}</div>
                        <div>
                            <strong>Guardian Address:</strong> 
                            ${studentData.guardian.address.village ? `Village: ${studentData.guardian.address.village}, Post Office: ${studentData.guardian.address.post}, Upazila: ${studentData.guardian.address.upazila}, District: ${studentData.guardian.address.district}` : 'N/A'}
                        </div>
                    </div>
                </div>

                <!-- Section: Education History Table -->
                <div style="background-color: var(--muted); border-radius: 8px; padding: 1rem; border: 1px solid var(--border);">
                    <h4 style="margin: 0 0 0.75rem 0; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; font-size: 0.95rem; font-weight: 700; color: var(--foreground);">Academic Passing Details & Reg.</h4>
                    <div style="margin-bottom: 0.5rem;">
                        <strong>Reg. Number:</strong> ${studentData.ssc.regNo} | <strong>Academic Session:</strong> ${studentData.ssc.session}
                    </div>
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.8rem; text-align: center; margin-top: 0.5rem; background-color: var(--card);">
                        <thead>
                            <tr style="background-color: var(--muted);">
                                <th style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">Exam</th>
                                <th style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">Board</th>
                                <th style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">Center</th>
                                <th style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">Roll</th>
                                <th style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">Year</th>
                                <th style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid var(--border); padding: 0.4rem; font-weight:700; color: var(--foreground);">SSC / Equivalent</td>
                                <td style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">${studentData.ssc.board}</td>
                                <td style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">${studentData.ssc.center}</td>
                                <td style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">${studentData.ssc.roll}</td>
                                <td style="border: 1px solid var(--border); padding: 0.4rem; color: var(--foreground);">${studentData.ssc.year}</td>
                                <td style="border: 1px solid var(--border); padding: 0.4rem; font-weight:700; color: var(--primary);">${studentData.ssc.grade}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Section: Previous School -->
                <div style="background-color: var(--muted); border-radius: 8px; padding: 1rem; border: 1px solid var(--border);">
                    <h4 style="margin: 0 0 0.75rem 0; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; font-size: 0.95rem; font-weight: 700; color: var(--foreground);">Last Attended Institution</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <div><strong>Institution Name:</strong> ${studentData.prevSchool.name}</div>
                        <div><strong>Post Office:</strong> ${studentData.prevSchool.post}, <strong>Upazila:</strong> ${studentData.prevSchool.upazila}, <strong>District:</strong> ${studentData.prevSchool.district}</div>
                    </div>
                </div>

                <!-- Section: Selected Subjects -->
                <div style="background-color: var(--muted); border-radius: 8px; padding: 1rem; border: 1px solid var(--border);">
                    <h4 style="margin: 0 0 0.75rem 0; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; font-size: 0.95rem; font-weight: 700; color: var(--foreground);">Selected Course Subjects</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div><strong>Compulsory:</strong> ${studentData.subjects.compulsory.join(', ')}</div>
                        <div><strong>Elective Subjects:</strong> ${studentData.subjects.electives.join(', ')}</div>
                        <div><strong>Fourth Subject:</strong> <span class="badge" style="background-color: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.3); padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 600;">${studentData.subjects.fourth}</span></div>
                    </div>
                </div>

                <!-- Section: Local Guardian -->
                <div style="background-color: var(--muted); border-radius: 8px; padding: 1rem; border: 1px solid var(--border); margin-bottom: 0.5rem;">
                    <h4 style="margin: 0 0 0.75rem 0; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem; font-size: 0.95rem; font-weight: 700; color: var(--foreground);">Local Guardian & Contact</h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                        <div><strong>Guardian Name:</strong> ${studentData.localGuardian.name}</div>
                        <div><strong>Mobile Number:</strong> ${studentData.localGuardian.mobile}</div>
                        <div style="grid-column: span 2;">
                            <strong>Address:</strong> Village: ${studentData.localGuardian.village}, Post Office: ${studentData.localGuardian.post}, Upazila: ${studentData.localGuardian.upazila}, District: ${studentData.localGuardian.district}
                        </div>
                    </div>
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
        const id = row.getAttribute('data-id');
        const profile = getStudentProfile(id, row);
        openStudentModal(profile);
    }

    // Dynamic row deletion function
    function deleteStudentRow(button, studentName) {
        if (confirm(`Are you sure you want to delete ${studentName}?`)) {
            const row = button.closest('tr');
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '0';
            row.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                const deletedId = row.getAttribute('data-id');
                if (deletedId && window.studentProfiles[deletedId]) {
                    delete window.studentProfiles[deletedId];
                }
                
                row.remove();
                
                // Save changes to LocalStorage
                if (typeof window.saveStudentsToLocalStorage === 'function') {
                    window.saveStudentsToLocalStorage();
                }
                
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
        // Load existing data from LocalStorage if available;
        // if not, convert static page rows and initialize LocalStorage!
        const loaded = window.loadStudentsFromLocalStorage();
        if (!loaded) {
            document.querySelectorAll('#studentTable tbody tr').forEach(row => {
                const className = row.getAttribute('data-class');
                if (className === 'Class One') {
                    row.setAttribute('data-class', '11th Class');
                    const badge = row.querySelector('.class-badge');
                    if (badge) badge.textContent = '11th Class';
                } else if (className === 'Class Two') {
                    row.setAttribute('data-class', '12th Class');
                    const badge = row.querySelector('.class-badge');
                    if (badge) badge.textContent = '12th Class';
                }

                const section = row.getAttribute('data-section');
                if (section === 'Section A') {
                    row.setAttribute('data-section', 'Humanities');
                    const spans = row.querySelectorAll('.academic-details-sub span');
                    if (spans.length > 0) spans[0].textContent = 'Humanities';
                } else if (section === 'Section B') {
                    row.setAttribute('data-section', 'Music');
                    const spans = row.querySelectorAll('.academic-details-sub span');
                    if (spans.length > 0) spans[0].textContent = 'Music';
                }

                // Bind Edit button to open edit form
                const editBtn = row.querySelector('.action-btn[title="Edit"]');
                if (editBtn) {
                    editBtn.setAttribute('onclick', 'editStudentDetails(this)');
                }
            });
            
            // Save initial set to localStorage
            window.saveStudentsToLocalStorage();
        }

        const searchInput = document.getElementById('searchStudent');
        const pageSizeSelect = document.getElementById('pageSizeSelect');

        let currentPage = 1;
        let pageSize = 30;

        function filterTable() {
            try {
                const tableRows = document.querySelectorAll('#studentTable tbody tr');
                const searchText = searchInput.value.toLowerCase().trim();
                const sessionVal = document.getElementById('sessionDropdown').getAttribute('data-selected-value') || '';
                const classVal = document.getElementById('classDropdown').getAttribute('data-selected-value') || '';
                const sectionVal = document.getElementById('sectionDropdown').getAttribute('data-selected-value') || '';
                const genderVal = document.getElementById('genderDropdown').getAttribute('data-selected-value') || '';

                // Update pageSize from select element
                const selectedSizeVal = pageSizeSelect.value;
                pageSize = selectedSizeVal === 'all' ? Infinity : parseInt(selectedSizeVal, 10);

                // Phase 1: Determine which rows match the filters
                const matchedRows = [];
                tableRows.forEach(row => {
                    const nameAttr = row.getAttribute('data-name') || '';
                    const idAttr = row.getAttribute('data-id') || '';
                    const mobAttr = row.getAttribute('data-mob') || '';
                    const session = row.getAttribute('data-session') || '';
                    const className = row.getAttribute('data-class') || '';
                    const section = row.getAttribute('data-section') || '';
                    const gender = row.getAttribute('data-gender') || '';

                    const name = nameAttr.toLowerCase();
                    const id = idAttr.toLowerCase();
                    const mob = mobAttr.toLowerCase();

                    const matchesSearch = !searchText || 
                                          name.includes(searchText) || 
                                          id.includes(searchText) || 
                                          mob.includes(searchText);
                    
                    const matchesSession = !sessionVal || session === sessionVal;
                    const matchesClass = !classVal || className === classVal;
                    const matchesSection = !sectionVal || section === sectionVal;
                    const matchesGender = !genderVal || gender === genderVal;

                    if (matchesSearch && matchesSession && matchesClass && matchesSection && matchesGender) {
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
                        const slCol = row.querySelector('.sl-column');
                        if (slCol) slCol.textContent = index + 1;
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
            } catch (err) {
                console.error("Error inside filterTable:", err);
            }
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

        // Initialize our 4 custom dropdown filters
        initCustomDropdown('sessionDropdown', filterTable);
        initCustomDropdown('classDropdown', filterTable);
        initCustomDropdown('sectionDropdown', filterTable);
        initCustomDropdown('genderDropdown', filterTable);

        // Initialize Flatpickr for the two date fields
        if (typeof flatpickr !== 'undefined') {
            flatpickr("#office_admission_date", {
                dateFormat: "Y-m-d",
                allowInput: true
            });
            flatpickr("#student_dob", {
                dateFormat: "Y-m-d",
                allowInput: true
            });
        }

        searchInput.addEventListener('input', filterTable);
        window.filterTable = filterTable;
        filterTable(); // Run initially to configure pagination layout
    });


    // Export Filtered Students function (opens new tab with print/pdf/csv view)
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
                const section = row.getAttribute('data-section');
                const gender = row.getAttribute('data-gender');
                
                const rollBadge = row.querySelector('.roll-badge');
                const roll = rollBadge ? rollBadge.textContent.replace(/Roll:\s*/i, '').trim() : '';
                
                visibleStudents.push({
                    sl, name, id, mob, session, className, section, gender, roll
                });
            }
        });

        if (visibleStudents.length === 0) {
            alert("No students to export!");
            return;
        }

        const sessionVal = document.getElementById('sessionDropdown') ? (document.getElementById('sessionDropdown').getAttribute('data-selected-value') || 'All') : 'All';
        const classVal = document.getElementById('classDropdown') ? (document.getElementById('classDropdown').getAttribute('data-selected-value') || 'All') : 'All';
        const sectionVal = document.getElementById('sectionDropdown') ? (document.getElementById('sectionDropdown').getAttribute('data-selected-value') || 'All') : 'All';
        const genderVal = document.getElementById('genderDropdown') ? (document.getElementById('genderDropdown').getAttribute('data-selected-value') || 'All') : 'All';
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
                    <button class="btn" id="pdfDownloadBtn" onclick="triggerPdfDownload()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download PDF
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
                            <th style="width: 50%;">Student Details</th>
                            <th style="width: 45%;">Class, Roll & Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRowsHtml}
                    </tbody>
                </table>

                <script>
                    function triggerPdfDownload() {
                        if (window.opener && !window.opener.closed) {
                            window.opener.downloadPdfReport(document.documentElement.innerHTML);
                        } else {
                            alert("Parent window is closed. Please try again.");
                        }
                    }
                    function exportToCSV() {
                        if (window.opener && !window.opener.closed) {
                            window.opener.downloadCsvReport();
                        } else {
                            alert("Parent window is closed. Please try again.");
                        }
                    }
                ${'</' + 'script>'}
            </body>
            </html>
        `);
        exportWindow.document.close();
    }

    // Function to generate and download PDF using html2pdf.js inside parent context
    window.downloadPdfReport = function(htmlContent) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(htmlContent, 'text/html');
        
        // Remove action bar (buttons wrapper)
        const actionBar = doc.querySelector('.action-bar');
        if (actionBar) {
            actionBar.remove();
        }
        
        // Create dynamic content container to feed html2pdf
        const container = document.createElement('div');
        container.style.padding = '20px';
        container.style.backgroundColor = '#ffffff';
        
        // Copy stylesheet styles
        const styles = doc.querySelectorAll('style, link[rel="stylesheet"]');
        styles.forEach(s => {
            container.appendChild(s.cloneNode(true));
        });
        
        // Copy header logo section
        const header = doc.querySelector('.header');
        if (header) {
            container.appendChild(header.cloneNode(true));
        }
        
        // Copy table data
        const table = doc.querySelector('table');
        if (table) {
            table.style.width = '100%';
            table.style.borderCollapse = 'collapse';
            container.appendChild(table.cloneNode(true));
        }
        
        const opt = {
            margin:       [0.4, 0.4, 0.4, 0.4],
            filename:     'students_report_' + new Date().toISOString().slice(0, 10) + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true, logging: false },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        
        html2pdf().set(opt).from(container).save();
    };

    // Function to generate and download CSV sheet directly from active filters inside parent context
    window.downloadCsvReport = function() {
        const rows = document.querySelectorAll('#studentTable tbody tr');
        const data = [
            ['SL', 'Student Name', 'Student ID', 'Mobile', 'Class', 'Roll', 'Session', 'Section', 'Gender']
        ];
        
        let sl = 1;
        rows.forEach(row => {
            if (row.classList.contains('matches-filter')) {
                const name = row.getAttribute('data-name') || '';
                const id = row.getAttribute('data-id') || '';
                const mob = row.getAttribute('data-mob') || '';
                const session = row.getAttribute('data-session') || '';
                const className = row.getAttribute('data-class') || '';
                const section = row.getAttribute('data-section') || '';
                const gender = row.getAttribute('data-gender') || '';
                
                const rollBadge = row.querySelector('.roll-badge');
                const roll = rollBadge ? rollBadge.textContent.replace(/Roll:\s*/i, '').trim() : '';
                
                data.push([sl++, name, id, mob, className, roll, session, section, gender]);
            }
        });

        if (data.length <= 1) {
            alert('No student records found to export!');
            return;
        }

        let csvContent = "";
        data.forEach(row => {
            const formattedRow = row.map(val => '"' + String(val).replace(/"/g, '""') + '"').join(',');
            csvContent += formattedRow + "\r\n";
        });

        const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", "students_list_" + new Date().toISOString().slice(0, 10) + ".csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    };

    // Helper function to fill form with dummy data for rapid testing
    window.fillDummyData = function() {
        // Basic Info
        document.getElementById('student_name_bn').value = 'ফারহানা রহমান';
        document.getElementById('student_name_en').value = 'FARHANA RAHMAN';
        document.getElementById('father_name_bn').value = 'আব্দুর রহমান';
        document.getElementById('father_name_en').value = 'ABDUR RAHMAN';
        document.getElementById('mother_name_bn').value = 'ফাতেমা বেগম';
        document.getElementById('mother_name_en').value = 'FATEMA BEGUM';

        // Addresses
        document.getElementById('current_village').value = 'Shalgaria';
        document.getElementById('current_post').value = 'Pabna';
        document.getElementById('current_upazila').value = 'Pabna Sadar';
        document.getElementById('current_district').value = 'Pabna';

        document.getElementById('permanent_village').value = 'Shalgaria';
        document.getElementById('permanent_post').value = 'Pabna';
        document.getElementById('permanent_upazila').value = 'Pabna Sadar';
        document.getElementById('permanent_district').value = 'Pabna';
        document.getElementById('same_address_check').checked = true;

        // Guardian
        document.getElementById('guardian_name').value = 'Abdur Rahman';
        document.getElementById('guardian_village').value = 'Shalgaria';
        document.getElementById('guardian_post').value = 'Pabna';
        document.getElementById('guardian_upazila').value = 'Pabna Sadar';
        document.getElementById('guardian_district').value = 'Pabna';
        document.getElementById('guardian_occupation').value = 'Service';
        document.getElementById('annual_income').value = '350000';

        // Personal Info
        document.getElementById('student_nationality').value = 'Bangladeshi';
        document.getElementById('student_religion').value = 'Islam';
        document.getElementById('student_community').value = 'General';
        document.getElementById('student_gender').value = 'Female';

        // Dates and certificates
        const dobInput = document.getElementById('student_dob');
        if (dobInput) {
            dobInput.value = '2007-05-15';
            if (dobInput._flatpickr) {
                dobInput._flatpickr.setDate('2007-05-15');
            }
        }

        document.getElementById('ssc_reg_no').value = '1712345678';
        document.getElementById('ssc_session').value = '2022-2023';
        document.getElementById('ssc_board').value = 'Rajshahi';
        document.getElementById('ssc_center').value = 'Pabna-1';
        document.getElementById('ssc_roll').value = '123456';
        document.getElementById('ssc_year').value = '2024';
        document.getElementById('ssc_grade').value = '4.95';

        // Prev School
        document.getElementById('prev_inst_name').value = 'Pabna Zilla School';
        document.getElementById('prev_inst_post').value = 'Pabna';
        document.getElementById('prev_inst_upazila').value = 'Pabna Sadar';
        document.getElementById('prev_inst_district').value = 'Pabna';

        // Class & Group choices
        document.getElementById('desired_class').value = '11th Class';
        document.getElementById('desired_branch').value = 'Humanities';
        document.getElementById('office_class').value = '11th Class';
        document.getElementById('office_section').value = 'Humanities';

        // Subject selection
        const humCheckboxes = ['Economics', 'Civics', 'Sociology'];
        document.querySelectorAll('input[name="hum_electives"]').forEach(cb => {
            if (humCheckboxes.includes(cb.value)) {
                cb.checked = true;
                const card = cb.closest('.subject-checkbox-card');
                if (card) card.classList.add('selected');
            } else {
                cb.checked = false;
                const card = cb.closest('.subject-checkbox-card');
                if (card) card.classList.remove('selected');
            }
        });
        
        // Disable other options to match standard behavior
        document.querySelectorAll('input[name="hum_electives"]').forEach(cb => {
            if (!cb.checked) {
                cb.disabled = true;
                const card = cb.closest('.subject-checkbox-card');
                if (card) card.classList.add('disabled');
            } else {
                cb.disabled = false;
                const card = cb.closest('.subject-checkbox-card');
                if (card) card.classList.remove('disabled');
            }
        });

        document.getElementById('hum_fourth_subject').value = 'Logic';

        // Local Guardian
        document.getElementById('local_guardian_name').value = 'Abdur Rahman';
        document.getElementById('local_guardian_village').value = 'Shalgaria';
        document.getElementById('local_guardian_post').value = 'Pabna';
        document.getElementById('local_guardian_upazila').value = 'Pabna Sadar';
        document.getElementById('local_guardian_district').value = 'Pabna';
        document.getElementById('local_guardian_mobile').value = '01712345678';

        // Office Only
        document.getElementById('office_roll').value = '105';
        document.getElementById('office_session').value = '2024-2025';
        
        const admInput = document.getElementById('office_admission_date');
        if (admInput) {
            admInput.value = '2026-07-11';
            if (admInput._flatpickr) {
                admInput._flatpickr.setDate('2026-07-11');
            }
        }
    };

    // Track if we are editing an existing student admission
    window.currentEditingStudentId = null;

    // Form navigation and toggle helper functions
    window.showAddStudentPage = function() {
        document.getElementById('mainListPage').style.display = 'none';
        document.getElementById('addStudentPage').style.display = 'block';
        const childBc = document.getElementById('breadcrumb-student-child');
        if (childBc) {
            childBc.style.display = 'inline';
            childBc.querySelector('span:nth-child(2)').textContent = window.currentEditingStudentId ? ' Edit Student' : ' Add Student';
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Update form heading and submit button text based on Mode (Add/Edit)
        const formTitle = document.querySelector('.form-section-heading');
        const submitBtn = document.querySelector('#addStudentForm button[type="submit"]');
        if (window.currentEditingStudentId) {
            if (formTitle) {
                formTitle.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Student Admission Details
                `;
            }
            if (submitBtn) {
                submitBtn.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;margin-right:6px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Admission
                `;
            }
        } else {
            if (formTitle) {
                formTitle.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px;height:20px;flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Admission Application Form
                `;
            }
            if (submitBtn) {
                submitBtn.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;margin-right:6px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Complete Admission
                `;
            }
            // Pre-fill dummy data automatically for fast testing ONLY in Add Mode
            if (typeof fillDummyData === 'function') {
                fillDummyData();
            }
        }
    };

    // Load student details into form inputs for editing
    window.editStudentDetails = function(button) {
        const row = button.closest('tr');
        const id = row.getAttribute('data-id');
        const profile = getStudentProfile(id, row);
        
        window.currentEditingStudentId = id;
        
        // Basic Info
        document.getElementById('student_name_bn').value = profile.nameBn || '';
        document.getElementById('student_name_en').value = profile.nameEn || '';
        document.getElementById('father_name_bn').value = profile.fatherBn || '';
        document.getElementById('father_name_en').value = profile.fatherEn || '';
        document.getElementById('mother_name_bn').value = profile.motherBn || '';
        document.getElementById('mother_name_en').value = profile.motherEn || '';
        
        // Address details
        document.getElementById('current_village').value = (profile.addresses && profile.addresses.current && profile.addresses.current.village) || '';
        document.getElementById('current_post').value = (profile.addresses && profile.addresses.current && profile.addresses.current.post) || '';
        document.getElementById('current_upazila').value = (profile.addresses && profile.addresses.current && profile.addresses.current.upazila) || '';
        document.getElementById('current_district').value = (profile.addresses && profile.addresses.current && profile.addresses.current.district) || '';
        
        document.getElementById('permanent_village').value = (profile.addresses && profile.addresses.permanent && profile.addresses.permanent.village) || '';
        document.getElementById('permanent_post').value = (profile.addresses && profile.addresses.permanent && profile.addresses.permanent.post) || '';
        document.getElementById('permanent_upazila').value = (profile.addresses && profile.addresses.permanent && profile.addresses.permanent.upazila) || '';
        document.getElementById('permanent_district').value = (profile.addresses && profile.addresses.permanent && profile.addresses.permanent.district) || '';
        document.getElementById('same_address_check').checked = false;
        
        // Guardian Details
        document.getElementById('guardian_name').value = (profile.guardian && profile.guardian.name) || '';
        document.getElementById('guardian_village').value = (profile.guardian && profile.guardian.address && profile.guardian.address.village) || '';
        document.getElementById('guardian_post').value = (profile.guardian && profile.guardian.address && profile.guardian.address.post) || '';
        document.getElementById('guardian_upazila').value = (profile.guardian && profile.guardian.address && profile.guardian.address.upazila) || '';
        document.getElementById('guardian_district').value = (profile.guardian && profile.guardian.address && profile.guardian.address.district) || '';
        document.getElementById('guardian_occupation').value = (profile.guardian && profile.guardian.occupation) || '';
        document.getElementById('annual_income').value = (profile.guardian && profile.guardian.income) || '';
        
        // Personal metrics
        document.getElementById('student_nationality').value = profile.nationality || 'Bangladeshi';
        document.getElementById('student_religion').value = profile.religion || 'Islam';
        document.getElementById('student_community').value = profile.community || '';
        document.getElementById('student_gender').value = profile.gender || 'Male';
        
        // Dob flatpickr syncing
        const dobInput = document.getElementById('student_dob');
        if (dobInput) {
            dobInput.value = profile.dob || '';
            if (dobInput._flatpickr) {
                dobInput._flatpickr.setDate(profile.dob || '');
            }
        }
        
        // SSC Details
        document.getElementById('ssc_reg_no').value = (profile.ssc && profile.ssc.regNo) || '';
        document.getElementById('ssc_session').value = (profile.ssc && profile.ssc.session) || '';
        document.getElementById('ssc_board').value = (profile.ssc && profile.ssc.board) || '';
        document.getElementById('ssc_center').value = (profile.ssc && profile.ssc.center) || '';
        document.getElementById('ssc_roll').value = (profile.ssc && profile.ssc.roll) || '';
        document.getElementById('ssc_year').value = (profile.ssc && profile.ssc.year) || '';
        document.getElementById('ssc_grade').value = (profile.ssc && profile.ssc.grade) || '';
        
        // Prev school details
        document.getElementById('prev_inst_name').value = (profile.prevSchool && profile.prevSchool.name) || '';
        document.getElementById('prev_inst_post').value = (profile.prevSchool && profile.prevSchool.post) || '';
        document.getElementById('prev_inst_upazila').value = (profile.prevSchool && profile.prevSchool.upazila) || '';
        document.getElementById('prev_inst_district').value = (profile.prevSchool && profile.prevSchool.district) || '';
        
        // Course Class & Branch details
        document.getElementById('desired_class').value = profile.desiredClass || '11th Class';
        document.getElementById('desired_branch').value = profile.desiredBranch || 'Humanities';
        
        // Local Guardian Details
        document.getElementById('local_guardian_name').value = (profile.localGuardian && profile.localGuardian.name) || '';
        document.getElementById('local_guardian_village').value = (profile.localGuardian && profile.localGuardian.village) || '';
        document.getElementById('local_guardian_post').value = (profile.localGuardian && profile.localGuardian.post) || '';
        document.getElementById('local_guardian_upazila').value = (profile.localGuardian && profile.localGuardian.upazila) || '';
        document.getElementById('local_guardian_district').value = (profile.localGuardian && profile.localGuardian.district) || '';
        document.getElementById('local_guardian_mobile').value = (profile.localGuardian && profile.localGuardian.mobile) || '';
        
        // Sync office inputs
        document.getElementById('office_class').value = profile.desiredClass || '11th Class';
        document.getElementById('office_section').value = profile.desiredBranch || 'Humanities';
        document.getElementById('office_roll').value = profile.roll || '';
        document.getElementById('office_session').value = profile.session || '2024-2025';
        
        const admInput = document.getElementById('office_admission_date');
        if (admInput) {
            admInput.value = profile.admissionDate || '';
            if (admInput._flatpickr) {
                admInput._flatpickr.setDate(profile.admissionDate || '');
            }
        }
        
        // Toggle subjects rendering
        toggleSubjectOptions();
        
        // Select subject checkboxes
        const isHumanities = profile.desiredBranch === 'Humanities';
        const cbName = isHumanities ? 'hum_electives' : 'mus_electives';
        const electives = (profile.subjects && profile.subjects.electives) || [];
        
        document.querySelectorAll(`input[name="hum_electives"], input[name="mus_electives"]`).forEach(cb => {
            cb.checked = false;
            cb.disabled = false;
            const card = cb.closest('.subject-checkbox-card');
            if (card) card.classList.remove('selected', 'disabled');
        });
        
        document.querySelectorAll(`input[name="${cbName}"]`).forEach(cb => {
            if (electives.includes(cb.value)) {
                cb.checked = true;
                const card = cb.closest('.subject-checkbox-card');
                if (card) card.classList.add('selected');
            }
        });
        
        // Recalculate selections and disabled states
        if (electives.length >= 3) {
            document.querySelectorAll(`input[name="${cbName}"]`).forEach(cb => {
                if (!cb.checked) {
                    cb.disabled = true;
                    const card = cb.closest('.subject-checkbox-card');
                    if (card) card.classList.add('disabled');
                }
            });
        }
        
        // Set fourth subject dropdown
        const fourthSelectId = isHumanities ? 'hum_fourth_subject' : 'mus_fourth_subject';
        const fourthSelect = document.getElementById(fourthSelectId);
        if (fourthSelect) {
            fourthSelect.value = (profile.subjects && profile.subjects.fourth) || '';
        }
        
        // Reset uploaded photo state to edited student's photo
        window.uploadedPhotoData = profile.photoUrl || null;
        const photoPreview = document.getElementById('photo_preview');
        if (photoPreview) {
            if (profile.photoUrl) {
                photoPreview.innerHTML = `<img src="${profile.photoUrl}" alt="Photo" style="width:100%; height:100%; object-fit:cover;">`;
            } else {
                photoPreview.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width: 36px; height: 36px; color: var(--muted-foreground); flex-shrink: 0;">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span style="font-size: 0.72rem; font-weight: 600; color: var(--muted-foreground); text-align: center; line-height: 1.4;">Upload<br>Photo</span>
                `;
            }
        }
        
        // Transition views
        document.getElementById('mainListPage').style.display = 'none';
        document.getElementById('addStudentPage').style.display = 'block';
        const childBc = document.getElementById('breadcrumb-student-child');
        if (childBc) {
            childBc.style.display = 'inline';
            childBc.querySelector('span:nth-child(2)').textContent = ' Edit Student';
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Serialize all student profiles to localStorage
    window.saveStudentsToLocalStorage = function() {
        const rows = document.querySelectorAll('#studentTable tbody tr');
        const list = [];
        rows.forEach(row => {
            const id = row.getAttribute('data-id');
            if (id) {
                const profile = getStudentProfile(id, row);
                list.push(profile);
            }
        });
        localStorage.setItem('ss_music_college_students', JSON.stringify(list));
    };

    // Load student profiles from localStorage and rebuild table
    window.loadStudentsFromLocalStorage = function() {
        const savedData = localStorage.getItem('ss_music_college_students');
        if (savedData) {
            try {
                const list = JSON.parse(savedData);
                const tbody = document.querySelector('#studentTable tbody');
                if (!tbody) return false;
                
                tbody.innerHTML = '';
                window.studentProfiles = {};
                
                list.forEach((st, idx) => {
                    window.studentProfiles[st.id] = st;
                    
                    const tr = document.createElement('tr');
                    tr.setAttribute('data-name', st.nameEn || '');
                    tr.setAttribute('data-id', st.id || '');
                    tr.setAttribute('data-mob', (st.localGuardian && st.localGuardian.mobile) || '');
                    tr.setAttribute('data-session', st.session || '');
                    tr.setAttribute('data-class', st.desiredClass || '');
                    tr.setAttribute('data-section', st.desiredBranch || '');
                    tr.setAttribute('data-gender', st.gender || '');
                    
                    let avatarMarkup = '';
                    if (st.photoUrl) {
                        avatarMarkup = `<img src="${st.photoUrl}" class="avatar-image" alt="Avatar">`;
                    } else {
                        avatarMarkup = `
                            <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                                <path d="M32 42c8.837 0 16 7.163 16 16H16c0-8.837 7.163-16 16-16z" fill="var(--primary)" opacity="0.85"/>
                                <circle cx="32" cy="24" r="10" fill="var(--primary)" opacity="0.85"/>
                                <text x="32" y="36" fill="var(--primary-foreground)" font-size="9" font-family="'Inter', sans-serif" font-weight="bold" text-anchor="middle">Photo</text>
                            </svg>
                        `;
                    }
                    
                    tr.innerHTML = `
                        <td class="sl-column">${idx + 1}</td>
                        <td>
                            <div class="avatar-wrapper" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                ${avatarMarkup}
                            </div>
                        </td>
                        <td>
                            <div class="user-cell-name">${st.nameEn || ''}</div>
                            <p class="student-meta">ID: <span>${st.id || ''}</span></p>
                            <p class="student-meta">Mob: <span>${(st.localGuardian && st.localGuardian.mobile) || ''}</span></p>
                        </td>
                        <td>
                            <div>
                                <span class="class-badge">${st.desiredClass || ''}</span>
                                <span class="roll-badge">Roll: ${st.roll || ''}</span>
                            </div>
                            <div class="academic-details-sub">
                                Sec: <span>${st.desiredBranch || ''}</span>
                                Gender: <span>${st.gender || ''}</span>
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
                                <button type="button" class="action-btn" title="Edit" onclick="editStudentDetails(this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, '${st.nameEn || ''}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
                return true;
            } catch (err) {
                console.error("Error loading students from localStorage:", err);
            }
        }
        return false;
    };

    window.hideAddStudentPage = function() {
        document.getElementById('addStudentPage').style.display = 'none';
        document.getElementById('mainListPage').style.display = 'block';
        const childBc = document.getElementById('breadcrumb-student-child');
        if (childBc) childBc.style.display = 'none';
        document.getElementById('addStudentForm').reset();
        
        // Reset interactive photo upload preview
        const photoPreview = document.getElementById('photo_preview');
        if (photoPreview) {
            photoPreview.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width: 36px; height: 36px; color: var(--muted-foreground); flex-shrink: 0;">
                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span style="font-size: 0.72rem; font-weight: 600; color: var(--muted-foreground); text-align: center; line-height: 1.4;">Upload<br>Photo</span>
            `;
        }
        window.uploadedPhotoData = null;

        // Reset subject checkboxes styling & state
        document.querySelectorAll('.subject-checkbox-card').forEach(card => {
            card.classList.remove('selected', 'disabled');
            const input = card.querySelector('input');
            if (input) {
                input.checked = false;
                input.disabled = false;
            }
        });

        // Sync branch/section select to default (humanities)
        document.getElementById('desired_branch').value = 'Humanities';
        document.getElementById('office_section').value = 'Humanities';
        toggleSubjectOptions();

        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Keep branch choices synchronized between office section box and main form
    window.syncOfficeClass = function(el) {
        document.getElementById('desired_class').value = el.value;
    };

    window.syncOfficeSection = function(el) {
        document.getElementById('office_section').value = el.value;
        toggleSubjectOptions();
    };

    window.syncDesiredBranch = function(el) {
        document.getElementById('desired_branch').value = el.value;
        toggleSubjectOptions();
    };

    // Dynamically toggle subject sections based on group selection
    window.toggleSubjectOptions = function() {
        const group = document.getElementById('desired_branch').value;
        const humDiv = document.getElementById('humanitiesSubjects');
        const musDiv = document.getElementById('musicSubjects');
        
        if (group === 'Humanities') {
            humDiv.style.display = 'block';
            musDiv.style.display = 'none';
        } else {
            humDiv.style.display = 'none';
            musDiv.style.display = 'block';
        }
    };

    // Copy current address fields into permanent address fields when checked
    window.copyCurrentAddress = function() {
        const check = document.getElementById('same_address_check');
        if (check.checked) {
            document.getElementById('permanent_village').value = document.getElementById('current_village').value;
            document.getElementById('permanent_post').value = document.getElementById('current_post').value;
            document.getElementById('permanent_upazila').value = document.getElementById('current_upazila').value;
            document.getElementById('permanent_district').value = document.getElementById('current_district').value;
        } else {
            document.getElementById('permanent_village').value = '';
            document.getElementById('permanent_post').value = '';
            document.getElementById('permanent_upazila').value = '';
            document.getElementById('permanent_district').value = '';
        }
    };

    // Photo upload preview base64 helper
    window.uploadedPhotoData = null;
    window.handlePhotoUpload = function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                window.uploadedPhotoData = e.target.result;
                const preview = document.getElementById('photo_preview');
                if (preview) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">`;
                }
            };
            reader.readAsDataURL(file);
        }
    };

    // Enforce selection of exactly 3 elective subjects & restrict others
    window.validateSubjectSelection = function(group) {
        const selector = group === 'humanities' ? 'input[name="hum_electives"]' : 'input[name="mus_electives"]';
        const checked = document.querySelectorAll(`${selector}:checked`);
        
        // Toggle selected class on cards
        const cards = document.querySelectorAll(group === 'humanities' ? '#humanitiesSubjects .subject-checkbox-card' : '#musicSubjects .subject-checkbox-card');
        
        if (checked.length >= 3) {
            // Disable all other unchecked ones
            cards.forEach(card => {
                const input = card.querySelector('input');
                if (input.checked) {
                    card.classList.add('selected');
                } else {
                    card.classList.add('disabled');
                    input.disabled = true;
                }
            });
            if (checked.length > 3) {
                // Should not happen since we disabled others, but safety guard
                alert('You can select a maximum of 3 elective subjects.');
                event.target.checked = false;
                event.target.closest('.subject-checkbox-card').classList.remove('selected');
            }
        } else {
            // Enable all
            cards.forEach(card => {
                card.classList.remove('disabled');
                const input = card.querySelector('input');
                input.disabled = false;
                if (input.checked) {
                    card.classList.add('selected');
                } else {
                    card.classList.remove('selected');
                }
            });
        }
    };

    // Form submission event handler to append row to DOM table and register profile details
    window.handleAddStudentSubmit = function(event) {
        event.preventDefault();
        try {
            // Collect form data
            const nameEn = document.getElementById('student_name_en').value.trim();
        const nameBn = document.getElementById('student_name_bn').value.trim();
        const fatherBn = document.getElementById('father_name_bn').value.trim();
        const fatherEn = document.getElementById('father_name_en').value.trim();
        const motherBn = document.getElementById('mother_name_bn').value.trim();
        const motherEn = document.getElementById('mother_name_en').value.trim();
        
        const curVillage = document.getElementById('current_village').value.trim();
        const curPost = document.getElementById('current_post').value.trim();
        const curUpazila = document.getElementById('current_upazila').value.trim();
        const curDistrict = document.getElementById('current_district').value.trim();
        
        const permVillage = document.getElementById('permanent_village').value.trim();
        const permPost = document.getElementById('permanent_post').value.trim();
        const permUpazila = document.getElementById('permanent_upazila').value.trim();
        const permDistrict = document.getElementById('permanent_district').value.trim();
        
        const guardianName = document.getElementById('guardian_name').value.trim();
        const guardianVillage = document.getElementById('guardian_village').value.trim();
        const guardianPost = document.getElementById('guardian_post').value.trim();
        const guardianUpazila = document.getElementById('guardian_upazila').value.trim();
        const guardianDistrict = document.getElementById('guardian_district').value.trim();
        
        const occupation = document.getElementById('guardian_occupation').value.trim();
        const income = document.getElementById('annual_income').value.trim();
        
        const nationality = document.getElementById('student_nationality').value.trim();
        const religion = document.getElementById('student_religion').value;
        const community = document.getElementById('student_community').value.trim();
        const gender = document.getElementById('student_gender').value;
        
        const dob = document.getElementById('student_dob').value;
        const sscReg = document.getElementById('ssc_reg_no').value.trim();
        const sscSession = document.getElementById('ssc_session').value.trim();
        
        const sscBoard = document.getElementById('ssc_board').value.trim();
        const sscCenter = document.getElementById('ssc_center').value.trim();
        const sscRollInput = document.getElementById('ssc_roll').value.trim();
        const sscYear = document.getElementById('ssc_year').value.trim();
        const sscGrade = document.getElementById('ssc_grade').value.trim();
        
        const prevSchool = document.getElementById('prev_inst_name').value.trim();
        const prevSchoolPost = document.getElementById('prev_inst_post').value.trim();
        const prevSchoolUpazila = document.getElementById('prev_inst_upazila').value.trim();
        const prevSchoolDistrict = document.getElementById('prev_inst_district').value.trim();
        
        const desiredClass = document.getElementById('desired_class').value;
        const desiredBranch = document.getElementById('desired_branch').value;
        
        // Subjects selection validation
        const isHumanities = desiredBranch === 'Humanities';
        const checkedSelector = isHumanities ? 'input[name="hum_electives"]:checked' : 'input[name="mus_electives"]:checked';
        const electives = Array.from(document.querySelectorAll(checkedSelector)).map(el => el.value);
        
        const fourthSelectId = isHumanities ? 'hum_fourth_subject' : 'mus_fourth_subject';
        const fourthSubject = document.getElementById(fourthSelectId).value;
        
        if (electives.length !== 3) {
            alert("Please select exactly 3 elective subjects.");
            return;
        }
        if (!fourthSubject) {
            alert("Please select the fourth subject.");
            return;
        }
        if (electives.includes(fourthSubject)) {
            alert("Elective subject and fourth subject cannot be the same!");
            return;
        }
        
        const localGuardianName = document.getElementById('local_guardian_name').value.trim();
        const localGuardianVillage = document.getElementById('local_guardian_village').value.trim();
        const localGuardianPost = document.getElementById('local_guardian_post').value.trim();
        const localGuardianUpazila = document.getElementById('local_guardian_upazila').value.trim();
        const localGuardianDistrict = document.getElementById('local_guardian_district').value.trim();
        const localGuardianMobile = document.getElementById('local_guardian_mobile').value.trim();
        
        // Office fields
        const serialNo = 'N/A';
        const roll = document.getElementById('office_roll').value.trim() || 'N/A';
        const session = document.getElementById('office_session').value;
        const admissionDate = document.getElementById('office_admission_date').value || new Date().toISOString().slice(0, 10);
        
        if (!nameEn || !localGuardianMobile) {
            alert("Student name (English) and mobile number are required!");
            return;
        }
 
        // Generate ID
        const randomId = 'STD' + (new Date().getFullYear()) + String(Math.floor(1000 + Math.random() * 9000));
        
        // Photo URL
        const photoUrl = window.uploadedPhotoData || null;
 
        // Register profile
        const studentProfile = {
            id: randomId,
            serialNo,
            roll,
            session,
            admissionDate,
            nameEn,
            nameBn,
            fatherBn,
            fatherEn,
            motherBn,
            motherEn,
            addresses: {
                current: { village: curVillage, post: curPost, upazila: curUpazila, district: curDistrict },
                permanent: { village: permVillage, post: permPost, upazila: permUpazila, district: permDistrict }
            },
            guardian: {
                name: guardianName,
                address: { village: guardianVillage, post: guardianPost, upazila: guardianUpazila, district: guardianDistrict },
                occupation,
                income
            },
            nationality,
            religion,
            community,
            dob,
            ssc: {
                regNo: sscReg,
                session: sscSession,
                board: sscBoard,
                center: sscCenter,
                roll: sscRollInput,
                year: sscYear,
                grade: sscGrade
            },
            prevSchool: { name: prevSchool, post: prevSchoolPost, upazila: prevSchoolUpazila, district: prevSchoolDistrict },
            desiredClass,
            desiredBranch,
            subjects: {
                compulsory: isHumanities ? ["Bengali", "English", "ICT"] : ["Bengali", "English", "ICT", "Light Music", "Classical Music"],
                electives,
                fourth: fourthSubject
            },
            localGuardian: {
                name: localGuardianName,
                village: localGuardianVillage,
                post: localGuardianPost,
                upazila: localGuardianUpazila,
                district: localGuardianDistrict,
                mobile: localGuardianMobile
            },
            photoUrl
        };

        window.studentProfiles[randomId] = studentProfile;

        // Build avatar path for the row
        let avatarMarkup = '';
        if (photoUrl) {
            avatarMarkup = `<img src="${photoUrl}" alt="Photo" style="width:100%; height:100%; object-fit:cover;">`;
        } else {
            avatarMarkup = `
                <svg class="avatar-image" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="64" height="64" rx="32" fill="var(--muted)"/>
                    <circle cx="32" cy="28" r="11" fill="#fed7aa"/>
                    <path d="M14 56c0-8 8-12 18-12s18 4 18 12H14z" fill="var(--primary)"/>
                </svg>
            `;
        }
        
        const tr = document.createElement('tr');
        tr.setAttribute('data-name', nameEn);
        tr.setAttribute('data-id', randomId);
        tr.setAttribute('data-mob', localGuardianMobile);
        tr.setAttribute('data-session', session);
        tr.setAttribute('data-class', desiredClass);
        tr.setAttribute('data-section', desiredBranch);
        tr.setAttribute('data-gender', gender);
        tr.classList.add('matches-filter');
        tr.style.display = '';

        const tbody = document.querySelector('#studentTable tbody');
        const currentCount = tbody.querySelectorAll('tr').length;

        tr.innerHTML = `
            <td class="sl-column">${currentCount + 1}</td>
            <td>
                <div class="avatar-wrapper" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    ${avatarMarkup}
                </div>
            </td>
            <td>
                <div class="user-cell-name">${nameEn}</div>
                <p class="student-meta">ID: <span>${randomId}</span></p>
                <p class="student-meta">Mob: <span>${localGuardianMobile}</span></p>
            </td>
            <td>
                <div>
                    <span class="class-badge">${desiredClass}</span>
                    <span class="roll-badge">Roll: ${roll}</span>
                </div>
                <div class="academic-details-sub">
                    Sec: <span>${desiredBranch}</span>
                    Gender: <span>${gender}</span>
                </div>
            </td>
            <td class="action-column" style="text-align: right;">
                <div class="action-buttons" style="justify-content: flex-end;">
                    <button type="button" class="action-btn" title="View" onclick="viewStudentDetails(this)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.4                    <button type="button" class="action-btn" title="Edit" onclick="editStudentDetails(this)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button type="button" class="action-btn action-btn-danger" title="Delete" onclick="deleteStudentRow(this, '${nameEn}')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </td>
        `;

        if (window.currentEditingStudentId) {
            const editId = window.currentEditingStudentId;
            window.studentProfiles[editId] = studentProfile;
            
            // Find the row to update in the table
            const row = document.querySelector(`#studentTable tbody tr[data-id="${editId}"]`);
            if (row) {
                row.setAttribute('data-name', nameEn);
                row.setAttribute('data-mob', localGuardianMobile);
                row.setAttribute('data-session', session);
                row.setAttribute('data-class', desiredClass);
                row.setAttribute('data-section', desiredBranch);
                row.setAttribute('data-gender', gender);
                
                // Update text content of cells
                const nameCell = row.querySelector('.user-cell-name');
                if (nameCell) nameCell.textContent = nameEn;
                
                const mobSpan = row.querySelector('.student-meta span');
                // The mobile span is the second student-meta p block's span
                const mobMeta = row.querySelectorAll('.student-meta');
                if (mobMeta.length > 1) {
                    const span = mobMeta[1].querySelector('span');
                    if (span) span.textContent = localGuardianMobile;
                }
                
                const classBadge = row.querySelector('.class-badge');
                if (classBadge) classBadge.textContent = desiredClass;
                
                const rollBadge = row.querySelector('.roll-badge');
                if (rollBadge) rollBadge.textContent = `Roll: ${roll}`;
                
                const detailSpans = row.querySelectorAll('.academic-details-sub span');
                if (detailSpans.length > 0) detailSpans[0].textContent = desiredBranch;
                if (detailSpans.length > 1) detailSpans[1].textContent = gender;
                
                const avatar = row.querySelector('.avatar-wrapper');
                if (avatar) avatar.innerHTML = avatarMarkup;
            }
            window.currentEditingStudentId = null;
            hideAddStudentPage();
            alert("Admission details updated successfully!");
        } else {
            // Prepend new row at the very top of the table body
            tbody.insertBefore(tr, tbody.firstChild);
            hideAddStudentPage();
            alert("Admission completed successfully!");
        }
        
        // Persist the changes to LocalStorage
        if (typeof window.saveStudentsToLocalStorage === 'function') {
            window.saveStudentsToLocalStorage();
        }
        
        // Re-run search/filter table updates
        const activeSearchInput = document.getElementById('searchStudent');
        if (activeSearchInput) {
            activeSearchInput.value = '';
        }
        
        // Trigger list re-render
        if (typeof window.filterTable === 'function') {
            window.filterTable();
        }
        } catch (err) {
            console.error("Error in handleAddStudentSubmit:", err);
            alert("An error occurred during submission: " + err.message);
        }
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
@endsection
