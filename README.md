# ☕ Cafe Payroll Management System 

A web-based Payroll Management System built with Laravel 12 and MySQL that automates employee payroll computation, attendance tracking, deductions, and report generation for café businesses.

---

## 📌 Project Overview

The Cafe Payroll Management System is designed to streamline payroll operations by automating employee management, attendance monitoring, deduction calculations, payroll processing, and report generation. The system minimizes manual computation errors and improves overall efficiency in payroll administration.

---

## 👨‍💻 Developers

* Agaton, Jhon Kurt V.
* Esguerra, Diana
* Cordero, Kerby

🎓 Course and Section

Bachelor of Science in Information Technology
Section: III-BSIT-B

---

## ✨ Features

### Employee Module

* View employee profile
* View attendance records
* View payroll information and payslips

### Administrator Module

* Manage employee records
* Manage attendance records
* Manage deductions
* Generate payroll
* View system reports
* Export payroll reports

---

## 💰 Payroll Computation

### Gross Pay

```text
Gross Pay = Daily Rate × Present Days
```

### Late Deduction

```text
Late Deduction = Late Days × (Daily Rate × 20%)
```

### Net Pay

```text
Net Pay = Gross Pay − Total Deductions
```

---

## 🗄 Database Structure

The system uses the following database tables:

* users
* employees
* attendance
* deductions
* payroll

---

## 🔗 API Documentation

### Authentication

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| POST   | /login   | User Login  |
| GET    | /logout  | User Logout |

### Employee API

| Method | Endpoint            | Description                 |
| ------ | ------------------- | --------------------------- |
| GET    | /api/employees      | Retrieve all employees      |
| POST   | /api/employees      | Create a new employee       |
| GET    | /api/employees/{id} | Retrieve employee details   |
| PUT    | /api/employees/{id} | Update employee information |
| DELETE | /api/employees/{id} | Delete an employee          |


## 🎥 API Demonstration

Screen recording of API requests and responses:

https://drive.google.com/file/d/16cFji9l0XoP_iyzv7hfkwhXyLpqdFLcb/view

---

## 🛠 Technology Stack

* Laravel 12
* PHP 8+
* MySQL
* Blade Templates
* Bootstrap 5
* RESTful API

---

## 🚀 Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/jhxnkxrttt/payrollmain.git
cd payrollmain
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Update the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_payroll
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Database Migration and Seeder

```bash
php artisan migrate:fresh --seed
```

### 6. Start the Development Server

```bash
php artisan serve
```

Application URL:

```text
http://127.0.0.1:8000
```

---

## 📊 Reports and Export Features

* Payroll Reports
* Employee Reports
* PDF Export
* Attendance Reports

---

## 🌐 Deployment

### Live Demo

https://payrollmain-production.up.railway.app/

### Hosting Platform

* Railway

---

## 🔐 Default Administrator Account

```text
Email: admin@cafe.com
Password: admin123
```

---

## 📄 License

This project was developed for educational and academic purposes only.
