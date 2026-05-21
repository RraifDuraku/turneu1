-- Create Database
CREATE DATABASE IF NOT EXISTS turneu_db;
USE turneu_db;

-- Users/Admins Table
CREATE TABLE IF NOT EXISTS users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  fullname VARCHAR(150),
  role ENUM('admin', 'editor') DEFAULT 'editor',
  status ENUM('active', 'inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Pages/Content Table
CREATE TABLE IF NOT EXISTS pages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  content LONGTEXT,
  description TEXT,
  featured_image VARCHAR(255),
  status ENUM('published', 'draft', 'archived') DEFAULT 'draft',
  seo_title VARCHAR(255),
  seo_description TEXT,
  seo_keywords VARCHAR(500),
  author_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Teams Table
CREATE TABLE IF NOT EXISTS teams (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  logo VARCHAR(255),
  coach_name VARCHAR(150),
  status ENUM('active', 'inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Players Table
CREATE TABLE IF NOT EXISTS players (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(150) NOT NULL,
  team_id INT NOT NULL,
  position VARCHAR(50),
  number INT,
  photo VARCHAR(255),
  bio TEXT,
  status ENUM('active', 'inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
);

-- Matches Table
CREATE TABLE IF NOT EXISTS matches (
  id INT PRIMARY KEY AUTO_INCREMENT,
  team1_id INT NOT NULL,
  team2_id INT NOT NULL,
  match_date DATETIME NOT NULL,
  location VARCHAR(255),
  team1_score INT,
  team2_score INT,
  status ENUM('scheduled', 'live', 'finished') DEFAULT 'scheduled',
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (team1_id) REFERENCES teams(id) ON DELETE CASCADE,
  FOREIGN KEY (team2_id) REFERENCES teams(id) ON DELETE CASCADE
);

-- News/Articles Table
CREATE TABLE IF NOT EXISTS news (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  content LONGTEXT NOT NULL,
  featured_image VARCHAR(255),
  category VARCHAR(100),
  author_id INT,
  status ENUM('published', 'draft') DEFAULT 'draft',
  views INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Settings Table
CREATE TABLE IF NOT EXISTS settings (
  id INT PRIMARY KEY AUTO_INCREMENT,
  setting_key VARCHAR(100) UNIQUE NOT NULL,
  setting_value LONGTEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin user (username: admin, password: admin123)
INSERT IGNORE INTO users (username, password, email, fullname, role, status) 
VALUES ('admin', '$2y$10$P0d0N2T0R5K0U2Q9Z7X5e.JvYWkF5LJ2Q8D2E1N3M0T8B4V0Y9W', 'admin@turneu.local', 'Administrator', 'admin', 'active');

-- Insert default settings
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
('site_title', 'KRUSHË E MADHE - Turneu i Dëshmorëve dhe Martirëve 2025'),
('site_description', 'Official website for the memorial tournament'),
('contact_email', 'info@turneu.local'),
('phone', '+355 69 xxx xxxx'),
('address', 'Your City, Country'),
('facebook', 'https://facebook.com'),
('instagram', 'https://instagram.com'),
('twitter', 'https://twitter.com');
