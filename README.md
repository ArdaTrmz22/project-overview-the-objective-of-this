# Premium Full-Stack Web Portfolio

Bu proje, modern web standartlarına uygun olarak geliştirilmiş, dinamik bir kişisel portföy ve içerik yönetim sistemi (CMS) uygulamasıdır. Hem ziyaretçiler için şık ve etkileşimli bir ön yüz (frontend) sunar, hem de site sahibinin projelerini ve gelen mesajlarını yönetebileceği güvenli bir yönetici paneline (backend) sahiptir.

## 🚀 Öne Çıkan Özellikler

* **Modern ve Çarpıcı Tasarım:** Glassmorphism (cam efekti) konsepti, yumuşak geçişler ve modern tipografi (Outfit & Plus Jakarta Sans).
* **Karanlık / Aydınlık Mod (Dark/Light Mode):** Kullanıcı tercihini `localStorage` üzerinde saklayan ve anında tepki veren tema desteği.
* **Tamamen Asenkron (AJAX) Admin Paneli:** Proje ekleme, silme, düzenleme ve mesajları okuma/silme işlemleri sayfa **yenilenmeden (F5 olmadan)** Fetch API ile gerçekleştirilir.
* **Otomatik Mesaj Yenileme (Polling):** Ziyaretçilerin gönderdiği iletişim mesajları, admin panelinde her 5 saniyede bir arka planda kontrol edilerek ekrana anında (canlı olarak) düşer.
* **Güvenli Arka Plan (Backend):** 
    * Tüm veritabanı işlemleri **PDO** ve **Prepared Statements** ile yapılarak SQL Injection saldırılarına karşı korunmuştur.
    * Şifreler veritabanında `password_hash()` fonksiyonu ile kriptolanarak (Bcrypt) saklanır.
* **Responsive (Mobil Uyumlu) Tasarım:** Telefon, tablet ve masaüstü cihazlarda kusursuz görünüm.

## 🛠️ Kullanılan Teknolojiler

* **Frontend:** HTML5, CSS3 (Vanilla), JavaScript (ES6+, Fetch API)
* **Backend:** PHP 8.x
* **Veritabanı:** MySQL (MariaDB)
* **İkonlar ve Fontlar:** FontAwesome 6, Google Fonts

## 📂 Kurulum Adımları

Projeyi kendi bilgisayarınızda (localhost) veya bir hosting sunucusunda çalıştırmak için aşağıdaki adımları izleyin:

1. **Gereksinimler:** Bilgisayarınızda XAMPP, MAMP veya WAMP gibi bir yerel sunucu yazılımının yüklü olduğundan emin olun.
2. **Dosyaları Taşıma:** Proje klasörünü XAMPP için `htdocs` klasörünün içine kopyalayın.
3. **Veritabanını İçe Aktarma:**
    * `localhost/phpmyadmin` adresine gidin.
    * `portfolio_db` adında yeni bir veritabanı oluşturun (Karşılaştırma (Collation) olarak `utf8mb4_unicode_ci` seçmeniz tavsiye edilir).
    * Proje ana dizinindeki `database.sql` dosyasını bu veritabanının içine **İçe Aktar (Import)** yapın.
4. **Veritabanı Bağlantı Ayarları:** Eğer veritabanı adınız, kullanıcı adınız veya şifreniz farklıysa, `includes/db.php` dosyasını açıp gerekli ayarları güncelleyin.
5. **Projeyi Çalıştırma:** Tarayıcınızdan `http://localhost/proje-klasorunuz` adresine giderek siteyi görüntüleyebilirsiniz.

## 🔐 Yönetici (Admin) Paneli Bilgileri

Yönetici paneline erişmek için sitenizin sonuna `/admin` ekleyin (Örn: `http://localhost/proje-klasorunuz/admin`).

* **Varsayılan Kullanıcı Adı:** `admin`
* **Varsayılan Şifre:** `admin123`

*(Güvenliğiniz için projeyi canlı sunucuya taşıdığınızda bu şifreyi değiştirmeniz tavsiye edilir.)*

## 📁 Proje Dizin Yapısı

```text
├── admin/               # Yönetici paneli dosyaları (Giriş, Dashboard, Projeler, Mesajlar)
├── api/                 # Frontend ve Backend haberleşmesini sağlayan JSON API uç noktaları
├── css/                 # Sitil dosyaları (style.css)
├── includes/            # Ortak kullanılan dosyalar (Veritabanı bağlantısı db.php)
├── js/                  # JavaScript dosyaları (Karanlık mod, form validasyonu, AJAX)
├── uploads/             # Projelere yüklenen görsellerin saklandığı klasör
├── database.sql         # Veritabanı tabloları ve örnek veriler
├── index.html           # Ziyaretçilerin gördüğü ana sayfa
└── README.md            # Proje bilgilendirme dosyası
```

---
*Bu proje, modern web geliştirme süreçlerini ve full-stack yetenekleri sergilemek amacıyla akademik standartlara uygun olarak geliştirilmiştir.*
