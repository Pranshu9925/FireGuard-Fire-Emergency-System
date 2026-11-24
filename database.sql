CREATE DATABASE IF NOT EXISTS fire_emergency_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fire_emergency_system;
CREATE TABLE IF NOT EXISTS users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 phone VARCHAR(25) NOT NULL,
 password_hash VARCHAR(255) NOT NULL,
 role ENUM('user','admin') NOT NULL DEFAULT 'user',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS reports (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id INT UNSIGNED NOT NULL,
 location VARCHAR(255) NOT NULL,
 area VARCHAR(150) NULL,
 fire_type ENUM('Electrical','Kitchen','Building','Vehicle','Forest / Outdoor','Other') NOT NULL,
 severity ENUM('Low','Medium','High','Critical') NOT NULL,
 description TEXT NOT NULL,
 status ENUM('submitted','under_review','assigned','in_progress','resolved') NOT NULL DEFAULT 'submitted',
 admin_note TEXT NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_reports_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
 INDEX idx_reports_status (status), INDEX idx_reports_user (user_id)
) ENGINE=InnoDB;
