CREATE DATABASE IF NOT EXISTS portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE portfolio_db;

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  date_sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin_users (username, password_hash)
VALUES ('admin', '123456'); 