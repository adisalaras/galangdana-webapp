Sistem Informasi Galang Dana

Sistem Informasi Galang Dana adalah platform penggalangan dana online berbasis web yang dibangun menggunakan Laravel framework. Proyek ini bertujuan untuk memfasilitasi proses penggalangan dana secara efisien dan transparan.

## Fitur Utama

- Manajemen pengguna (pendaftaran, login, profil)
- Pembuatan dan pengelolaan kampanye penggalangan dana
- Sistem donasi yang aman
- Pencarian dan filter kampanye berdasarkan kategori
- Pengelolaan fase kampanye
- Sistem penarikan dana dengan verifikasi admin
- Dashboard admin untuk manajemen konten dan verifikasi

## Teknologi

- Backend: Laravel 11
- Frontend: Blade
- CSS: Tailwind CSS
- Autentikasi: Laravel Breeze
- Otorisasi: Spatie Laravel-permission
- Database: MySQL

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js >= 14.x
- NPM >= 6.x

## Struktur Database (ERD)
![image](https://github.com/user-attachments/assets/48064a86-fb24-4bb3-a7c6-c6afe75bcbab)

### Penjelasan Entitas:
1. **users**
   - Menyimpan informasi pengguna sistem.
   - Atribut: id, name, avatar, email, email_verified_at, password, remember_token, created_at, updated_at

2. **fundraisers**
   - Mengelola data penggalang dana.
   - Atribut: id, user_id, is_active, deleted_at, created_at, updated_at

3. **fundraisings**
   - Menyimpan informasi kampanye penggalangan dana.
   - Atribut: id, name, slug, target_amount, about, is_active, has_finished, thumbnail, fundraiser_id, category_id, deleted_at, created_at, updated_at

4. **categories**
   - Kategori untuk kampanye penggalangan dana.
   - Atribut: id, name, slug, icon, deleted_at, created_at, updated_at

5. **fundraising_phases**
   - Mengelola fase-fase dalam kampanye penggalangan dana.
   - Atribut: id, name, notes, photo, fundraising_id, deleted_at, created_at, updated_at

6. **fundraising_withdrawals**
   - Mencatat penarikan dana dari kampanye.
   - Atribut: id, proof, bank_name, bank_account_number, bank_account_name, amount_requested, amount_received, has_received, has_sent, fundraiser_id, fundraising_id, deleted_at, created_at, updated_at

7. **donaturs**
   - Menyimpan informasi donatur.
   - Atribut: id, name, phone_number, fundraising_id, total_amount, notes, proof, is_paid, deleted_at, created_at, updated_at

### Relasi Antar Entitas:

- **users** - **fundraisers**: One-to-One
- **fundraisers** - **fundraisings**: One-to-Many
- **fundraisings** - **categories**: Many-to-One
- **fundraisings** - **fundraising_phases**: One-to-Many
- **fundraisings** - **fundraising_withdrawals**: One-to-Many
- **fundraisings** - **donaturs**: One-to-Many

Struktur database ini dirancang untuk mendukung semua fitur utama sistem, termasuk manajemen pengguna, kampanye penggalangan dana, donasi, dan penarikan dana.

## Instalasi

1. Clone repositori
 ```
 git clone https://github.com/adrianramadhan/galangdana-webapp.git
 ```
3. Masuk ke direktori proyek
 ```
 cd galangdana-webapp
 ```
5. Instal dependensi PHP
 ```
 composer install
 ```
7. Instal dependensi JavaScript
 ```
 npm install
 ```
9. Salin file .env.example menjadi .env dan sesuaikan konfigurasi database
10. Generate app key
 ```
 php artisan key:generate
 ```
12. Jalankan migrasi database
 ```
 php artisan migrate
 ```
14. Compile asset
 ```
 npm run dev
 ```
16. Jalankan server development
 ```
 php artisan serve
 ```

## Kontribusi

Kami menyambut kontribusi dari komunitas. Silakan buat pull request atau laporkan issues jika Anda menemukan bug atau memiliki saran perbaikan.
