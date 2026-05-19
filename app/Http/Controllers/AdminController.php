<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'admin')
                    ->first();

        if (!$user) {
            return back()->with('error', 'Email admin tidak terdaftar');
        }

        $otp = rand(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));

        return view('admin.verify-otp', [
            'email' => $user->email
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'admin')
                    ->first();

        if (!$user) {
            return view('admin.verify-otp', [
                'email' => $request->email
            ])->with('error', 'User tidak ditemukan');
        }

        if ($user->otp_code != $request->otp) {
            return view('admin.verify-otp', [
                'email' => $request->email
            ])->with('error', 'Kode OTP tidak valid');
        }

        if (now()->gt($user->otp_expired_at)) {
            return view('admin.verify-otp', [
                'email' => $request->email
            ])->with('error', 'Kode OTP sudah kadaluarsa');
        }

        session([
            'admin_logged_in' => true,
            'admin_id' => $user->id
        ]);

        // hapus OTP setelah dipakai
        $user->otp_code = null;
        $user->otp_expired_at = null;
        $user->save();

        return redirect('/admin/dashboard');
    }

    public function dashboard(Request $request)
    {
        // CEK LOGIN
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        // Statistik
        $totalEvents = Event::count();
        $pendingEvents = Event::where('status', 'pending')->count();
        $verifiedEvents = Event::where('status', 'approved')->count();
        $rejectedEvents = Event::where('status', 'rejected')->count();

        // 5 Event Pending Terbaru
        $latestPendingEvents = Event::where('status', 'pending')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('admin.dashboard', compact(
            'totalEvents', 
            'pendingEvents', 
            'verifiedEvents', 
            'rejectedEvents',
            'latestPendingEvents'
        ));
    }

    public function events(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $query = Event::query();

        // Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('organizer_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Urutkan terbaru
        $events = $query->latest()->get()->sortBy(function($event) {
            return \Carbon\Carbon::parse($event->event_date)->isPast() ? 1 : 0;
        })->values();

        $pendingCount = Event::where('status', 'pending')->count();
        $verifiedCount = Event::where('status', 'approved')->count();
        $rejectedCount = Event::where('status', 'rejected')->count();

        return view('admin.events', compact('events', 'pendingCount', 'verifiedCount', 'rejectedCount'));
    }

    public function calendar()
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        // Ambil semua event untuk ditampilkan di kalender
        $events = Event::all();

        // Format data untuk FullCalendar
        $calendarEvents = [];
        foreach ($events as $event) {
            // Tentukan warna berdasarkan status
            $color = '#3788d8'; // default blue
            if ($event->status == 'approved') {
                $color = '#10B981'; // green
            } elseif ($event->status == 'pending') {
                $color = '#F59E0B'; // orange
            } elseif ($event->status == 'rejected') {
                $color = '#EF4444'; // red
            }

            $calendarEvents[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i:s'),
                'color' => $color,
                'url' => route('admin.events', ['search' => $event->title]) // Link ke manajemen event
            ];
        }

        return view('admin.calendar', compact('calendarEvents'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        return view('admin.event_form');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $request->validate([
            'registration_link' => 'required|url',
        ]);

        if (strtotime($request->event_date) < time()) {
            return back()
                ->with('error', 'Tanggal event tidak boleh di masa lalu!')
                ->withInput();
        }

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        Event::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title . '-' . time()),
            'description' => $request->description,
            'category' => $request->category,
            'prodi' => $request->prodi,
            'event_type' => $request->event_type,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'price_type' => strtoupper($request->price) === 'FREE' ? 'gratis' : 'berbayar',
            'price' => $request->price,
            'target_participants' => $request->target_participants,
            'registration_link' => $request->registration_link,
            'organizer_name' => $request->organizer_name,
            'contact_person' => $request->contact_person,
            'poster' => $posterPath,
            'is_tak' => $request->has('is_tak'),
            'status' => 'approved', // Langsung approved
            'submitted_by' => 'admin',
            'submitted_email' => 'admin@email.com', // Atur default untuk admin
        ]);

        return redirect()->route('admin.events')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $event = Event::findOrFail($id);
        
        return view('admin.event_form', compact('event'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $event = Event::findOrFail($id);

        $request->validate([
            'registration_link' => 'required|url',
        ]);

        $posterPath = $event->poster;
        if ($request->hasFile('poster')) {
            // Opsional: Hapus poster lama
            if ($posterPath && Storage::disk('public')->exists($posterPath)) {
                Storage::disk('public')->delete($posterPath);
            }
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'prodi' => $request->prodi,
            'event_type' => $request->event_type,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'price_type' => strtoupper($request->price) === 'FREE' ? 'gratis' : 'berbayar',
            'price' => $request->price,
            'target_participants' => $request->target_participants,
            'registration_link' => $request->registration_link,
            'organizer_name' => $request->organizer_name,
            'contact_person' => $request->contact_person,
            'poster' => $posterPath,
            'is_tak' => $request->has('is_tak')
        ]);

        return redirect()->route('admin.events')->with('success', 'Event berhasil diperbarui!');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $event = Event::findOrFail($id);
        
        return view('admin.event_detail', compact('event'));
    }

    public function approve($id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $event = Event::findOrFail($id);
        $event->status = 'approved';
        $event->approved_at = now();
        // $event->approved_by = auth()->id(); // kalau ada auth
        $event->save();

        return back()->with('success', 'Event berhasil diverifikasi!');
    }

    public function reject($id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        return back()->with('success', 'Event ditolak!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $event = Event::findOrFail($id);
        $event->delete();

        return back()->with('success', 'Event berhasil dihapus!');
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        session()->forget('admin_id');

        return redirect('/admin/login');
    }
}