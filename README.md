# 💼 AI-Powered Job Board & Recruitment Platform

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

A modern, full-stack web application designed to bridge the gap between job seekers and employers. Built with **Laravel**, this platform features role-based access control, candidate profile management, streamlined job application workflows, and an integrated **AI Assistant Chatbot** for automated candidate and admin support.

---

## ✨ Key Features

### 👤 Candidate Experience
* **Profile Management:** Candidates can upload resumes, manage skills, update profile pictures, and maintain employment descriptions.
* **Job Discovery:** Browse listed opportunities filtering by salary, work type (*Remote, On-site, Hybrid*), and category.
* **1-Click Application:** Apply for jobs seamlessly with automatic prevention of duplicate applications.
* **Application Tracking:** Track application status (*Applied, Cancelled*) with real-time status updates.

### 🛡️ Admin Management
* **Job Posting & Lifecycle Control:** Full CRUD functionality to list, update, and manage open positions.
* **Applicant Oversight:** Review submitted candidate profiles, phone numbers, resumes, and matched skill sets.
* **Candidate Pool Directory:** Dedicated admin directory to analyze top talent in the platform.

### 🤖 AI Assistant Chatbot
* Context-aware query processing for candidates seeking tailored job recommendations.
* Operational assistance for administrators managing candidate data and job postings.

---

## 🛠️ Tech Stack & Architecture

| Layer | Technology |
| :--- | :--- |
| **Backend Framework** | Laravel 10+ (PHP 8.2+) |
| **Database** | MySQL (Relational Schema with Cascading Constraints) |
| **Frontend** | Blade Engine, HTML5, CSS3, JavaScript, Bootstrap |
| **Authentication** | Session-based Auth & Middleware Authorization (`AdminMiddleware`) |
| **Testing & Mocking** | Database Seeders & Factories |

---

## 📂 Database Schema Overview

The core system architecture consists of three central entities with relational integrity:

* **`users`**: Handles authentication and stores candidate profile metadata (*skills, resume, phone number, role*).
* **`jobs`**: Stores job postings (*title, required skills, work type, location, salary, deadline*).
* **`job_applications`**: Relational pivot table linking candidates to jobs (`job_id`, `user_id`, `status`).

---

## 🚀 Quickstart Installation Guide

Follow these steps to get the project running locally.

### Prerequisites
* PHP >= 8.2
* Composer
* MySQL Server
* Node.js & NPM

### Step-by-Step Setup

1. **Clone the Repository**
   ```bash
   git clone [https://github.com/YOUR_USERNAME/ai-job-board.git](https://github.com/YOUR_USERNAME/ai-job-board.git)
   cd ai-job-board