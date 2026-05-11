-- Veritabanı oluşturma
CREATE DATABASE IF NOT EXISTS `portfolio_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `portfolio_db`;

-- `users` tablosu (Admin girişi için)
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Varsayılan Admin Kullanıcısı (Kullanıcı adı: admin, Şifre: admin123)
-- Not: Şifre PHP'nin password_hash() fonksiyonu ile üretilmiştir.
INSERT INTO `users` (`username`, `password_hash`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- `projects` tablosu (Portföy projeleri için)
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `demo_link` varchar(255) DEFAULT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Örnek proje verisi
INSERT INTO `projects` (`title`, `description`, `image_url`, `demo_link`, `github_link`) VALUES
('E-Ticaret Sitesi', 'Modern ve duyarlı tasarıma sahip, sepet sistemli e-ticaret demosu.', 'images/project1.jpg', '#', '#'),
('Görev Yönetim Uygulaması', 'Kullanıcıların günlük görevlerini takip edebileceği interaktif to-do uygulaması.', 'images/project2.jpg', '#', '#');

-- `messages` tablosu (İletişim formundan gelen mesajlar için)
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
