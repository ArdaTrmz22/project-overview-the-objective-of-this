<?php include 'includes/header.php'; ?>

<!-- Arka Plan Dekoratif Şekilleri -->
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>
<div class="shape shape-3"></div>

<!-- Ana Ekran (Hero Section) -->
<section id="home" class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <h1>Hayal Edilenleri <br><span class="gradient-text">Koda Döküyorum.</span></h1>
            <p>Sadece çalışan değil, aynı zamanda harika görünen ve kullanıcıya mükemmel bir deneyim sunan modern web uygulamaları inşa ediyorum.</p>
            
            <div class="hero-buttons">
                <a href="#portfolio" class="btn btn-glow"><i class="fa-solid fa-rocket"></i> Projeleri Keşfet</a>
                <a href="#contact" class="btn btn-outline"><i class="fa-regular fa-paper-plane"></i> İletişime Geç</a>
            </div>
            
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" class="social-icon"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Hakkımda Kısmı -->
<section id="about" class="about">
    <div class="section-header">
        <h2 class="section-title">Hakkımda & <span class="gradient-text">Yeteneklerim</span></h2>
        <p class="section-subtitle">Hangi teknolojileri kullanarak değer üretiyorum?</p>
    </div>
    
    <div class="about-grid">
        <!-- Glassmorphism Card -->
        <div class="glass-card about-text-card">
            <div class="card-icon"><i class="fa-solid fa-user-astronaut"></i></div>
            <h3>Tutkulu Bir Geliştirici</h3>
            <p>Modern web teknolojilerine (HTML5, CSS3, JS, PHP, MySQL) hakim, yenilikçi arayüzler ve sağlam arka plan sistemleri tasarlayan bir geliştiriciyim. Öğrenmeye her zaman açığım ve her projeye maksimum özen gösteriyorum.</p>
        </div>

        <div class="glass-card skills-card">
            <h3>Teknoloji Yığını</h3>
            <div class="skills-table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Alan</th>
                            <th>Teknoloji / Seviye</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="skill-label"><i class="fa-brands fa-html5" style="color: #e34f26;"></i> Frontend</div></td>
                            <td>
                                <div class="progress-bar"><div class="progress" style="width: 95%;"></div></div>
                                <span class="skill-name">HTML5 / CSS3 / Grid / Flexbox</span>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="skill-label"><i class="fa-brands fa-js" style="color: #f7df1e;"></i> İstemci (Client)</div></td>
                            <td>
                                <div class="progress-bar"><div class="progress" style="width: 85%;"></div></div>
                                <span class="skill-name">JavaScript / DOM / Fetch API</span>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="skill-label"><i class="fa-brands fa-php" style="color: #777bb4;"></i> Backend</div></td>
                            <td>
                                <div class="progress-bar"><div class="progress" style="width: 80%;"></div></div>
                                <span class="skill-name">PHP / Session / OOP</span>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="skill-label"><i class="fa-solid fa-database" style="color: #336791;"></i> Veritabanı</div></td>
                            <td>
                                <div class="progress-bar"><div class="progress" style="width: 85%;"></div></div>
                                <span class="skill-name">MySQL / Relational Design</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Projeler (Portfolio) Kısmı -->
<section id="portfolio" class="portfolio">
    <div class="section-header">
        <h2 class="section-title">Seçkin <span class="gradient-text">Projelerim</span></h2>
        <p class="section-subtitle">Şimdiye kadar geliştirdiğim bazı modern uygulamalar.</p>
    </div>
    
    <div class="project-grid" id="project-list">
        <!-- JS ile doldurulacak, şimdilik geçici yükleme durumu -->
        <div class="glass-card loading-card">
            <i class="fa-solid fa-circle-notch fa-spin"></i>
            <p>Projeler veritabanından yükleniyor...</p>
        </div>
    </div>
</section>

<!-- İletişim Formu -->
<section id="contact" class="contact">
    <div class="section-header">
        <h2 class="section-title">Birlikte <span class="gradient-text">Çalışalım</span></h2>
        <p class="section-subtitle">Bir projeniz mi var? Hemen iletişime geçin.</p>
    </div>
    
    <div class="contact-wrapper">
        <div class="contact-info glass-card">
            <h3>İletişim Bilgileri</h3>
            <p>Bana aşağıdaki yollardan ulaşabilirsiniz:</p>
            <ul class="info-list">
                <li><i class="fa-solid fa-envelope"></i> hello@portfoyum.com</li>
                <li><i class="fa-solid fa-location-dot"></i> İstanbul, Türkiye</li>
            </ul>
        </div>
        
        <div class="contact-form-container glass-card">
            <form id="contact-form" action="#" method="POST">
                <div class="input-row">
                    <div class="form-group">
                        <label for="name">Adınız</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-user"></i>
                            <input type="text" id="name" name="name" placeholder="John Doe" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-posta</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="john@example.com" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Mesajınız</label>
                    <div class="input-wrapper textarea-wrapper">
                        <i class="fa-regular fa-comment-dots"></i>
                        <textarea id="message" name="message" rows="4" placeholder="Projenizden bahsedin..." required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-glow btn-full"><i class="fa-regular fa-paper-plane"></i> Mesajı Gönder</button>
                <div id="form-feedback" class="feedback-msg"></div>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
