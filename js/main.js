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

// Form Validasyonu (Gönderilmeden Önce İstemci Tarafı Kontrolü)
const contactForm = document.getElementById('contact-form');
const formFeedback = document.getElementById('form-feedback');

if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();
        
        // Basit boşluk kontrolü
        if (!name || !email || !message) {
            e.preventDefault(); // Formun gönderilmesini engelle
            formFeedback.textContent = 'Lütfen tüm alanları doldurun.';
            formFeedback.style.color = 'red';
            return;
        }

        // Basit E-posta format kontrolü
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            formFeedback.textContent = 'Lütfen geçerli bir e-posta adresi girin.';
            formFeedback.style.color = 'red';
            return;
        }

        // Eğer hata yoksa (Burada PHP'ye post edilecek, şimdilik AJAX kısmı eklenene kadar submit olmasına izin veriyoruz)
        formFeedback.textContent = 'Form doğrulaması başarılı, gönderiliyor...';
        formFeedback.style.color = 'green';
    });
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
