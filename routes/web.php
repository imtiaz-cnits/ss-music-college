<?php

use Illuminate\Support\Facades\Route;
use App\Models\Notice; 
use App\Http\Controllers\NoticeController;

// Home page
Route::get('/', function () {
    $notices = Notice::orderBy('date', 'desc')->get();
    return view('frontend.index', compact('notices'));
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
    $notices = Notice::orderBy('date', 'desc')->paginate(15);
    return view('frontend.notice', compact('notices'));
})->name('notice');

Route::get('/result', function () {
    return view('frontend.result');
})->name('result');
Route::get('/gallery', function () {
    return view('frontend.gallery');
})->name('gallery');
Route::get('/event', function () {
    return view('frontend.event');
})->name('event');
Route::get('/single-event', function () {
    return view('frontend.single-event');
})->name('single_event');
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


// =========================================

Route::get('/municipality-certification-letter', function () {
    return view('frontend.municipality-certification-letter');
})->name('municipality_certification');

// Admin Dashboard Routes
Route::get('/notice/download/{id}', [NoticeController::class, 'download'])->name('notices.download');

// Admin Dashboard Routes
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('notices', NoticeController::class);
});
