<p align="center"> <img src="/public/img/readme/logoreadme.jpg" width="400" alt="Digital Wedding Logo"></a></p>

<p align="center">
  <a href="#english-version">English</a> |
  <a href="#versi-bahasa-indonesia">Indonesia</a>
</p>

<a name="english-version"></a>

## About The Project

This project is a web-based digital invitation application built using Laravel, a robust and elegant PHP framework. This application allows users to easily create and manage digital invitations with features like QR code scanning to update guest attendance and Souvenir Management.

## Application can be accessed at <a href="[https://www.je-project.my.id/](https://www.je-project.my.id/)">The Following Link</a>
with credentials:
 - email: admin@admin.com
 - password: password


## Features

- **Invitation Creation**: Users can create digital invitations with various available templates.
- **Guest Management**: Users can manage the guest list for the invitation.
- **Guest Attendance QR Scan**: Receptionists can scan guest QR codes to update attendance.
- **Souvenir Management**: Receptionists can also provide QR codes that will be printed and given to arriving guests, which can then be exchanged for souvenirs when they leave.
- **Invitation Sending**: Invitations can be sent via WhatsApp messages or shared via a link.
- **RSVP**: Guests can confirm their attendance through the digital invitation.

## Application Pages

### Dashboard
The dashboard page provides a summary of information about invitations and guests.
<p align="center"><img src="/public/img/readme/dashboard.jpg" width="300" alt="Dashboard"></p>

### Attendance
This page allows users to view and manage guest attendance.
<p align="center"><img src="/public/img/readme/kehadiran.jpg" width="300" alt="Attendance"></p>

### Check-in
The check-in page allows users to check in arriving guests using various methods.
<p align="center"><img src="/public/img/readme/checkin.jpg" width="300" alt="Check-in"></p>

### Check-in Menu
This menu provides several options for checking in guests, including QR code scanning and manual input.
<p align="center"><img src="/public/img/readme/menucheckin.jpg" width="300" alt="Check-in Menu"></p>

### Souvenir
This page is used to manage the exchange of souvenirs by guests.
<p align="center"><img src="/public/img/readme/souvenir.jpg" width="300" alt="Souvenir"></p>

## Installation

1. Clone this repository:
    ```sh
    git clone https://github.com/daws11/digital-invitation.git
    ```

2. Navigate to the project directory:
    ```sh
    cd digital-invitation
    ```

3. Install dependencies using Composer:
    ```sh
    composer install
    ```

4. Copy the `.env.example` file to `.env` and adjust the necessary configurations:
    ```sh
    cp .env.example .env
    ```

5. Generate the application key:
    ```sh
    php artisan key:generate
    ```

6. Migrate and seed the database:
    ```sh
    php artisan migrate --seed
    ```

7. Run the development server:
    ```sh
    php artisan serve
    ```

## Configuration

The application configuration can be found in the `config/` directory. Some important configuration files include:

- `config/app.php`: General application configuration.
- `config/database.php`: Database connection configuration.
- `config/mail.php`: Email sending configuration.

## Directory Structure

- `app/`: Contains the main application code.
- `bootstrap/`: Contains the application bootstrap files.
- `config/`: Contains the application configuration files.
- `database/`: Contains database migrations and seeders.
- `public/`: Contains public files accessible to users.
- `resources/`: Contains views, assets, and language files.
- `routes/`: Contains the application route definitions.
- `storage/`: Contains files generated by the application.
- `tests/`: Contains application test files.
- `vendor/`: Contains dependencies installed by Composer.

## Testing

To run the tests, use the following command:
```sh
php artisan test
```
<a name="versi-bahasa-indonesia"></a>
## Tentang Proyek

Proyek ini adalah aplikasi undangan digital berbasis web yang dibangun menggunakan Laravel, sebuah framework PHP yang kuat dan elegan. Aplikasi ini memungkinkan pengguna untuk membuat dan mengelola undangan digital dengan mudah dengan fitur Scan QR code untuk melakukan update kehadiran tamu dan Manajemen Souvenir.

## Aplikasi dapat di akses pada <a href="https://www.je-project.my.id/">Link Berikut </a>
dengan kredensial:
 - email: admin@admin.com
 - password: password


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
<p align="center"><img src="/public/img/readme/checkin.jpg" width="300" alt="Check-in"></p>

### Menu Check-in
Menu ini memberikan beberapa opsi untuk check-in tamu, termasuk scan QR-Code dan input manual.
<p align="center"><img src="/public/img/readme/menucheckin.jpg" width="300" alt="Menu Check-in"></p>

### Souvenir
Halaman ini digunakan untuk mengelola penukaran souvenir oleh tamu.
<p align="center"><img src="/public/img/readme/souvenir.jpg" width="300" alt="Souvenir"></p>

## Instalasi

1. Clone repositori ini:
    ```sh
    git clone [https://github.com/daws11/digital-invitation.git](https://github.com/daws11/digital-invitation.git)
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
```
