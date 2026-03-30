# 🏫 School Management System

A complete, secure, and responsive **School Management System** built with **PHP**, **MySQL**, and **Tailwind CSS** following a 3-Tier Architecture. It provides core administrative, academic, and financial modules for managing a school efficiently.

---

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Prerequisites](#-prerequisites)
- [Installation & Setup](#-installation--setup)
- [Database Setup](#-database-setup)
- [Running the Project](#-running-the-project)
- [Default Login Credentials](#-default-login-credentials)
- [Project Structure](#-project-structure)
- [Modules Overview](#-modules-overview)
- [Database Schema](#-database-schema)
- [Screenshots](#-screenshots)
- [License](#-license)

---

## ✨ Features

- 🔐 **Authentication** — Secure login/logout with role-based access control (Admin, Teacher, Student)
- 📊 **Dashboard** — Overview with live stats (students, teachers, classes, exams, unpaid fees)
- 👨‍🎓 **Student Management** — Add, edit, delete, and list students with class assignment
- 👩‍🏫 **Teacher Management** — Add, edit, delete, and list teachers
- 🏛️ **Class Management** — Create and manage classes with sections
- 📚 **Subject Management** — Add subjects and assign them to classes
- 📅 **Attendance Tracking** — Mark and view student attendance
- 💰 **Fee Management** — Record fees, track paid/unpaid status
- 📝 **Exam Management** — Create exams and enter student marks/grades
- 📈 **Reports** — Generate academic and financial reports
- 🌙 **Modern Dark UI** — Premium glassmorphic design with Inter font
- 📱 **Responsive** — Fully mobile-friendly with collapsible sidebar

---

## 🛠️ Tech Stack

| Layer        | Technology                              |
| ------------ | --------------------------------------- |
| **Frontend** | HTML, Tailwind CSS (CDN), JavaScript    |
| **Backend**  | PHP 7.4+ (PDO with Prepared Statements)|
| **Database** | MySQL 5.7+ / MariaDB 10.3+             |
| **Server**   | Apache (XAMPP)                          |
| **Font**     | Google Fonts — Inter                    |

---

## 📦 Prerequisites

Before you begin, make sure you have the following installed:

1. **[XAMPP](https://www.apachefriends.org/download.html)** (includes Apache, MySQL/MariaDB, and PHP)
   - PHP 7.4 or higher
   - MySQL 5.7+ or MariaDB 10.3+

> 💡 **Tip:** XAMPP is a one-click installer that bundles everything you need. Download it from [https://www.apachefriends.org](https://www.apachefriends.org).

---

## 🚀 Installation & Setup

### Step 1: Clone or Download the Project

```bash
# Clone via Git
git clone https://github.com/your-username/school-management-system.git

# Or download the ZIP and extract it
```

### Step 2: Move to XAMPP's htdocs Folder

Place the project folder inside your XAMPP `htdocs` directory:

```
C:\xampp\htdocs\school-management-system\
```

> On macOS/Linux: `/opt/lampp/htdocs/school-management-system/`

### Step 3: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**

Both services should show a green status indicator.

---

## 🗄️ Database Setup

You have **three options** to create the database:

### Option A: Using MySQL Command Line (Recommended)

Open a terminal/command prompt and run:

```bash
# Windows (XAMPP)
c:\xampp\mysql\bin\mysql.exe -u root < c:\xampp\htdocs\school-management-system\database\schema.sql
```

```bash
# macOS / Linux
/opt/lampp/bin/mysql -u root < /opt/lampp/htdocs/school-management-system/database/schema.sql
```

This single command will:
- ✅ Create the `school_management` database
- ✅ Create all 9 tables (users, classes, students, teachers, subjects, attendance, fees, exams, results)
- ✅ Set up all foreign key relationships
- ✅ Seed the default admin user

### Option B: Using XAMPP Shell

1. Open **XAMPP Control Panel**
2. Click the **Shell** button
3. Run:

```bash
mysql -u root < C:\xampp\htdocs\school-management-system\database\schema.sql
```

### Option C: Using phpMyAdmin (GUI)

1. Open your browser and go to: **http://localhost/phpmyadmin**
2. Click the **Import** tab at the top
3. Click **Choose File** and select: `C:\xampp\htdocs\school-management-system\database\schema.sql`
4. Click **Go** to execute

### Option D: Manual SQL Execution

1. Open **http://localhost/phpmyadmin**
2. Click the **SQL** tab
3. Copy and paste the following SQL and click **Go**:

```sql
-- =============================================
-- CREATE DATABASE
-- =============================================
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
```

### ✅ Verify Database Was Created

Run this command to confirm all tables are created:

```bash
c:\xampp\mysql\bin\mysql.exe -u root -e "USE school_management; SHOW TABLES;"
```

Expected output:

```
+-------------------------------+
| Tables_in_school_management   |
+-------------------------------+
| attendance                    |
| classes                       |
| exams                         |
| fees                          |
| results                       |
| students                      |
| subjects                      |
| teachers                      |
| users                         |
+-------------------------------+
```

---

## ▶️ Running the Project

1. Make sure **Apache** and **MySQL** are running in XAMPP Control Panel
2. Open your browser and navigate to:

```
http://localhost/school-management-system/
```

You will be redirected to the login page automatically.

---

## 🔑 Default Login Credentials

| Field      | Value      |
| ---------- | ---------- |
| **URL**    | `http://localhost/school-management-system/` |
| **Username** | `admin`  |
| **Password** | `admin123` |
| **Role**   | Admin      |

> ⚠️ **Security Warning:** Change the default admin password immediately after your first login. For production use, also update the database password in `config/db.php`.

---

## 📁 Project Structure

```
school-management-system/
│
├── 📄 index.php                    # Entry point — redirects to dashboard or login
├── 📄 README.md                    # This file
│
├── 📂 config/
│   └── db.php                      # Database connection (PDO)
│
├── 📂 database/
│   └── schema.sql                  # Full database schema + seed data
│
├── 📂 includes/
│   ├── auth.php                    # Auth middleware (requireLogin, requireRole)
│   ├── header.php                  # HTML head, navbar, and Tailwind CSS setup
│   ├── sidebar.php                 # Navigation sidebar with module links
│   └── footer.php                  # Closing tags and scripts
│
├── 📂 pages/
│   ├── login.php                   # Login page
│   ├── logout.php                  # Logout handler
│   └── dashboard.php               # Main dashboard with stats & recent data
│
├── 📂 actions/                     # Backend action handlers (form processing)
│   ├── auth_actions.php            # Login/register actions
│   ├── student_actions.php         # CRUD actions for students
│   ├── teacher_actions.php         # CRUD actions for teachers
│   ├── class_actions.php           # CRUD actions for classes
│   ├── subject_actions.php         # CRUD actions for subjects
│   ├── attendance_actions.php      # Attendance marking actions
│   ├── fee_actions.php             # Fee management actions
│   └── exam_actions.php            # Exam & results actions
│
├── 📂 modules/                     # Frontend module pages
│   ├── 📂 students/
│   │   ├── add.php                 # Add student form
│   │   ├── edit.php                # Edit student form
│   │   └── list.php                # List all students
│   │
│   ├── 📂 teachers/
│   │   ├── add.php                 # Add teacher form
│   │   ├── edit.php                # Edit teacher form
│   │   └── list.php                # List all teachers
│   │
│   ├── 📂 classes/
│   │   ├── add.php                 # Add class form
│   │   ├── edit.php                # Edit class form
│   │   └── list.php                # List all classes
│   │
│   ├── 📂 subjects/
│   │   ├── add.php                 # Add subject form
│   │   └── list.php                # List all subjects
│   │
│   ├── 📂 attendance/
│   │   └── list.php                # Attendance management
│   │
│   ├── 📂 fees/
│   │   ├── add.php                 # Add fee record
│   │   └── list.php                # List all fees
│   │
│   ├── 📂 exams/
│   │   ├── add.php                 # Add exam
│   │   ├── enter_marks.php         # Enter student marks
│   │   └── list.php                # List all exams
│   │
│   └── 📂 reports/
│       └── index.php               # Reports dashboard
│
└── 📂 assets/
    ├── 📂 css/                     # Custom stylesheets
    ├── 📂 js/                      # Custom JavaScript
    └── 📂 images/                  # Images and assets
```

---

## 📦 Modules Overview

### 🔐 Authentication
- Secure login with `password_hash()` and `password_verify()`
- Session-based authentication
- Role-based access control (Admin, Teacher, Student)
- Auth middleware for protected pages

### 📊 Dashboard
- Total students, teachers, classes, subjects, exams count
- Unpaid fees overview
- Recently enrolled students table
- Quick navigation to all modules

### 👨‍🎓 Student Management
- Add new students with name, DOB, gender, address, phone, and class
- Edit existing student records
- Delete students (with cascade to attendance, fees, results)
- View all students in a sortable list

### 👩‍🏫 Teacher Management
- Add teachers with name, subject, phone, and email
- Edit and delete teacher records
- View all teachers in a list

### 🏛️ Class Management
- Create classes with name and section (e.g., "Class 10 - A")
- Edit and delete classes
- Classes are linked to students and subjects

### 📚 Subject Management
- Add subjects and assign them to specific classes
- View all subjects with their associated classes

### 📅 Attendance
- Mark daily attendance for students (Present/Absent)
- View attendance records

### 💰 Fee Management
- Add fee records for individual students
- Track payment status (Paid/Unpaid)
- Set due dates for payments
- View all fee records with filter

### 📝 Exam & Results
- Create exams with name and date
- Enter marks for students per subject per exam
- Auto-assign grades based on marks

### 📈 Reports
- Generate consolidated reports
- Academic performance and financial summaries

---

## 🗃️ Database Schema

### Entity Relationship Diagram

```
┌──────────┐     ┌──────────┐     ┌──────────┐
│  users   │     │ classes  │     │ teachers │
├──────────┤     ├──────────┤     ├──────────┤
│ id (PK)  │     │ id (PK)  │     │ id (PK)  │
│ username │     │class_name│     │ name     │
│ password │     │ section  │     │ subject  │
│ role     │     └────┬─────┘     │ phone    │
│created_at│          │           │ email    │
└──────────┘          │           └──────────┘
                      │
          ┌───────────┼───────────┐
          │           │           │
    ┌─────▼────┐ ┌────▼─────┐    │
    │ students │ │ subjects │    │
    ├──────────┤ ├──────────┤    │
    │ id (PK)  │ │ id (PK)  │    │
    │ name     │ │subj_name │    │
    │ dob      │ │class_id  │────┘
    │ gender   │ │  (FK)    │
    │ address  │ └────┬─────┘
    │ phone    │      │
    │class_id  │      │
    │  (FK)    │      │
    │created_at│      │
    └──┬───┬───┘      │
       │   │          │
       │   │    ┌─────▼─────┐
       │   │    │  results  │
       │   │    ├───────────┤
       │   │    │ id (PK)   │
       │   ├───►│student_id │
       │   │    │ exam_id   │◄──┐
       │   │    │subject_id │   │
       │   │    │ marks     │   │
       │   │    │ grade     │   │
       │   │    └───────────┘   │
       │   │              ┌─────┴────┐
  ┌────▼───┴──┐           │  exams   │
  │attendance │           ├──────────┤
  ├───────────┤           │ id (PK)  │
  │ id (PK)   │           │exam_name │
  │student_id │           │ date     │
  │ date      │           └──────────┘
  │ status    │
  └───────────┘
  ┌───────────┐
  │   fees    │
  ├───────────┤
  │ id (PK)   │
  │student_id │◄── students.id
  │ amount    │
  │ status    │
  │ due_date  │
  └───────────┘
```

### Tables Summary

| Table        | Columns | Description                          |
| ------------ | ------- | ------------------------------------ |
| `users`      | 5       | Authentication & role management     |
| `classes`    | 3       | Class names with sections            |
| `students`   | 8       | Student profiles linked to classes   |
| `teachers`   | 5       | Teacher profiles                     |
| `subjects`   | 3       | Subjects linked to classes           |
| `attendance` | 4       | Daily attendance records             |
| `fees`       | 5       | Student fee records & payment status |
| `exams`      | 3       | Exam definitions                     |
| `results`    | 6       | Student marks & grades per exam      |

---

## 🔧 Configuration

### Database Configuration

Edit `config/db.php` to match your MySQL credentials:

```php
$host = 'localhost';
$dbname = 'school_management';
$username = 'root';
$password = ''; // Default XAMPP has no password
```

### Security Features

- **PDO Prepared Statements** — Prevents SQL injection
- **Password Hashing** — Uses `bcrypt` via `password_hash()`
- **Session Management** — Secure session-based authentication
- **XSS Prevention** — `htmlspecialchars()` on all output
- **CSRF Protection** — Form-based action handlers
- **Emulated Prepares Disabled** — Extra security layer

---

## 🧪 Troubleshooting

| Issue | Solution |
| ----- | -------- |
| **"Database connection failed"** | Make sure MySQL is running in XAMPP. Check credentials in `config/db.php`. |
| **Blank page / 500 error** | Check Apache error log at `C:\xampp\apache\logs\error.log` |
| **"Table doesn't exist"** | Run the database schema: `mysql -u root < database/schema.sql` |
| **Can't login** | Verify the `users` table has the admin seed: `SELECT * FROM users;` |
| **Port 80 in use** | Change Apache port in XAMPP or stop the conflicting service (Skype, IIS) |
| **Page not found (404)** | Ensure the project folder is named `school-management-system` inside `htdocs` |

---

## 📄 License

This project is open-source and available for educational purposes.

---

## 🙏 Acknowledgements

- [XAMPP](https://www.apachefriends.org/) — Local development server
- [Tailwind CSS](https://tailwindcss.com/) — Utility-first CSS framework
- [Google Fonts (Inter)](https://fonts.google.com/specimen/Inter) — Typography
- [Heroicons](https://heroicons.com/) — SVG icons

---

> **Built with ❤️ for educational institutions**
