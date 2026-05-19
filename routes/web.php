<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function (\Illuminate\Http\Request $request) {
    $query = Event::where('status', 'approved');

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('organizer_name', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    if ($request->has('event_type') && $request->event_type != '') {
        $query->where('event_type', $request->event_type);
    }

    if ($request->has('prodi') && $request->prodi != '') {
        $query->where('prodi', $request->prodi);
    }

    $events = $query->latest()->get()->sortBy(function($event) {
        return \Carbon\Carbon::parse($event->event_date)->isPast() ? 1 : 0;
    })->values();

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

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/submit-event', function () {
    return view('submit_event');
})->name('submit-event');

Route::post('/submit-event', [EventController::class, 'store'])
    ->name('events.store');

// LOGIN ADMIN
Route::get('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login');

Route::post('/admin/send-otp', [AdminController::class, 'sendOtp']);

Route::post('/admin/verify-otp', [AdminController::class, 'verifyOtp']);


// DASHBOARD ADMIN
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');

Route::get('/admin/events', [AdminController::class, 'events'])
    ->name('admin.events');

Route::get('/admin/calendar', [AdminController::class, 'calendar'])
    ->name('admin.calendar');

Route::get('/admin/event/create', [AdminController::class, 'create'])
    ->name('admin.event.create');
Route::post('/admin/event', [AdminController::class, 'store'])
    ->name('admin.event.store');
Route::get('/admin/event/{id}/edit', [AdminController::class, 'edit'])
    ->name('admin.event.edit');
Route::put('/admin/event/{id}', [AdminController::class, 'update'])
    ->name('admin.event.update');
Route::get('/admin/event/{id}', [AdminController::class, 'show'])
    ->name('admin.event.show');

// AKSI ADMIN
Route::post('/admin/event/{id}/approve', [AdminController::class, 'approve'])
    ->name('admin.event.approve');

Route::post('/admin/event/{id}/reject', [AdminController::class, 'reject'])
    ->name('admin.event.reject');

Route::delete('/admin/event/{id}', [AdminController::class, 'destroy'])
    ->name('admin.event.destroy');

Route::post('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');