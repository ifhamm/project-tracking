# Aircraft Component Tracking System
## PT Dirgantara Indonesia

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Version](https://img.shields.io/badge/version-1.0.0-green.svg)](https://github.com/yourusername/aircraft-component-tracking)

## 📋 Deskripsi

Sistem Pelacakan Komponen Pesawat adalah platform web yang dirancang untuk memantau dan mengelola progres komponen pesawat dengan efisien. Sistem ini mendukung berbagai peran pengguna untuk memastikan alur kerja yang mulus dari penerimaan hingga penyelesaian komponen di PT Dirgantara Indonesia.

## 🚀 Fitur Utama

- **Multi-role Access Control** - 4 tingkat peran pengguna dengan hak akses berbeda
- **Component Management** - CRUD operasi untuk komponen pesawat
- **Break Down Part (BDP) Management** - Pengelolaan sub-komponen detail
- **Mechanic Process Tracking** - Sistem pelacakan pekerjaan mekanik
- **Dashboard Analytics** - Visualisasi progres komponen real-time
- **PDF Export** - Laporan yang dapat diunduh dalam format PDF
- **Document Upload** - Sistem dokumentasi untuk verifikasi pekerjaan

## 👥 Peran Pengguna

### 1. 🔧 Super Admin
- **Login**: Email & Password
- **Akses**: Penuh ke semua fitur
- **Kemampuan**:
  - CRUD Komponen, BDP, dan Proses Mekanik
  - Manajemen pengguna (PPC, Mekanik, PM)
  - Akses dashboard lengkap

### 2. 📊 PPC (Production Planning Control)
- **Login**: NIK (Nomor Induk Karyawan)
- **Akses**: Pengelolaan data komponen
- **Kemampuan**:
  - CRUD Komponen dan BDP
  - Monitoring progres produksi

### 3. 🔨 Mekanik
- **Login**: NIK
- **Akses**: Proses pengerjaan komponen
- **Kemampuan**:
  - Melihat daftar tugas yang ditugaskan
  - Menyelesaikan dan menandai tugas selesai
  - Upload dokumentasi pekerjaan

### 4. 📈 PM (Project Manager)
- **Login**: NIK
- **Akses**: Monitoring dan pelaporan
- **Kemampuan**:
  - Akses dashboard read-only
  - Export laporan ke PDF

## 🛠️ Teknologi yang Digunakan

```
Backend: Laravel (PHP Framework)
Frontend: HTML5, CSS3, Bootstrap
Database: MySQL
Authentication: Laravel Auth
```

## 📦 Instalasi

### Prerequisites
- PHP >= 8.0
- Composer
- MySQL
- Web Server (Apache/Nginx)
- Git

### Langkah Instalasi

1. Clone repository
```bash
git clone https://github.com/ifhamm/project-tracking.git
```

2. Install dependencies
```bash
composer install
```

3. Setup environment variables
```bash
cp .env.example .env
```
Edit file `.env` dan sesuaikan konfigurasi database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aircraft_tracking
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. Generate application key
```bash
php artisan key:generate
```

5. Setup database
```bash
# Buat database baru
mysql -u root -p
CREATE DATABASE aircraft_tracking;
exit

# Jalankan migrasi
php artisan migrate

# (Opsional) Jalankan seeder jika tersedia
php artisan db:seed
```

6. Setup storage link
```bash
php artisan storage:link
```

7. Run aplikasi
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🚦 Cara Penggunaan

### Login
- **Super Admin**: Gunakan email dan password
- **PPC/Mekanik/PM**: Gunakan NIK yang telah didaftarkan oleh Super Admin

### Dashboard
Menampilkan persentase progres komponen dari customer yang dipilih, memberikan gambaran visual cepat tentang status keseluruhan proyek.

### Pengelolaan Komponen
- Tambah, edit, hapus, dan lihat detail komponen
- Informasi meliputi: No. WBS, Part Name, Part Number, Date Received, Mekanik, Progress

### Break Down Part (BDP)
Pengelolaan sub-komponen dengan detail informasi:
- no_iwo, bdp_name, bdp_number_eqv, quantity, unit
- op_number, op_date, defect, mt_number, mt_quantity, mt_date

### Proses Mekanik
- Mekanik dapat melihat daftar tugas yang ditugaskan
- Menandai tugas selesai dan upload dokumentasi
- Super Admin dapat mengelola seluruh proses mekanik

## 📁 Struktur Folder

```
project-tracking/
├── app/
│   ├── Exceptions/
│   ├── Helpers/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Mail/
│   ├── Models/
│   ├── Observers/
│   ├── Providers/
│   ├── Services/
│   └── Traits/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── auth/
│       ├── emails/
│       ├── komponen/
│       ├── layouts/
│       ├── dashboard_utama.blade.php
│       ├── detail_komponen.blade.php
│       ├── dokumentasi.blade.php
│       ├── komponen.blade.php
│       └── proses_mekanik.blade.php
├── routes/
│   └── web.php
├── storage/
├── tests/
│   ├── Feature/
│   ├── Unit/
│   └── TestCase.php
├── vendor/
├── .editorconfig
├── .env
├── .env.example
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
├── README.md
└── vite.config.js

```

## 🔧 Artisan Commands

Beberapa perintah Laravel yang berguna untuk proyek ini:

```bash
# Membuat controller baru
php artisan make:controller ComponentController

# Membuat model dan migration
php artisan make:model Component -m

# Menjalankan migration
php artisan migrate

# Rollback migration
php artisan migrate:rollback

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate storage link
php artisan storage:link
```

## 📊 Struktur Data

### Komponen
- Work Breakdown Structure (WBS) Number
- Part Name & Part Number
- Date Received
- Assigned Mechanic
- Progress Status

### Break Down Part (BDP)
- Instruction Work Order Number
- BDP Name & Equivalent Number
- Quantity & Unit
- Operation Details
- Material Information
- Defect Tracking

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch untuk fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 License

Distributed under the MIT License. See `LICENSE` for more information.

## 👨‍💻 Developer

**PT Dirgantara Indonesia**
- Website: [https://www.ptdi.co.id](https://www.ptdi.co.id)
- Email: contact@ptdi.co.id

## 🐛 Bug Reports & Feature Requests

Jika Anda menemukan bug atau ingin mengajukan fitur baru, silakan buat issue di [GitHub Issues](https://github.com/ifhamm/project-tracking.git).
