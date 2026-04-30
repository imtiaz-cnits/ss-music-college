@extends('layouts.frontend')

@section('title', $notice->title . ' - Notice')

@section('content')
@php
    function convertToBangla($string) {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'AM', 'PM', 'am', 'pm'];
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', 'এএম', 'পি.এম', 'এএম', 'পি.এম'];
        return str_replace($en, $bn, $string);
    }
@endphp

<main>
    <!-- Page Header -->
    <div class="page-header" style="background-color: #f8f9fa; padding-top: 40px 0; border-bottom: 1px solid #eee;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: #da1e37;">প্রথম পাতা</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('notice') }}" class="text-decoration-none" style="color: #da1e37;">নোটিশ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">নোটিশ বিস্তারিত</li>
                        </ol>
                    </nav>
                    <h2 class="mb-0 fw-bold" style="color: #333;">নোটিশ বিস্তারিত</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Notice Content -->
    <section class="notice-details-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <!-- Notice Header -->
                            <div class="notice-header mb-4 pb-4 border-bottom">
                                <h3 class="fw-bold mb-3" style="color: #2c3e50;">{{ $notice->title }}</h3>
                                <div class="d-flex flex-wrap gap-3 text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt me-2 text-danger"></i>
                                        প্রকাশের তারিখ: <span class="ms-1 fw-medium text-dark">{{ convertToBangla(\Carbon\Carbon::parse($notice->date)->locale('bn')->translatedFormat('d F, Y')) }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock me-2 text-danger"></i>
                                        সময়: <span class="ms-1 fw-medium text-dark">{{ convertToBangla(\Carbon\Carbon::parse($notice->created_at)->format('h:i A')) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Notice Description -->
                            @if($notice->description)
                                <div class="notice-description mt-4 mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #444;">
                                    {!! nl2br(e($notice->description)) !!}
                                </div>
                            @endif

                            <!-- Notice Attachment/File -->
                            <div class="notice-attachment text-center mt-5">
                                @if($notice->file)
                                    @php
                                        $extension = pathinfo($notice->file, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <!-- If it's an image, show it directly -->
                                        <div class="mb-4">
                                            <img src="{{ asset('storage/' . $notice->file) }}" alt="{{ $notice->title }}" class="img-fluid rounded border shadow-sm" style="max-height: 800px; width: auto;">
                                        </div>
                                    @elseif(strtolower($extension) === 'pdf')
                                        <!-- If it's a PDF, show an iframe or a distinct button -->
                                        <div class="mb-4 ratio ratio-16x9 d-none d-md-block" style="min-height: 600px;">
                                            <iframe src="{{ asset('storage/' . $notice->file) }}" class="rounded border shadow-sm" allowfullscreen></iframe>
                                        </div>
                                        <div class="d-block d-md-none mb-4 p-4 bg-light rounded text-center border">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                            <h5>PDF ফাইল সংযুক্ত করা আছে</h5>
                                            <p class="text-muted small">ফাইলটি দেখতে নিচের বাটনে ক্লিক করুন</p>
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-center gap-3 mt-4">
                                        <a href="{{ asset('storage/' . $notice->file) }}" target="_blank" class="btn btn-outline-danger px-4 py-2 rounded-pill fw-medium">
                                            <i class="fas fa-external-link-alt me-2"></i> ফুলস্ক্রিনে দেখুন
                                        </a>
                                        <a href="{{ route('notices.download', $notice->id) }}" class="btn px-4 py-2 rounded-pill fw-medium text-white" style="background-color: #da1e37;">
                                            <i class="fas fa-download me-2"></i> ডাউনলোড করুন
                                        </a>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection