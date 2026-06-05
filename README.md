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
* Export payslips PDF

### Administrator Module

* Manage employee records
* Manage attendance records
* Manage deductions
* Generate payroll
* View system reports

---

## 💰 Payroll Computation

### Daily Rate

Monthly Salary is divided into 15 working days per cut-off period.

```text
Daily Rate = Monthly Salary ÷ 15
```

### Gross Pay

Gross Pay is calculated based on the employee's present days.

```text
Gross Pay = Daily Rate × Present Days
```

### Late Deduction

Each late day incurs a deduction equivalent to 20% of the employee's daily rate.

```text
Late Deduction = Late Days × (Daily Rate × 20%)
```

### Manual Deductions

Additional deductions selected by the administrator (e.g., Cash Advance, Uniform, Loan, etc.).

```text
Manual Deduction = Sum of Selected Deductions
```

### Total Deductions

```text
Total Deductions = Late Deduction + Manual Deduction
```

### Net Pay

```text
Net Pay = Gross Pay − Total Deductions
```

If Total Deductions exceed Gross Pay, the Net Pay is automatically set to 0.

```text
Net Pay = Max(Gross Pay − Total Deductions, 0)
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

## 📊 Reports Module

The Reports Module provides a centralized analytics dashboard for monitoring employee statistics, payroll summaries, and salary trends within the system.

---

## 📈 Salary Analytics

The system generates a multi-line chart that visualizes the **net salary trends per employee** based on generated payroll records.

### Data Source

* Net Pay per payroll record
* Grouped by employee
* Sorted by payroll date

### Visualization

* Multi-line graph per employee
* X-axis: Payroll dates
* Y-axis: Net salary amount

---

## 📊 Key Metrics Dashboard

The system displays real-time computed payroll and attendance statistics:

### 👥 Employee Statistics

* Total number of employees

### 💰 Payroll Summary

* Gross Payroll (total earnings before deductions)
* Net Pay (final salary after deductions)
* Total Deductions (late + manual deductions)
* Payroll Runs (number of generated payroll records)

### ⏱ Attendance Summary

* Total Present Days
* Total Absent Days
* Total Late Days

### ⚠️ Deduction Summary

* Total Late Deductions
* Combined manual and system deductions

---

## 📌 Additional Insights

* Present vs Late/Absent comparison
* Payroll consistency tracking per employee
* Historical salary trend visualization

---

## 🎯 Purpose

This module helps administrators:

* Monitor payroll expenses
* Track employee attendance performance
* Analyze salary trends over time
* Identify deduction patterns
* Generate data-driven payroll decisions

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
