-- School Management System Database Schema
-- Run this file in phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS school_management;
USE school_management;

-- =============================================
-- Users Table (Authentication)
-- =============================================
CREATE TABLE IF NOT EXISTS users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','teacher','student') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- Classes Table
-- =============================================
CREATE TABLE IF NOT EXISTS classes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  class_name VARCHAR(50) NOT NULL,
  section VARCHAR(10) NOT NULL
);

-- =============================================
-- Students Table
-- =============================================
CREATE TABLE IF NOT EXISTS students (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  dob DATE NOT NULL,
  gender VARCHAR(10) NOT NULL,
  address TEXT,
  phone VARCHAR(15),
  class_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
);

-- =============================================
-- Teachers Table
-- =============================================
CREATE TABLE IF NOT EXISTS teachers (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  subject VARCHAR(100) NOT NULL,
  phone VARCHAR(15),
  email VARCHAR(100) UNIQUE
);

-- =============================================
-- Subjects Table
-- =============================================
CREATE TABLE IF NOT EXISTS subjects (
  id INT PRIMARY KEY AUTO_INCREMENT,
  subject_name VARCHAR(100) NOT NULL,
  class_id INT,
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

-- =============================================
-- Attendance Table
-- =============================================
CREATE TABLE IF NOT EXISTS attendance (
  id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  date DATE NOT NULL,
  status ENUM('Present','Absent') NOT NULL,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- =============================================
-- Fees Table
-- =============================================
CREATE TABLE IF NOT EXISTS fees (
  id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  amount DECIMAL(10,2) NOT NULL,
  status ENUM('Paid','Unpaid') NOT NULL DEFAULT 'Unpaid',
  due_date DATE NOT NULL,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- =============================================
-- Exams Table
-- =============================================
CREATE TABLE IF NOT EXISTS exams (
  id INT PRIMARY KEY AUTO_INCREMENT,
  exam_name VARCHAR(100) NOT NULL,
  date DATE NOT NULL
);

-- =============================================
-- Results Table
-- =============================================
CREATE TABLE IF NOT EXISTS results (
  id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT,
  exam_id INT,
  subject_id INT,
  marks INT NOT NULL,
  grade VARCHAR(5),
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- =============================================
-- Seed Default Admin User
-- Password: admin123 (hashed with password_hash)
-- =============================================
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$koc6LAW/4wCTWUpozG4sre9T23So36Jg0eRl2hV7Nwb.tn9W0aCnm', 'admin');
