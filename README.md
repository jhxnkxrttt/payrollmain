# ☕ Cafe Payroll Management System

A web-based Payroll Management System built with Laravel 12 and MySQL that automates employee payroll computation, attendance tracking, deductions, and reporting.

---

## 📌 Project Description

The Cafe Payroll Management System is designed to automate payroll processing for café businesses. It eliminates manual computation errors and improves efficiency in handling employee records, attendance, deductions, and payroll generation.

---

## 👨‍💻 Developers

* Agaton, Jhon Kurt V.
* Esguerra, Diana
* Cordero, Kerby

---

## ⚙️ System Features

### Employee Module

* View profile
* View attendance
* View payslip

### Admin Module

* Manage employees
* Manage attendance
* Manage deductions
* Generate payroll
* Export reports

---

## 💰 Payroll Computation

### Gross Pay

Gross Pay = Daily Rate × Present Days

### Late Deduction

Late Deduction = Late Days × (Daily Rate × 0.20)

### Net Pay

Net Pay = Gross Pay − Total Deductions

---

## 🗄 Database Tables

* users
* employees
* attendance
* deductions
* payroll

---

## 🔗 API Endpoints

### Authentication

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| POST   | /login   | User login  |
| GET    | /logout  | User logout |

### Employees

| Method | Endpoint               | Description            |
| ------ | ---------------------- | ---------------------- |
| GET    | /employees             | Get all employees      |
| GET    | /employees/create      | Employee creation form |
| POST   | /employees             | Store new employee     |
| GET    | /employees/{id}/edit   | Edit employee          |
| POST   | /employees/{id}/update | Update employee        |
| GET    | /employees/{id}/delete | Delete employee        |

### Attendance

| Method | Endpoint    | Description             |
| ------ | ----------- | ----------------------- |
| GET    | /attendance | View attendance records |
| POST   | /attendance | Store attendance record |

### Payroll

| Method | Endpoint            | Description          |
| ------ | ------------------- | -------------------- |
| GET    | /payroll            | View payroll records |
| POST   | /payroll/generate   | Generate payroll     |
| GET    | /payroll/export/pdf | Export payroll PDF   |

### API Routes

| Method | Endpoint       |
| ------ | -------------- |
| GET    | /api/employees |
| GET    | /api/payrolls  |
| POST   | /api/payrolls  |

---

## 🛠 Tech Stack

* Laravel 12
* PHP 8+
* MySQL
* Blade Templates
* Bootstrap 5

---

## 🚀 Installation

### Clone Project

```bash
git clone https://github.com/your-repo/cafe-payroll.git
cd cafe-payroll
```

### Install Dependencies

```bash
composer install
npm install
```

### Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### Setup Database

Update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_payroll
DB_USERNAME=root
DB_PASSWORD=
```

### Run Migration and Seeder

```bash
php artisan migrate:fresh --seed
```

### Run Development Server

```bash
php artisan serve
```

Application URL:

```text
http://127.0.0.1:8000
```

---

## 📤 Export Features

* PDF Export
* Payroll Reports
* Employee Reports

---

## 🌐 Deployment

### Live Demo

https://payrollmain-production.up.railway.app/

### Hosting Platform

* Railway

---

## 🔐 Default Login

### Admin Account

```text
Email: admin@cafe.com
Password: admin123
```

---

## 📌 License

This project was developed for educational purposes only.
