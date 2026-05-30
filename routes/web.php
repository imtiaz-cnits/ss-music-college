<?php

use Illuminate\Support\Facades\Route;
use App\Models\Notice;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CustomProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicEventController;

// Home page
Route::get('/', function () {
    $notices = \App\Models\Notice::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
    $galleries = \App\Models\Gallery::orderBy('id', 'desc')->take(4)->get();

    $sliderEvents = \App\Models\Event::with('images')->orderBy('event_date', 'desc')->orderBy('id', 'desc')->take(5)->get();

    return view('frontend.index', compact('notices', 'galleries', 'sliderEvents'));
})->name('home');

Route::get('/institution-history', function () {
    return view('frontend.institution-history');
})->name('history');
Route::get('/institution-details', function () {
    return view('frontend.institution-details');
})->name('details');
Route::get('/principal-message', function () {
    return view('frontend.principal-message');
})->name('principal_message');
Route::get('/chairman', function () {
    return view('frontend.chairman');
})->name('chairman');
Route::get('/chairman-governing-body', function () {
    return view('frontend.chairman-governing-body');
})->name('chairman_governing_body');
Route::get('/governing-body-approval', function () {
    return view('frontend.governing-body-approval');
})->name('governing_body_approval');
Route::get('/teachers', function () {
    return view('frontend.teachers');
})->name('teachers');

// Notice page
Route::get('/notice', function () {
    $notices = Notice::orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(15);
    return view('frontend.notice', compact('notices'));
})->name('notice');

// Single Notice Details Page
Route::get('/notice/{id}', function ($id) {
    $notice = Notice::findOrFail($id);
    return view('frontend.notice-single', compact('notice'));
})->name('notice.single');

Route::get('/result', function () {
    return view('frontend.result');
})->name('result');

Route::get('/gallery', function () {
    $galleries = \App\Models\Gallery::orderBy('id', 'desc')->paginate(12);
    return view('frontend.gallery', compact('galleries'));
})->name('gallery');

// Frontend Event Routes
Route::get('/event', [App\Http\Controllers\PublicEventController::class, 'index'])->name('event');
Route::get('/event/{id}', [App\Http\Controllers\PublicEventController::class, 'show'])->name('single_event');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

Route::get('/students-info', function () {
    return view('frontend.students-info');
})->name('students_info');
Route::get('/students-session-23-24', function () {
    return view('frontend.students-session-23-24');
})->name('students_23_24');
Route::get('/students-session-24-25', function () {
    return view('frontend.students-session-24-25');
})->name('students_24_25');

Route::get('/teaching-permission', function () {
    return view('frontend.teaching-permission');
})->name('teaching_permission');
Route::get('/acceptance-renewal', function () {
    return view('frontend.acceptance_renewal');
})->name('acceptance_renewal');
Route::get('/class-routine', function () {
    return view('frontend.class-routine');
})->name('class_routine');
Route::get('/municipality-certification-letter', function () {
    return view('frontend.municipality-certification-letter');
})->name('municipality_certification');

// Notice Download Route
Route::get('/notice/download/{id}', [NoticeController::class, 'download'])->name('notices.download');

// Admin Dashboard Routes
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('notices', NoticeController::class);
    Route::resource('galleries', GalleryController::class);
    Route::put('/profile/update', [App\Http\Controllers\CustomProfileController::class, 'update'])->name('tyro-dashboard.profile.update');

    // ইভেন্ট ম্যানেজমেন্টের রাউট
    Route::get('/events', [App\Http\Controllers\PublicEventController::class, 'adminIndex'])->name('dashboard.events.index');
    Route::get('/events/create', [App\Http\Controllers\PublicEventController::class, 'create'])->name('dashboard.events.create');
    Route::post('/events', [App\Http\Controllers\PublicEventController::class, 'store'])->name('dashboard.events.store');
    Route::get('/events/{id}/edit', [App\Http\Controllers\PublicEventController::class, 'edit'])->name('dashboard.events.edit');
    Route::put('/events/{id}', [App\Http\Controllers\PublicEventController::class, 'update'])->name('dashboard.events.update');
    Route::delete('/events/{id}', [App\Http\Controllers\PublicEventController::class, 'destroy'])->name('dashboard.events.destroy');
});
