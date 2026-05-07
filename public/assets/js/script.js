document.addEventListener('DOMContentLoaded', () => {
    // Basic navigation active state logic
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (currentPath === href || currentPath.endsWith(href)) {
            link.classList.add('active');
        }
    });

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

    // File Upload interactive logic (UI only)
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');

    if (uploadArea && fileInput) {
        uploadArea.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                const textNodes = uploadArea.querySelectorAll('p');
                if(textNodes.length > 0) {
                    textNodes[0].innerHTML = `Selected: <strong>${fileName}</strong>`;
                }
            }
        });

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--primary-red)';
            uploadArea.style.backgroundColor = '#FEF2F2';
        });

        uploadArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--border-color)';
            uploadArea.style.backgroundColor = '#F9FAFB';
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--border-color)';
            uploadArea.style.backgroundColor = '#F9FAFB';
            
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                const fileName = e.dataTransfer.files[0].name;
                const textNodes = uploadArea.querySelectorAll('p');
                if(textNodes.length > 0) {
                    textNodes[0].innerHTML = `Selected: <strong>${fileName}</strong>`;
                }
            }
        });
    }
});
