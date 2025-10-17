# App Pegawai - Sistem Manajemen Karyawan

**Workshop Aplikasi Berbasis Web - TEKNIK INFORMATIKA PENS 25**

Aplikasi manajemen karyawan berbasis web yang dibuat dengan Laravel 11, mengelola data karyawan, departemen, posisi, kehadiran, dan penggajian.

## 🚀 Fitur Utama

- **Manajemen Karyawan** - CRUD data karyawan lengkap
- **Departemen & Posisi** - Struktur organisasi perusahaan
- **Sistem Kehadiran** - Tracking attendance karyawan
- **Penggajian** - Manajemen gaji dan tunjangan
- **Dashboard Analytics** - Statistik real-time dengan bento grid layout
- **Responsive Design** - Menggunakan Pico CSS framework

## 📋 Requirements

Pastikan sistem Anda memiliki:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 8.0 atau **PostgreSQL** >= 13
- **Node.js** >= 18 (opsional untuk asset compilation)

## ⚙️ Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/attaryu/app-pegawai.git
cd app-pegawai
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
# Copy file environment
cp .env.example .env

# Edit konfigurasi database di file .env
# Sesuaikan dengan kredensial database Anda
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=app_pegawai
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Buat Database Kosong

Buat database kosong dengan nama `app_pegawai` (atau sesuai konfigurasi di `.env`):

#### MySQL:
```sql
CREATE DATABASE app_pegawai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### PostgreSQL:
```sql
CREATE DATABASE app_pegawai;
```

### 6. Jalankan Setup Script

Gunakan script setup yang telah tersedia di `composer.json`:

```bash
composer run setup
```

Script ini akan menjalankan:
- `php artisan key:generate` - Generate application key
- `php artisan migrate:fresh` - Setup database tables
- `php artisan db:seed` - Populate database dengan sample data

### 7. Jalankan Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 📊 Sample Data

Setelah menjalankan seeder, aplikasi akan memiliki:

- **100 Karyawan** dengan data lengkap
- **10 Departemen** (HR, Finance, IT, Marketing, dll)
- **15 Posisi/Jabatan** dengan gaji pokok
- **500+ Record Kehadiran** untuk testing
- **100+ Record Gaji** dengan perhitungan otomatis

## 🗂️ Struktur Database

### Tables:
- `employees` - Data karyawan
- `departments` - Data departemen
- `positions` - Data posisi/jabatan
- `attendances` - Data kehadiran
- `salaries` - Data penggajian

### Relationships:
```
employees
├── belongsTo: departments
├── belongsTo: positions  
├── hasMany: attendances
└── hasMany: salaries
```

## 🏗️ Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Pico CSS
- **Database**: MySQL/PostgreSQL
- **Icons**: Font Awesome
- **Styling**: CSS Grid, Flexbox, Custom Properties

## 📝 License

Project ini dibuat untuk keperluan pembelajaran di **Teknik Informatika PENS**.
