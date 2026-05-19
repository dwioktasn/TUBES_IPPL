<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\ContactMessageMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];

        // Ambil admin
        $admin = User::where('role', 'admin')->first();
        $adminEmail = $admin && $admin->email ? $admin->email : 'admin@teluevents.com';

        Mail::to($adminEmail)->send(new ContactMessageMail($data));

        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda kembali.');
    }
}
