<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - TelU Events</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</head>
<body style="background-color: #F9FAFB;">

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- MAIN CONTENT -->
    <main class="container" style="width: 100%; max-width: 960px; margin: 40px auto; background: var(--white); border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #E5E7EB; overflow: hidden; padding: 0;">
        
        <!-- Poster Section -->
        <div style="background: #F3F4F6; width: 100%; display: flex; justify-content: center; align-items: center;">
            <div style="position: relative; width: 100%; max-width: 400px; aspect-ratio: 3 / 4; background: #e5e7eb;">
                <img src="{{ $event->poster ? asset('storage/' . $event->poster) : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3' }}" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; top: 16px; right: 16px; display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                    @if($event->is_tak)
                        <span class="tag-badge tag-tak" style="padding: 6px 16px; font-size: 0.8rem;">TAK</span>
                    @endif
                    @if($event->price_type === 'gratis')
                        <span class="tag-badge tag-gratis" style="padding: 6px 16px; font-size: 0.8rem;">GRATIS</span>
                    @else
                        <span class="tag-badge tag-berbayar" style="padding: 6px 16px; font-size: 0.8rem;">BERBAYAR</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div style="padding: 32px;">
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
                <div>
                    @if($event->prodi)
                    <div style="margin-bottom: 12px;">
                        <span style="display: inline-flex; align-items: center; gap: 4px; background-color: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 700;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                            Khusus Prodi {{ $event->prodi }}
                        </span>
                    </div>
                    @endif
                    <h1 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0; line-height: 1.3;">{{ $event->title }}</h1>
                </div>
                <button class="btn" style="background: #F1F5F9; color: #374151; padding: 8px 16px; font-size: 0.85rem; font-weight: 600; border-radius: 6px; flex-shrink: 0; display: flex; align-items: center; gap: 6px;" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan disalin!')">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                    Bagikan
                </button>
            </div>

            <!-- Grid Info -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 2px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <div>
                        <div style="font-size: 0.75rem; color: #6B7280; margin-bottom: 4px;">Tanggal & Waktu</div>
                        <div style="font-weight: 500; color: #111827; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($event->event_date)->locale('id')->translatedFormat('l, d F Y') }}</div>
                        <div style="font-size: 0.8rem; color: #4B5563; margin-top: 2px;">{{ \Carbon\Carbon::parse($event->event_date)->format('H.i') }} WIB</div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 2px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <div>
                        <div style="font-size: 0.75rem; color: #6B7280; margin-bottom: 4px;">Lokasi</div>
                        <div style="font-weight: 500; color: #111827; font-size: 0.9rem;">{{ $event->location }}</div>
                        @if($event->event_type)
                        <div style="font-size: 0.8rem; color: #4B5563; margin-top: 2px;">{{ ucfirst($event->event_type) }}</div>
                        @endif
                    </div>
                </div>

                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 2px;"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <div>
                        <div style="font-size: 0.75rem; color: #6B7280; margin-bottom: 4px;">Kategori</div>
                        <div style="font-weight: 500; color: #111827; font-size: 0.9rem;">{{ ucfirst($event->category) }}</div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 2px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <div>
                        <div style="font-size: 0.75rem; color: #6B7280; margin-bottom: 4px;">Target Peserta</div>
                        <div style="font-weight: 500; color: #111827; font-size: 0.9rem;">{{ $event->target_participants }}</div>
                        @if($event->prodi)
                        <div style="font-size: 0.8rem; color: #DC2626; margin-top: 2px; font-weight: 600;">Khusus {{ $event->prodi }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Biaya Pendaftaran -->
            <div style="background: #F9FAFB; border-radius: 8px; padding: 16px 20px; margin-bottom: 24px;">
                <div style="font-size: 0.8rem; color: #9CA3AF; margin-bottom: 6px;">Biaya Pendaftaran</div>
                <div style="font-size: 1.25rem; font-weight: 700; color: #111827;">
                    @if($event->price_type === 'gratis')
                        FREE
                    @else
                        {{ $event->price }}
                    @endif
                </div>
            </div>

            <!-- TAK -->
            @if($event->is_tak)
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 16px 20px; margin-bottom: 32px; display: flex; gap: 12px; align-items: flex-start;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#DC2626" stroke="none" style="flex-shrink: 0; margin-top: 2px;">
                    <circle cx="12" cy="12" r="12"></circle>
                    <polyline points="7 12.5 10.5 16 17 8" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></polyline>
                </svg>
                <div>
                    <div style="font-weight: 700; font-size: 0.95rem; color: #B91C1C; margin-bottom: 4px;">Event Memberikan Nilai TAK</div>
                    <div style="font-size: 0.85rem; color: #B91C1C; line-height: 1.5;">Event ini memberikan nilai Tri Dharma Aktivitas Kemahasiswaan (TAK) yang dapat digunakan untuk memenuhi syarat kelulusan di Telkom University.</div>
                </div>
            </div>
            @endif

            <!-- Tentang Event -->
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 12px; color: #111827;">Tentang Event Ini</h3>
                <div style="color: #4B5563; line-height: 1.6; font-size: 0.9rem;">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>

            <!-- Penyelenggara -->
            <div style="background: #F9FAFB; border-radius: 8px; padding: 20px; margin-bottom: 32px;">
                <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 16px; color: #111827;">Informasi Penyelenggara</h3>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <div>
                            <div style="font-size: 0.75rem; color: #6B7280; margin-bottom: 2px;">Diselenggarakan oleh</div>
                            <div style="font-weight: 500; color: #111827; font-size: 0.9rem;">{{ $event->organizer_name }}</div>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <div>
                            <div style="font-size: 0.75rem; color: #6B7280; margin-bottom: 2px;">Kontak</div>
                            <div style="font-weight: 500; color: #111827; font-size: 0.9rem;">{{ $event->contact_person }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Button -->
            <div style="text-align: center;">
                <a href="{{ str_starts_with($event->registration_link, 'http') ? $event->registration_link : 'http://' . $event->registration_link }}" target="_blank" class="btn btn-primary" style="background: #DC2626; padding: 12px 24px; font-size: 1rem; font-weight: 600; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; width: auto; min-width: 200px; gap: 8px;">
                    Daftar Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                </a>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    @include('components.footer')

</body>
</html>
