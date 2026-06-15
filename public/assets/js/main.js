document.addEventListener('DOMContentLoaded', () => {
    // Basic navigation active state logic
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        try {
            const linkPath = new URL(link.href).pathname;
            const normalizedLinkPath = linkPath.replace(/\/$/, "");
            const normalizedCurrentPath = currentPath.replace(/\/$/, "");
            
            if (normalizedCurrentPath === normalizedLinkPath) {
                link.classList.add('active');
            }
        } catch (e) {
            const href = link.getAttribute('href');
            if (currentPath === href || currentPath.endsWith(href)) {
                link.classList.add('active');
            }
        }
    });

    // Active Filter select styles logic
    const filterSelects = document.querySelectorAll('.filter-select');
    const updateSelectStyles = (select) => {
        if (select.value !== "") {
            select.classList.add('filter-active');
        } else {
            select.classList.remove('filter-active');
        }
    };
    
    filterSelects.forEach(select => {
        // Run once on load
        updateSelectStyles(select);
        
        // Listen for change
        select.addEventListener('change', () => {
            updateSelectStyles(select);
        });
    });

    // Mobile Navbar Hamburger Menu
    const menuToggle = document.getElementById('menuToggle');
    const navLinksContainer = document.querySelector('.nav-links');
    if (menuToggle && navLinksContainer) {
        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            navLinksContainer.classList.toggle('active');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !navLinksContainer.contains(e.target)) {
                menuToggle.classList.remove('active');
                navLinksContainer.classList.remove('active');
            }
        });
    }

    // TAK Toggle Switch logic
    const takToggle = document.getElementById('takToggle');
    if (takToggle) {
        takToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            const input = document.getElementById('includeTak');
            if(input) {
                input.checked = this.classList.contains('active');
            }
        });
    }

    // File Upload interactive logic for drag and drop (Generic for all upload areas)
    const updateUploadUI = (inputElement, fileName) => {
        const uploadArea = inputElement.closest('.upload-area');
        if (uploadArea) {
            const textNodes = uploadArea.querySelectorAll('p');
            if (textNodes.length > 0) {
                textNodes[0].innerHTML = `Selected: <strong>${fileName}</strong>`;
            }
        }
    };

    const uploadAreas = document.querySelectorAll('.upload-area');
    uploadAreas.forEach(area => {
        const inputId = area.getAttribute('data-input-id');
        if (!inputId) return;
        
        const input = document.getElementById(inputId);
        if (!input) return;
        
        area.addEventListener('click', () => {
            input.click();
        });
        
        input.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                updateUploadUI(input, fileName);
            }
        });
        
        area.addEventListener('dragover', (e) => {
            e.preventDefault();
            area.style.borderColor = 'var(--primary-red)';
            area.style.backgroundColor = '#FEF2F2';
        });
        
        area.addEventListener('dragleave', (e) => {
            e.preventDefault();
            area.style.borderColor = 'var(--border-color)';
            area.style.backgroundColor = '#F9FAFB';
        });
        
        area.addEventListener('drop', (e) => {
            e.preventDefault();
            area.style.borderColor = 'var(--border-color)';
            area.style.backgroundColor = '#F9FAFB';
            
            if (e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                const fileName = e.dataTransfer.files[0].name;
                updateUploadUI(input, fileName);
                
                // Trigger change event so sync handles it
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        });
    });

    // Toast Notification helper
    const showToast = (message, isError = false) => {
        const existingToast = document.querySelector('.toast-notification');
        if (existingToast) {
            existingToast.remove();
        }

        const toast = document.createElement('div');
        toast.className = `toast-notification${isError ? ' toast-error' : ''}`;
        
        const icon = document.createElement('div');
        icon.className = 'toast-icon';
        icon.innerHTML = isError ? '✕' : '✨';
        
        const text = document.createElement('span');
        text.textContent = message;
        
        toast.appendChild(icon);
        toast.appendChild(text);
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 400);
        }, 4000);
    };

    // Category dynamic fields toggle logic (OPREC vs General Event)
    const categorySelect = document.querySelector('[name="category"]');
    const oprecFieldsContainer = document.getElementById('oprecFieldsContainer');
    const generalDescriptionGroup = document.getElementById('generalDescriptionGroup');

    const toggleCategoryFields = () => {
        const priceInput = document.querySelector('[name="price"]');
        if (categorySelect && categorySelect.value === 'kepanitiaan') {
            if (oprecFieldsContainer) oprecFieldsContainer.style.display = 'block';
            if (generalDescriptionGroup) generalDescriptionGroup.style.display = 'none';
            if (priceInput) {
                priceInput.value = 'GRATIS';
                priceInput.readOnly = true;
                priceInput.style.backgroundColor = '#F3F4F6';
                priceInput.style.color = '#6B7280';
            }
        } else {
            if (oprecFieldsContainer) oprecFieldsContainer.style.display = 'none';
            if (generalDescriptionGroup) generalDescriptionGroup.style.display = 'block';
            if (priceInput && priceInput.readOnly) {
                priceInput.value = '';
                priceInput.readOnly = false;
                priceInput.style.backgroundColor = '';
                priceInput.style.color = '';
            }
        }
    };

    if (categorySelect) {
        categorySelect.addEventListener('change', toggleCategoryFields);
        toggleCategoryFields();
    }

    // AI Scan Poster Logic
    const btnScanPoster = document.getElementById('btnScanPoster');
    const posterInput = document.getElementById('poster');
    const posterUploadArea = document.getElementById('posterUploadArea');

    if (posterInput && btnScanPoster) {
        posterInput.addEventListener('change', () => {
            if (posterInput.files && posterInput.files.length > 0) {
                btnScanPoster.style.display = 'flex';
            } else {
                btnScanPoster.style.display = 'none';
            }
        });
    }

    if (btnScanPoster && posterInput) {
        btnScanPoster.addEventListener('click', async () => {
            if (!posterInput.files || posterInput.files.length === 0) {
                showToast('Silakan pilih poster terlebih dahulu.', true);
                return;
            }

            const file = posterInput.files[0];
            
            // Client-side validations
            if (file.size > 5 * 1024 * 1024) { // 5MB limit
                showToast('Ukuran poster maksimal adalah 5MB.', true);
                return;
            }
            
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                showToast('Format file harus berupa PNG, JPG, atau JPEG.', true);
                return;
            }

            const formData = new FormData();
            formData.append('poster', file);

            const tokenInput = document.querySelector('input[name="_token"]');
            const token = tokenInput ? tokenInput.value : '';

            // Show scanning animation
            if (posterUploadArea) {
                posterUploadArea.classList.add('scanning');
            }
            btnScanPoster.disabled = true;
            const originalBtnText = btnScanPoster.innerHTML;
            btnScanPoster.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation: spin 1s linear infinite;">
                    <line x1="12" y1="2" x2="12" y2="6"></line>
                    <line x1="12" y1="18" x2="12" y2="22"></line>
                    <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                    <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                    <line x1="2" y1="12" x2="6" y2="12"></line>
                    <line x1="18" y1="12" x2="22" y2="12"></line>
                    <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                    <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                </svg>
                <span>Memindai poster dengan AI...</span>
            `;

            try {
                const userApiKey = localStorage.getItem('user_gemini_api_key') || '';
                const headers = {
                    'X-CSRF-TOKEN': token
                };
                if (userApiKey) {
                    headers['X-Gemini-Key'] = userApiKey;
                }

                const response = await fetch('/api/extract-poster', {
                    method: 'POST',
                    headers: headers,
                    body: formData
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.error || 'Gagal memindai poster.');
                }

                const data = result.data;

                // 1. Set category first to update fields toggle state
                if (categorySelect && data.category !== undefined) {
                    categorySelect.value = data.category;
                    updateSelectStyles(categorySelect);
                    toggleCategoryFields();
                }

                // 2. Populate regular fields
                const fields = [
                    'title', 'description', 'event_type', 'prodi',
                    'event_date', 'location', 'price', 'target_participants',
                    'registration_link', 'organizer_name', 'contact_person'
                ];

                fields.forEach(fieldName => {
                    const input = document.querySelector(`[name="${fieldName}"]`);
                    if (input && data[fieldName] !== undefined) {
                        input.value = data[fieldName];
                        
                        // Apply glow animation
                        input.classList.remove('autofill-glow');
                        void input.offsetWidth; // Trigger reflow to restart animation
                        input.classList.add('autofill-glow');
                        
                        // If it's a select element, update style
                        if (input.classList.contains('filter-select') || input.tagName === 'SELECT') {
                            updateSelectStyles(input);
                        }
                    }
                });

                // 3. Populate OPREC fields if category is Kepanitiaan
                if (data.category === 'kepanitiaan') {
                    const oprecFields = {
                        'oprec_divisions': '#oprecDivisions',
                        'oprec_requirements': '#oprecRequirements',
                        'oprec_timeline': '#oprecTimeline'
                    };

                    Object.entries(oprecFields).forEach(([key, selector]) => {
                        const input = document.querySelector(selector);
                        if (input && data[key] !== undefined) {
                            input.value = data[key];
                            
                            // Apply glow animation
                            input.classList.remove('autofill-glow');
                            void input.offsetWidth;
                            input.classList.add('autofill-glow');
                        }
                    });
                }

                // Handle TAK Toggle
                const includeTakCheckbox = document.getElementById('includeTak');
                const takToggle = document.getElementById('takToggle');
                if (includeTakCheckbox && takToggle && data.is_tak !== undefined) {
                    includeTakCheckbox.checked = data.is_tak;
                    if (data.is_tak) {
                        takToggle.classList.add('active');
                    } else {
                        takToggle.classList.remove('active');
                    }
                }

                showToast('✨ Berhasil memindai poster! Formulir telah diisi otomatis secara pintar.');

                // Smooth scroll to the first filled input (Judul Event)
                const firstInput = document.querySelector('[name="title"]');
                if (firstInput) {
                    setTimeout(() => {
                        firstInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 400); // Small delay to let user see scan end
                }

            } catch (error) {
                console.error(error);
                showToast('Gagal memindai poster: ' + error.message, true);
            } finally {
                if (posterUploadArea) {
                    posterUploadArea.classList.remove('scanning');
                }
                btnScanPoster.disabled = false;
                btnScanPoster.innerHTML = originalBtnText;
            }
        });
    }

    // OPREC Form Compile before Submission
    const form = document.getElementById('submitEventForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            const descTextarea = document.getElementById('description');
            
            if (categorySelect && categorySelect.value === 'kepanitiaan') {
                const divisions = document.getElementById('oprecDivisions').value.trim();
                const requirements = document.getElementById('oprecRequirements').value.trim();
                const timeline = document.getElementById('oprecTimeline').value.trim();

                let compiled = "";
                if (divisions) {
                    compiled += `### Divisi yang Dibuka:\n${divisions}\n\n`;
                }
                if (requirements) {
                    compiled += `### Kualifikasi & Persyaratan:\n${requirements}\n\n`;
                }
                if (timeline) {
                    compiled += `### Timeline Seleksi:\n${timeline}\n\n`;
                }

                const oprecDesc = compiled.trim();
                if (!oprecDesc) {
                    e.preventDefault();
                    showToast('Harap isi detail rekrutmen kepanitiaan terlebih dahulu.', true);
                    return;
                }
                if (descTextarea) {
                    descTextarea.value = oprecDesc;
                }
            } else {
                // General event, description is required
                if (descTextarea && !descTextarea.value.trim()) {
                    e.preventDefault();
                    showToast('Deskripsi event tidak boleh kosong.', true);
                    return;
                }
            }

            // Validation passed! Disable button with slight delay to prevent double clicks
            const btnSubmitEvent = document.getElementById('btnSubmitEvent');
            if (btnSubmitEvent) {
                setTimeout(() => {
                    btnSubmitEvent.disabled = true;
                }, 0);
                
                btnSubmitEvent.innerHTML = `
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="animation: spin 1s linear infinite;">
                        <line x1="12" y1="2" x2="12" y2="6"></line>
                        <line x1="12" y1="18" x2="12" y2="22"></line>
                        <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                        <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                        <line x1="2" y1="12" x2="6" y2="12"></line>
                        <line x1="18" y1="12" x2="22" y2="12"></line>
                        <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                        <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                    </svg>
                    <span>Mengirim pengajuan event...</span>
                `;
            }
        });
    }
});

