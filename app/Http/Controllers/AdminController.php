<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        // LOGIN SEDERHANA
        if ($username === 'admin' && $password === 'admin123') {

            session([
                'admin_logged_in' => true
            ]);

            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function dashboard(Request $request)
    {
        // CEK LOGIN
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
        $events = $query->latest()->get();

        // Statistik
        $totalEvents = Event::count();
        $pendingEvents = Event::where('status', 'pending')->count();
        $verifiedEvents = Event::where('status', 'approved')->count();
        $rejectedEvents = Event::where('status', 'rejected')->count();

        return view('admin.dashboard', compact(
            'events', 
            'totalEvents', 
            'pendingEvents', 
            'verifiedEvents', 
            'rejectedEvents'
        ));
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
}