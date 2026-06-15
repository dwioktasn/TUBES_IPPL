<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEventNotificationMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi URL Pendaftaran (Poin Mandatory Tugas TUBES)
        // Memastikan input 'registration_link' benar-benar berformat URL standar jika diisi
        $request->validate([
            'registration_link' => 'nullable|url',
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
        $event = Event::create([

            'title' => $request->title,

            'slug' => Str::slug($request->title . '-' . time()),

            'description' => $request->description,

            'category' => $request->category,

            'prodi' => $request->prodi,

            'event_type' => $request->event_type,

            'event_date' => $request->event_date,

            'location' => $request->location,

            'price_type' => (
                str_contains(strtoupper($request->price), 'FREE') ||
                str_contains(strtoupper($request->price), 'GRATIS') ||
                trim($request->price) === '0'
            ) ? 'gratis' : 'berbayar',

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

        // 5. Kirim notifikasi email ke Admin
        try {
            $admin = User::where('role', 'admin')->first();
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new NewEventNotificationMail($event));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim email notifikasi ke admin: ' . $e->getMessage());
        }

        return redirect()->route('submit-success');
    }

    public function extractPoster(Request $request)
    {
        $request->validate([
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $customKey = $request->header('X-Gemini-Key');

        try {
            $file = $request->file('poster');
            $mimeType = $file->getMimeType();
            $base64Data = base64_encode(file_get_contents($file->getRealPath()));

            $prompt = "Kamu adalah sistem pemindai poster event otomatis untuk situs TelU Events.
Tugas kamu adalah mengekstrak data dari gambar poster event yang diberikan dan mengembalikannya dalam format JSON yang bersih dan valid.
Format JSON harus memiliki struktur persis seperti berikut tanpa markdown wrapper (seperti ```json ... ```), cukup mentah (raw string JSON):
{
  \"title\": \"Judul event yang relevan\",
  \"description\": \"\",
  \"category\": \"seminar|workshop|kompetisi|kepanitiaan|lainnya\",
  \"event_type\": \"online|offline|hybrid\",
  \"event_date\": \"YYYY-MM-DD HH:MM\",
  \"location\": \"Lokasi event (misalnya nama gedung, ruangan, link Zoom, YouTube, atau platform lainnya)\",
  \"price\": \"Harga tiket masuk, contoh: 'GRATIS' atau 'Rp 15.000'\",
  \"target_participants\": \"Target peserta, misalnya: 'Mahasiswa Tel-U, Umum'\",
  \"registration_link\": \"URL pendaftaran lengkap (jika ada di poster, misalnya: https://bit.ly/xxxx. Jika tidak ditemukan, kosongkan atau isi dengan link pendaftaran yang valid jika ada, tapi jika tidak ada isi string kosong '')\",
  \"organizer_name\": \"Nama organisasi/penyelenggara\",
  \"contact_person\": \"Nama/Nomor kontak person, contoh: 'Kak Rani (08123456789)'\",
  \"is_tak\": true|false,
  \"oprec_divisions\": \"Daftar divisi yang dibuka (hanya diisi jika category adalah kepanitiaan, kosongkan '' jika bukan)\",
  \"oprec_requirements\": \"Daftar kualifikasi/persyaratan (hanya diisi jika category adalah kepanitiaan, kosongkan '' jika bukan)\",
  \"oprec_timeline\": \"Timeline seleksi lengkap (hanya diisi jika category adalah kepanitiaan, kosongkan '' jika bukan)\"
}

PENTING:
- Untuk 'description', SELALU kembalikan string kosong \"\".
- Pilihlah salah satu dari nilai opsi untuk 'category' (seminar, workshop, kompetisi, kepanitiaan, lainnya) dan 'event_type' (online, offline, hybrid) yang paling cocok dengan poster.
- Jika poster adalah rekrutmen panitia (Open Recruitment / OPREC), set 'category' menjadi 'kepanitiaan' dan 'price' menjadi 'GRATIS'. Ekstrak daftar divisi ke 'oprec_divisions', kualifikasi/syarat ke 'oprec_requirements', dan jadwal/timeline ke 'oprec_timeline'.
- Untuk 'event_date', konversi tanggal yang tertera di poster menjadi format standar 'YYYY-MM-DD HH:MM'. Jika poster adalah kepanitiaan/OPREC, gunakan batas akhir/deadline pendaftaran (closing date) sebagai event_date. Jika tahun tidak ada di poster, asumsikan tahun saat ini atau tahun depan (2026). Jika waktu jam tidak ada, asumsikan pukul 23:59 atau jam yang masuk akal. Pastikan output event_date mengikuti format 'YYYY-MM-DD HH:MM'.
- Jika ada indikasi TAK (Transkrip Aktivitas Kemahasiswaan) atau poin TAK di poster, set 'is_tak' menjadi true, jika tidak atau ragu set false.
- Kembalikan HANYA string JSON valid. Jangan tambahkan kata pengantar, penjelasan, backticks, atau karakter lain di luar JSON.";

            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ],
                            [
                                'inlineData' => [
                                    'mimeType' => $mimeType,
                                    'data' => $base64Data
                                ]
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                ]
            ];

            $response = $this->postToGemini('gemini-2.5-flash:generateContent', $payload, $customKey);

            if (!$response || $response->failed()) {
                $body = $response ? $response->body() : 'No response';
                Log::error('Gemini API call failed: ' . $body);
                $resJson = $response ? $response->json() : null;
                $errMsg = $resJson['error']['message'] ?? '';
                if ($response && ($response->status() === 429 || str_contains($errMsg, 'Quota exceeded') || str_contains($errMsg, 'limit'))) {
                    return response()->json([
                        'error' => 'Batas kecepatan (Rate Limit) API Gemini gratis terlampaui. Harap tunggu sekitar 10-15 detik lalu coba lagi.'
                    ], 429);
                }
                return response()->json([
                    'error' => 'Gagal memanggil API Gemini. Silakan coba lagi.'
                ], 502);
            }

            $result = $response->json();
            $textResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

            $cleanJson = trim($textResponse);
            if (str_starts_with($cleanJson, '```')) {
                $cleanJson = preg_replace('/^```(?:json)?\s+|\s+```$/', '', $cleanJson);
            }

            $data = json_decode($cleanJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Failed to parse Gemini response as JSON: ' . $textResponse);
                return response()->json([
                    'error' => 'Format data dari AI tidak valid. Silakan coba lagi atau isi secara manual.',
                    'raw' => $textResponse
                ], 500);
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Error in extractPoster: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array'
        ]);

        $customKey = $request->header('X-Gemini-Key');

        try {
            // 1. Ambil event aktif (hari ini dan mendatang)
            $activeEvents = Event::where('status', 'approved')
                                 ->where('event_date', '>=', now()->subDays(1))
                                 ->orderBy('event_date', 'asc')
                                 ->get();

            // 2. Buat ringkasan event untuk AI (Dikontraksi untuk menghemat token)
            $eventsSummary = "";
            if ($activeEvents->isEmpty()) {
                $eventsSummary = "Tidak ada event aktif saat ini.";
            } else {
                foreach ($activeEvents as $index => $event) {
                    $takText = $event->is_tak ? "TAK" : "Non-TAK";
                    $priceText = $event->price_type === 'gratis' ? "Gratis" : $event->price;
                    $dateText = \Carbon\Carbon::parse($event->event_date)->format('Y-m-d H:i');
                    
                    $eventsSummary .= "#" . ($index + 1) . ": {$event->title}\n";
                    $eventsSummary .= "   Kat: {$event->category} | Tipe: {$event->event_type} | {$dateText} | {$event->location}\n";
                    $eventsSummary .= "   Biaya: {$priceText} | {$takText} | Penyelenggara: {$event->organizer_name}\n";
                    $eventsSummary .= "   Link: {$event->registration_link}\n";
                    
                    $shortDesc = Str::limit(strip_tags($event->description), 80);
                    $eventsSummary .= "   Desc: {$shortDesc}\n\n";
                }
            }

            // 3. Format riwayat obrolan
            $contents = [];
            $history = $request->input('history', []);
            
            foreach ($history as $msg) {
                if (isset($msg['role']) && isset($msg['text'])) {
                    $contents[] = [
                        'role' => $msg['role'] === 'user' ? 'user' : 'model',
                        'parts' => [
                            ['text' => $msg['text']]
                        ]
                    ];
                }
            }

            // Tambahkan pesan saat ini
            $contents[] = [
                'role' => 'user',
                'parts' => [
                    ['text' => $request->input('message')]
                ]
            ];

            // 4. Hubungi API Gemini
            $instructionText = "Kamu adalah Asisten AI TelU Events, pendamping cerdas mahasiswa Telkom University. 
Tugasmu adalah membantu pengguna menemukan, memahami, dan mendaftar event kampus terbaik berdasarkan database event aktif yang kami sediakan di bawah ini.

DATA EVENT AKTIF SAAT INI DI TELKOM UNIVERSITY:
" . $eventsSummary . "

PANDUAN & ATURAN PLATFORM:
- Poin TAK (Transkrip Aktivitas Kemahasiswaan) hanya diberikan untuk event yang bertanda khusus (is_tak = true). Jika ditanya event TAK, pastikan mereferensikan event tersebut.
- Pengguna dapat mengajukan event mereka sendiri melalui halaman '/submit-event'. Proses verifikasi dilakukan oleh admin.
- Kategori event yang didukung: Seminar, Workshop, Kompetisi, Kepanitiaan (OPREC), dan Lainnya.
- Event Kepanitiaan (OPREC) selalu gratis untuk mahasiswa.

ATURAN KOMUNIKASI:
- Berbicaralah dengan gaya bahasa santai mahasiswa Telkom University yang ramah, sopan, bersahabat, ringkas, dan solutif. Gunakan kata sapaan seperti 'Halo kawan', 'Halo teman-teman', dll.
- Gunakan format markdown yang rapi (list, bold, dll.) untuk menyajikan daftar event.
- Selalu cantumkan tautan pendaftaran (registration_link) secara jelas dengan menggunakan format [Daftar di Sini](link) jika ada event yang diminati pengguna.
- Jika ada pertanyaan di luar topik TelU Events atau event kampus, jawab dengan sopan bahwa kamu hanya bisa membantu seputar event kampus Telkom University.";

            $payload = [
                'contents' => $contents,
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $instructionText]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ]
            ];

            $response = $this->postToGemini('gemini-2.5-flash:generateContent', $payload, $customKey);

            if (!$response || $response->failed()) {
                $body = $response ? $response->body() : 'No response';
                Log::error('Gemini Chat API call failed: ' . $body);
                $resJson = $response ? $response->json() : null;
                $errMsg = $resJson['error']['message'] ?? '';
                if ($response && ($response->status() === 429 || str_contains($errMsg, 'Quota exceeded') || str_contains($errMsg, 'limit'))) {
                    return response()->json([
                        'error' => 'Asisten AI sedang sibuk karena batas kuota gratis terlampaui. Harap tunggu beberapa detik lalu coba lagi.'
                    ], 429);
                }
                return response()->json([
                    'error' => 'Gagal mendapatkan balasan dari AI. Silakan coba lagi.'
                ], 502);
            }

            $result = $response->json();
            $reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak dapat memahami itu.';

            return response()->json([
                'success' => true,
                'reply' => $reply
            ]);

        } catch (\Exception $e) {
            Log::error('Error in chatbot chat method: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Call Gemini API with automatic key rotation and retries.
     */
    private function postToGemini($modelAction, $payload, $customKey = null)
    {
        $keys = [];
        
        if (!empty($customKey)) {
            $keys[] = trim($customKey);
        } else {
            $rawKeys = config('services.gemini.key') ?: env('GEMINI_API_KEY');
            if (!empty($rawKeys)) {
                if (str_contains($rawKeys, ',')) {
                    $keys = array_filter(array_map('trim', explode(',', $rawKeys)));
                } else {
                    $keys[] = trim($rawKeys);
                }
            }
        }

        if (empty($keys)) {
            throw new \Exception('API Key Gemini belum dikonfigurasi.');
        }

        // Shuffle keys to distribute traffic randomly
        shuffle($keys);

        $lastResponse = null;
        
        foreach ($keys as $index => $key) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelAction}?key=" . $key;
            
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($url, $payload);

                if ($response->successful()) {
                    return $response;
                }

                $lastResponse = $response;
                $resJson = $response->json();
                $errMsg = $resJson['error']['message'] ?? '';
                
                // If it is a rate limit error, log and try next key
                if ($response->status() === 429 || str_contains($errMsg, 'Quota exceeded') || str_contains($errMsg, 'limit')) {
                    $maskedKey = substr($key, 0, 5) . '...' . substr($key, -5);
                    Log::warning("Gemini API Key {$maskedKey} terkena rate limit (429). Mencoba kunci berikutnya...");
                    continue;
                }
                
                // For other failures (e.g. invalid request), break and return this response
                break;
                
            } catch (\Exception $e) {
                Log::error("Koneksi ke Gemini gagal menggunakan salah satu key: " . $e->getMessage());
                if ($index === count($keys) - 1) {
                    throw $e;
                }
            }
        }

        return $lastResponse;
    }
}