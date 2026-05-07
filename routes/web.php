<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController; // INI WAJIB

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $events = Event::where('status', 'approved')
                   ->latest()
                   ->get();

    return view('index', compact('events'));
})->name('home');

Route::get('/event/{slug}', function ($slug) {
    $event = Event::where('slug', $slug)->firstOrFail();
    return view('event_detail', compact('event'));
})->name('event.detail');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/submit-event', function () {
    return view('submit_event');
})->name('submit-event');

Route::post('/submit-event', [EventController::class, 'store'])
    ->name('events.store');

    // LOGIN ADMIN
Route::get('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/login', [AdminController::class, 'authenticate']);


// DASHBOARD ADMIN
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// AKSI ADMIN
Route::post('/admin/event/{id}/approve', [AdminController::class, 'approve'])->name('admin.event.approve');
Route::post('/admin/event/{id}/reject', [AdminController::class, 'reject'])->name('admin.event.reject');
Route::delete('/admin/event/{id}', [AdminController::class, 'destroy'])->name('admin.event.destroy');