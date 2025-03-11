<p align="center"><a href="https://laravel.com" target="_blank"><img src="logoreadme.jpg" width="400" alt="Digital Wedding Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang Proyek

Proyek ini adalah aplikasi undangan digital berbasis web yang dibangun menggunakan Laravel, sebuah framework PHP yang kuat dan elegan. Aplikasi ini memungkinkan pengguna untuk membuat dan mengelola undangan digital dengan mudah.

## Fitur

- **Pembuatan Undangan**: Pengguna dapat membuat undangan digital dengan berbagai template yang tersedia.
- **Manajemen Tamu**: Pengguna dapat mengelola daftar tamu undangan.
- **Pengiriman Undangan**: Undangan dapat dikirim melalui email atau dibagikan melalui tautan.
- **RSVP**: Tamu dapat mengonfirmasi kehadiran mereka melalui undangan digital.
- **Notifikasi**: Pengguna akan menerima notifikasi tentang status undangan dan RSVP.

## Instalasi

1. Clone repositori ini:
    ```sh
    git clone https://github.com/username/repo-name.git
    ```

2. Masuk ke direktori proyek:
    ```sh
    cd repo-name
    ```

3. Install dependensi menggunakan Composer:
    ```sh
    composer install
    ```

4. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi yang diperlukan:
    ```sh
    cp .env.example .env
    ```

5. Generate kunci aplikasi:
    ```sh
    php artisan key:generate
    ```

6. Migrasi dan seed database:
    ```sh
    php artisan migrate --seed
    ```

7. Jalankan server pengembangan:
    ```sh
    php artisan serve
    ```

## Konfigurasi

Konfigurasi aplikasi dapat ditemukan di direktori `config/`. Beberapa file konfigurasi penting antara lain:

- `config/app.php`: Konfigurasi aplikasi umum.
- `config/database.php`: Konfigurasi koneksi database.
- `config/mail.php`: Konfigurasi pengiriman email.

## Struktur Direktori

- `app/`: Berisi kode aplikasi utama.
- `bootstrap/`: Berisi file bootstrap aplikasi.
- `config/`: Berisi file konfigurasi aplikasi.
- `database/`: Berisi migrasi dan seeder database.
- `public/`: Berisi file publik yang dapat diakses oleh pengguna.
- `resources/`: Berisi view, asset, dan file bahasa.
- `routes/`: Berisi definisi rute aplikasi.
- `storage/`: Berisi file yang dihasilkan oleh aplikasi.
- `tests/`: Berisi file pengujian aplikasi.
- `vendor/`: Berisi dependensi yang diinstall oleh Composer.

## Pengujian

Untuk menjalankan pengujian, gunakan perintah berikut:
```sh
php artisan test
