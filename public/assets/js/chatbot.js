document.addEventListener('DOMContentLoaded', () => {
    const chatbotFab = document.getElementById('chatbotFab');
    const chatbotWindow = document.getElementById('chatbotWindow');
    const chatbotCloseBtn = document.getElementById('chatbotCloseBtn');
    const chatbotInput = document.getElementById('chatbotInput');
    const chatbotSendBtn = document.getElementById('chatbotSendBtn');
    const chatbotMessages = document.getElementById('chatbotMessages');
    const chatbotSuggestions = document.getElementById('chatbotSuggestions');

    // Settings elements
    const chatbotSettingsBtn = document.getElementById('chatbotSettingsBtn');
    const chatbotSettingsPanel = document.getElementById('chatbotSettingsPanel');
    const customApiKeyInput = document.getElementById('customApiKeyInput');
    const toggleApiKeyVisibility = document.getElementById('toggleApiKeyVisibility');
    const saveSettingsBtn = document.getElementById('saveSettingsBtn');
    const clearSettingsBtn = document.getElementById('clearSettingsBtn');
    const settingsStatus = document.getElementById('settingsStatus');
    const chatbotStatusText = document.querySelector('.chatbot-status');

    let chatHistory = []; // format: { role: 'user' | 'model', text: '...' }
    let isSending = false;

    // Load custom API key status
    const updateStatusIndicator = () => {
        const hasCustomKey = localStorage.getItem('user_gemini_api_key');
        if (chatbotStatusText) {
            if (hasCustomKey) {
                chatbotStatusText.innerHTML = '<span class="status-dot custom-key"></span> Online - API Kustom';
            } else {
                chatbotStatusText.innerHTML = '<span class="status-dot"></span> Online - AI Assistant';
            }
        }
    };
    
    if (customApiKeyInput) {
        customApiKeyInput.value = localStorage.getItem('user_gemini_api_key') || '';
    }
    updateStatusIndicator();

    // Toggle Settings Panel
    if (chatbotSettingsBtn && chatbotSettingsPanel) {
        chatbotSettingsBtn.addEventListener('click', () => {
            chatbotSettingsPanel.classList.toggle('show');
            if (chatbotSettingsPanel.classList.contains('show') && customApiKeyInput) {
                customApiKeyInput.value = localStorage.getItem('user_gemini_api_key') || '';
                customApiKeyInput.focus();
            }
        });
    }

    // Toggle Password Visibility
    if (toggleApiKeyVisibility && customApiKeyInput) {
        toggleApiKeyVisibility.addEventListener('click', () => {
            const isPassword = customApiKeyInput.type === 'password';
            customApiKeyInput.type = isPassword ? 'text' : 'password';
            toggleApiKeyVisibility.textContent = isPassword ? '🔒' : '👁️';
        });
    }

    // Save Settings
    if (saveSettingsBtn && customApiKeyInput && settingsStatus) {
        saveSettingsBtn.addEventListener('click', () => {
            const key = customApiKeyInput.value.trim();
            if (!key) {
                settingsStatus.textContent = 'Harap masukkan API Key yang valid.';
                settingsStatus.className = 'settings-status error';
                return;
            }
            localStorage.setItem('user_gemini_api_key', key);
            settingsStatus.textContent = 'API Key berhasil disimpan!';
            settingsStatus.className = 'settings-status success';
            updateStatusIndicator();
            setTimeout(() => {
                chatbotSettingsPanel.classList.remove('show');
                settingsStatus.textContent = '';
            }, 1200);
        });
    }

    // Clear Settings
    if (clearSettingsBtn && customApiKeyInput && settingsStatus) {
        clearSettingsBtn.addEventListener('click', () => {
            localStorage.removeItem('user_gemini_api_key');
            customApiKeyInput.value = '';
            settingsStatus.textContent = 'API Key kustom dihapus.';
            settingsStatus.className = 'settings-status info';
            updateStatusIndicator();
            setTimeout(() => {
                chatbotSettingsPanel.classList.remove('show');
                settingsStatus.textContent = '';
            }, 1200);
        });
    }

    // Toggle Chat Window
    if (chatbotFab && chatbotWindow) {
        chatbotFab.addEventListener('click', () => {
            chatbotWindow.classList.toggle('show');
            if (chatbotWindow.classList.contains('show')) {
                chatbotInput.focus();
                // Remove pulse ring once clicked
                const pulse = chatbotFab.querySelector('.chatbot-pulse-ring');
                if (pulse) pulse.style.display = 'none';
            }
        });
    }

    if (chatbotCloseBtn && chatbotWindow) {
        chatbotCloseBtn.addEventListener('click', () => {
            chatbotWindow.classList.remove('show');
            if (chatbotSettingsPanel) {
                chatbotSettingsPanel.classList.remove('show');
            }
        });
    }

    // Scroll to bottom
    const scrollToBottom = () => {
        if (chatbotMessages) {
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }
    };

    // Render Message HTML
    const appendMessage = (text, sender) => {
        if (!chatbotMessages) return;

        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}-message`;
        
        // Simple Markdown-like renderer (Bold and Tautan)
        let formattedText = text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" class="chat-link">$1 <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.65rem;"></i></a>')
            .replace(/\n/g, '<br>');

        messageDiv.innerHTML = formattedText;
        chatbotMessages.appendChild(messageDiv);
        scrollToBottom();
    };

    // Typing Indicator
    const showTypingIndicator = () => {
        if (!chatbotMessages) return;

        const indicatorDiv = document.createElement('div');
        indicatorDiv.className = 'chat-message ai-message typing-indicator';
        indicatorDiv.id = 'typingIndicator';
        indicatorDiv.innerHTML = `
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        `;
        chatbotMessages.appendChild(indicatorDiv);
        scrollToBottom();
    };

    const removeTypingIndicator = () => {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) {
            indicator.remove();
        }
    };

    // Send Message Logic
    const handleSend = async () => {
        if (isSending) return;
        const text = chatbotInput.value.trim();
        if (!text) return;

        isSending = true;
        chatbotInput.disabled = true;
        if (chatbotSendBtn) chatbotSendBtn.disabled = true;

        appendMessage(text, 'user');
        chatbotInput.value = '';

        // Hide suggestions once user interacts
        if (chatbotSuggestions) {
            chatbotSuggestions.style.display = 'none';
        }

        showTypingIndicator();

        const csrfToken = chatbotWindow.getAttribute('data-csrf');
        const userApiKey = localStorage.getItem('user_gemini_api_key') || '';

        try {
            const headers = {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            };
            if (userApiKey) {
                headers['X-Gemini-Key'] = userApiKey;
            }

            const response = await fetch('/api/chat', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    message: text,
                    history: chatHistory
                })
            });

            const result = await response.json();
            removeTypingIndicator();

            if (response.ok && result.success) {
                appendMessage(result.reply, 'ai');
                
                // Add to history
                chatHistory.push({ role: 'user', text: text });
                chatHistory.push({ role: 'model', text: result.reply });
                
                // Keep history length optimized to prevent high token count
                if (chatHistory.length > 6) {
                    chatHistory = chatHistory.slice(-6);
                }
            } else {
                appendMessage(result.error || 'Maaf kawan, AI sedang sibuk. Silakan coba lagi sebentar lagi.', 'ai-error');
            }
        } catch (error) {
            removeTypingIndicator();
            console.error(error);
            appendMessage('Gagal menghubungi server. Pastikan koneksi internet kawan aktif.', 'ai-error');
        } finally {
            // Cooldown to prevent spam clicking
            setTimeout(() => {
                isSending = false;
                chatbotInput.disabled = false;
                if (chatbotSendBtn) chatbotSendBtn.disabled = false;
                chatbotInput.focus();
            }, 2500);
        }
    };

    // Event Listeners for Input
    if (chatbotInput) {
        chatbotInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                handleSend();
            }
        });
    }

    if (chatbotSendBtn) {
        chatbotSendBtn.addEventListener('click', handleSend);
    }

    // Suggestion Chips Clicks
    const chips = document.querySelectorAll('.suggestion-chip');
    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            const question = chip.getAttribute('data-question');
            if (question) {
                chatbotInput.value = question;
                handleSend();
            }
        });
    });
});
