<?php include 'includes/header.php'; ?>

<section id="home" class="hero">
    <div class="hero-content">
        <h1>Merhaba, Ben <span class="highlight">Bir Geliştiriciyim</span></h1>
        <p>Modern, duyarlı ve dinamik web uygulamaları inşa ediyorum.</p>
        <a href="#portfolio" class="btn btn-primary">Projelerime Göz At</a>
    </div>
</section>

<section id="about" class="about">
    <div class="section-title">
        <h2>Hakkımda</h2>
        <div class="underline"></div>
    </div>
    <div class="about-content">
        <div class="about-text">
            <p>Web teknolojileri tutkunu bir full-stack geliştiriciyim. Öğrenmeye ve modern teknolojileri kullanmaya her zaman açığım.</p>
        </div>
        <div class="skills-table">
            <h3>Yeteneklerim</h3>
            <table>
                <thead>
                    <tr><th>Teknoloji</th><th>Seviye</th></tr>
                </thead>
                <tbody>
                    <tr><td>HTML5 / CSS3</td><td>İleri</td></tr>
                    <tr><td>JavaScript (DOM/AJAX)</td><td>Orta-İleri</td></tr>
                    <tr><td>PHP & MySQL</td><td>Orta</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section id="portfolio" class="portfolio">
    <div class="section-title">
        <h2>Projelerim</h2>
        <div class="underline"></div>
    </div>
    <div class="project-grid" id="project-list">
        <p>Projeler veritabanından yükleniyor...</p>
    </div>
</section>

<section id="contact" class="contact">
    <div class="section-title">
        <h2>İletişim</h2>
        <div class="underline"></div>
    </div>
    <div class="contact-container">
        <form id="contact-form" action="#" method="POST">
            <div class="form-group">
                <label for="name">Adınız Soyadınız</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-posta Adresiniz</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Mesajınız</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gönder</button>
            <div id="form-feedback" class="feedback-msg"></div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
