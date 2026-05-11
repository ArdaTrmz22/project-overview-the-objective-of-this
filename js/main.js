// Karanlık Mod (Dark Mode) İşlemleri
const darkModeToggle = document.getElementById('darkModeToggle');
const body = document.body;

// LocalStorage'dan tema tercihini kontrol et
if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
}

// Butona tıklandığında temayı değiştir
if (darkModeToggle) {
    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
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
