<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi URL Pendaftaran (Poin Mandatory Tugas TUBES)
        // Memastikan input 'registration_link' benar-benar berformat URL standar
        $request->validate([
            'registration_link' => 'required|url',
        ]);

        // 2. Pengecekan agar tanggal tidak di masa lalu
        if (strtotime($request->event_date) < time()) {
            return back()
                ->with('error', 'Tanggal event tidak boleh di masa lalu!')
                ->withInput();
        }

        $posterPath = null;

        // 3. Upload poster
        if ($request->hasFile('poster')) {

            $posterPath = $request
                ->file('poster')
                ->store('posters', 'public');
        }

        // 4. Simpan ke database
        Event::create([

            'title' => $request->title,

            'slug' => Str::slug($request->title . '-' . time()),

            'description' => $request->description,

            'category' => $request->category,

            'prodi' => $request->prodi,

            'event_type' => $request->event_type,

            'event_date' => $request->event_date,

            'location' => $request->location,

            'price_type' => strtoupper($request->price) === 'FREE'
                ? 'gratis'
                : 'berbayar',

            'price' => $request->price,

            'target_participants' => $request->target_participants,

            'registration_link' => $request->registration_link,

            'organizer_name' => $request->organizer_name,

            'contact_person' => $request->contact_person,

            'poster' => $posterPath,

            'is_tak' => $request->has('is_tak'),

            'status' => 'pending',

            'submitted_by' => 'guest',

            'submitted_email' => 'guest@email.com',
        ]);

        return redirect('/')
            ->with('success', 'Event berhasil ditambahkan!');
    }
}