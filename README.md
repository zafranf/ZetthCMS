# Situs Komuntias Penggemar Merpati Seluruh Indonesia
CMS yang dibuat dari Laravel Framework (aslinya cuma untuk proyek pribadi)

### Yang dibutuhkan:
-   Semua yang [dibutuhkan Laravel](https://laravel.com/docs/6.x#server-requirements)
-   Ekstensi _Imagick_

### Cara Instal:
#### Lewat Composer create-project
-   Siapkan _database_
-   Jalankan `composer create-project zafranf/zetthcms`
-   Atur semua nilai di file `.env` (terutama `APP_*` dan `DB_*`)
-   Jalankan `php artisan zetth:install`
#### Lewat Manual/_Clone_
-   Siapkan _database_
-   Unduh atau _clone_ proyek ini
-   Ekstrak hasil unduhan (lewati jika menggunakan _clone_) dan masuk ke folder proyek
-   Jalankan `composer install`
-   Salin file `.env.example` jadi `.env`
-   Jalankan `php artisan key:generate`
-   Atur semua nilai di file `.env` (terutama `APP_*` dan `DB_*`)
-   Jalankan `php artisan zetth:install`

### Jalankan aplikasi:
-   Jalankan `php artisan serve`

### Jalankan _Jobs_:
#### Menggunakan queue:work dengan `supervisor`
- Silakan mengacu pada [dokumentasi Laravel](https://laravel.com/docs/6.x/queues#supervisor-configuration)
#### Menggunakan queue:listen di _background_
- Jalankan `php artisan queue:listen &`