<!-- FOOTER -->
<footer class="footer">
    &copy; 2026 TelU Events — Telkom University Purwokerto
</footer>

<!-- AI CHATBOT WIDGET -->
<div class="chatbot-fab" id="chatbotFab" title="Tanya AI Assistant">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2v4"></path>
        <path d="M2 11h2"></path>
        <path d="M20 11h2"></path>
        <rect x="4" y="6" width="16" height="12" rx="2"></rect>
        <circle cx="9" cy="11" r="1"></circle>
        <circle cx="15" cy="11" r="1"></circle>
        <path d="M9 15h6"></path>
    </svg>
    <span class="chatbot-pulse-ring"></span>
</div>

<div class="chatbot-window" id="chatbotWindow" data-csrf="{{ csrf_token() }}">
    <!-- Header -->
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-avatar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                    <circle cx="12" cy="5" r="2"></circle>
                    <path d="M12 7v4"></path>
                    <line x1="8" y1="16" x2="8.01" y2="16"></line>
                    <line x1="16" y1="16" x2="16.01" y2="16"></line>
                </svg>
            </div>
            <div>
                <h4>TelU Event Companion</h4>
                <span class="chatbot-status"><span class="status-dot"></span> Online - AI Assistant</span>
            </div>
        </div>
        <div class="chatbot-header-actions">
            <button class="chatbot-settings-btn" id="chatbotSettingsBtn" title="Pengaturan API Key">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
            </button>
            <button class="chatbot-close-btn" id="chatbotCloseBtn" title="Tutup Chat">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Settings Panel -->
    <div class="chatbot-settings-panel" id="chatbotSettingsPanel">
        <h5>Pengaturan API Key</h5>
        <p>Masukkan API Key Gemini Anda sendiri jika kuota gratis bawaan limit. Disimpan lokal di browser.</p>
        <div class="settings-input-group">
            <input type="password" id="customApiKeyInput" placeholder="Masukkan API Key...">
            <button type="button" id="toggleApiKeyVisibility" title="Lihat/Sembunyikan">👁️</button>
        </div>
        <div class="settings-actions">
            <button type="button" id="saveSettingsBtn" class="btn-save">Simpan</button>
            <button type="button" id="clearSettingsBtn" class="btn-clear">Hapus</button>
        </div>
        <div id="settingsStatus" class="settings-status"></div>
    </div>
    
    <!-- Messages Container -->
    <div class="chatbot-messages" id="chatbotMessages">
        <div class="chat-message ai-message">
            Halo kawan! Saya Asisten AI TelU Events. Ada yang bisa saya bantu hari ini? Kamu bisa bertanya tentang event yang aktif, cara submit event, atau poin TAK.
        </div>
    </div>
    
    <!-- Suggestions Panel -->
    <div class="chatbot-suggestions" id="chatbotSuggestions">
        <button class="suggestion-chip" data-question="Ada event apa saja yang aktif?">📅 Ada event apa saja?</button>
        <button class="suggestion-chip" data-question="Cari event yang memberikan nilai TAK">⚡ Event dengan Nilai TAK</button>
        <button class="suggestion-chip" data-question="Bagaimana cara mengajukan event baru?">✍️ Cara submit event baru</button>
    </div>
    
    <!-- Input Field -->
    <div class="chatbot-input-area">
        <input type="text" id="chatbotInput" placeholder="Ketik pesan..." maxlength="250">
        <button id="chatbotSendBtn" title="Kirim"><i class="fa-solid fa-paper-plane"></i></button>
    </div>
</div>

<!-- Load Chatbot JS with Cache-Buster -->
<script src="{{ asset('assets/js/chatbot.js') }}?v={{ time() }}" defer></script>