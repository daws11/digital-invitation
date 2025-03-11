<p align="center"> <img src="/public/img/readme/logoreadme.jpg" width="400" alt="Digital Wedding Logo"></a></p>

## Tentang Proyek

Proyek ini adalah aplikasi undangan digital berbasis web yang dibangun menggunakan Laravel, sebuah framework PHP yang kuat dan elegan. Aplikasi ini memungkinkan pengguna untuk membuat dan mengelola undangan digital dengan mudah dengan fitur Scan QR code untuk melakukan update kehadiran tamu dan Manajemen Souvenir.

## Fitur

- **Pembuatan Undangan**: Pengguna dapat membuat undangan digital dengan berbagai template yang tersedia.
- **Manajemen Tamu**: Pengguna dapat mengelola daftar tamu undangan.
- **Scan QR Kehadiran Tamu**: Resepsionis dapat melakukan scan QR code tamu untuk melakukan update kehadiran.
- **Manajemen Souvenir**: Resepsionis juga dapat memberikan QR code yang nantinya akan di print dan diberikan ke tamu yang datang lalu ditukarkan menjadi souvenir saat hendak pulang
- **Pengiriman Undangan**: Undangan dapat dikirim melalui pesan whatsapp atau dibagikan melalui tautan.
- **RSVP**: Tamu dapat mengonfirmasi kehadiran mereka melalui undangan digital.

## Halaman Aplikasi

### Dashboard
Halaman dashboard memberikan ringkasan informasi tentang undangan dan tamu.
<p align="center"><img src="/public/img/readme/dashboard.jpg" width="300" alt="Dashboard"></p>

### Kehadiran
Halaman ini memungkinkan pengguna untuk melihat dan mengelola kehadiran tamu.
<p align="center"><img src="/public/img/readme/kehadiran.jpg" width="300" alt="Kehadiran"></p>

### Check-in
Halaman check-in memungkinkan pengguna untuk memeriksa tamu yang hadir dengan berbagai metode.
<p align="center"><img src="/public/img/readme/heckin.jpg" width="300" alt="Check-in"></p>

### Menu Check-in
Menu ini memberikan beberapa opsi untuk check-in tamu, termasuk scan QR-Code dan input manual.
<p align="center"><img src="/public/img/readme/menucheckin.jpg" width="300" alt="Menu Check-in"></p>

### Souvenir
Halaman ini digunakan untuk mengelola penukaran souvenir oleh tamu.
<p align="center"><img src="/public/img/readme/souvenir.jpg" width="300" alt="Souvenir"></p>

## Instalasi

1. Clone repositori ini:
    ```sh
    git clone https://github.com/daws11/digital-invitation.git
    ```

2. Masuk ke direktori proyek:
    ```sh
    cd digital-invitation
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