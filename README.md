# Monitoring Ruangan & Container v3 🚀

Sistem Monitoring Inventaris Ruangan dan Container berbasis web yang dirancang untuk mempermudah pelacakan aset, manajemen kondisi barang, dan pelaporan kerusakan secara real-time menggunakan integrasi QR Code.

## ✨ Fitur Utama

- **📦 Manajemen Container**: Kelola unit penyimpanan seperti lemari, loker, atau rak di dalam setiap ruangan.
- **🔍 Monitoring Inventaris**: Pantau jumlah barang dengan kondisi 'Baik' atau 'Rusak' secara mendetail.
- **📱 Integrasi QR Code**: Akses cepat informasi ruangan dan container hanya dengan melakukan scan QR Code.
- **🚩 Sistem Pelaporan**: Memungkinkan pengguna (Ketua Kelas/OB) melaporkan kerusakan atau kehilangan barang langsung dari lokasi.
- **🛡️ Role-Based Access Control (RBAC)**: Pembagian akses yang jelas antara Admin, Ketua Kelas, dan Office Boy (OB).
- **📊 Export Data**: Fitur untuk mengekspor riwayat laporan dan data inventaris.
- **🎨 UI/UX Modern**: Antarmuka berbasis Tailwind CSS dengan fitur searchable dropdown dan komponen premium.

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP (Custom MVC Framework)
- **Frontend**: Tailwind CSS, Vanilla JavaScript
- **Database**: MySQL
- **Tooling**: Node.js & npm (untuk build Tailwind)

## ⚙️ Cara Instalasi & Menjalankan

### 1. Persiapan Lingkungan
Pastikan Anda sudah menginstal:
- Web Server (Laragon / XAMPP / MAMP)
- PHP versi 7.4 ke atas
- MySQL Database
- Node.js (Opsional, hanya jika ingin mengubah gaya CSS)

### 2. Clone Repository
```bash
git clone https://github.com/arnugrha/monitoring-rooms-unpam.git
```

### 3. Konfigurasi Database
1. Buat database baru dengan nama `monitoring-rooms-v2` di phpMyAdmin Anda.
2. Import file database yang terletak di: `app/config/db/monitoring-rooms-v2.sql`.

### 4. Konfigurasi Aplikasi
Buka file `app/config/config.php` dan sesuaikan pengaturan berikut:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'monitoring-rooms-v2');
define('BASEURL', 'http://localhost/projects/montoring-rooms-v3/public/'); // Sesuaikan dengan path folder Anda
```

### 5. Build Assets (Opsional)
Jika Anda ingin melakukan modifikasi pada desain (Tailwind CSS):
```bash
cd public
npm install
npm run build
```

### 6. Akses Website
Buka browser Anda dan akses:
`http://localhost/projects/montoring-rooms-v3/public/`

## 👥 Akun Demo (Default)

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| OB | ob_user | ob123 |
| Ketua Kelas | mhs_user | mhs123 |

---
Dikembangkan dengan ❤️ untuk kemudahan monitoring aset.
