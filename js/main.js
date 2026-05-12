// Karanlık Mod (Dark Mode) İşlemleri
const darkModeToggle = document.getElementById('darkModeToggle');
const body = document.body;

function updateThemeIcon() {
    if (!darkModeToggle) return;
    const icon = darkModeToggle.querySelector('i');
    if (body.classList.contains('dark-mode')) {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
    }
}

// LocalStorage'dan tema tercihini kontrol et
if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
}
updateThemeIcon(); // İlk yüklemede ikonu ayarla

// Butona tıklandığında temayı değiştir
if (darkModeToggle) {
    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        updateThemeIcon(); // İkonu güncelle
        
        // Tercihi kaydet
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
}

// Form Validasyonu ve AJAX Gönderimi
const contactForm = document.getElementById('contact-form');
const formFeedback = document.getElementById('form-feedback');

if (contactForm) {
    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault(); // Sayfanın yenilenmesini engelle (AJAX için zorunlu)

        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const messageInput = document.getElementById('message');
        const submitBtn = contactForm.querySelector('button[type="submit"]');

        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const message = messageInput.value.trim();
        
        // 1. İstemci Tarafı (Client-Side) Validasyon
        if (!name || !email || !message) {
            showFeedback('Lütfen tüm alanları doldurun.', 'error');
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showFeedback('Lütfen geçerli bir e-posta adresi girin.', 'error');
            return;
        }

        // 2. Sunucuya Gönderim (AJAX Fetch API)
        try {
            // Butonu gönderiliyor durumuna al
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Gönderiliyor...';
            submitBtn.disabled = true;

            const response = await fetch('process_contact.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, email, message })
            });

            const result = await response.json();

            if (result.status === 'success') {
                showFeedback(result.message, 'success');
                contactForm.reset(); // Formu temizle
            } else {
                showFeedback(result.message, 'error');
            }
        } catch (error) {
            showFeedback('Bağlantı hatası: Lütfen daha sonra tekrar deneyin.', 'error');
        } finally {
            // Butonu eski haline getir
            submitBtn.innerHTML = '<i class="fa-regular fa-paper-plane"></i> Mesajı Gönder';
            submitBtn.disabled = false;
        }
    });
}

function showFeedback(message, type) {
    formFeedback.textContent = message;
    formFeedback.style.color = type === 'error' ? '#f43f5e' : '#10b981'; // Kırmızı (Hata) veya Yeşil (Başarılı)
}

// =========================================
// Projeleri AJAX (Fetch API) ile Yükleme
// =========================================
document.addEventListener('DOMContentLoaded', () => {
    const projectList = document.getElementById('project-list');
    
    if (projectList) {
        fetchProjects();
    }

    async function fetchProjects() {
        try {
            const response = await fetch('get_projects.php');
            const result = await response.json();

            if (result.status === 'success') {
                const projects = result.data;
                
                if (projects.length === 0) {
                    projectList.innerHTML = '<p class="text-muted" style="text-align:center; grid-column: 1 / -1;">Henüz proje eklenmemiş.</p>';
                    return;
                }

                // Mevcut içeriği temizle
                projectList.innerHTML = '';

                // Projeleri döngü ile karta çevirip DOM'a ekle
                projects.forEach(project => {
                    const card = document.createElement('div');
                    card.className = 'glass-card project-card';
                    
                    const imgUrl = project.image_url ? project.image_url : 'https://via.placeholder.com/400x250?text=Proje+Gorseli';
                    
                    card.innerHTML = `
                        <div style="height: 200px; border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem;">
                            <img src="${imgUrl}" alt="${project.title}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h3 style="margin-bottom: 0.5rem;">${project.title}</h3>
                        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">${project.description}</p>
                    `;
                    projectList.appendChild(card);
                });
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            projectList.innerHTML = `<p style="color: red; text-align:center; grid-column: 1 / -1;">Projeler yüklenemedi: ${error.message}</p>`;
        }
    }
});
