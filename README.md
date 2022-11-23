# Membership Web App
Tech Stack : TALL (Taiwind, Alpinejs, Livewire, Laravel)

## Description
Membership Web app ialah sebuah aplikasi untuk menjalankan sistem keanggotaan. Untuk menjadi anggota, user biasa / guest harus membeli paket keanggotaan. paket ini bermacam-maca jenisnya, perbedaan utamanya dari harga dan durasi keanggotaan.

Cara kerja Web app ini adalah nanti akan ada user/guest yang belum mendaftar akan mendaftarkan diri disistem dengan cara memilih plan yang sudah tersedia. Setelah itu user melakukan konfirmasi pembayaran dan admin akan melakukan approval/reject

![alt text](https://raw.githubusercontent.com/ranggareng/membership-web-app-job-test/main/simple-flowchart.png)

## Getting started
### Dependencies
- Composer
- NPM
- NodeJs
- PHP >= 8.1
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Mysql 8 atau MariaDB setingkat

### Installing
- Prepare The Environment dengan cara copy .env.example ke .env
- Setup database configuration
- Install Composer Dependencies
```
composer install
```
- Install NPM
```
NPM Install
```
- Generate Application Key
```
php artisan key:generate
```
- Run Database Migration and Seed
```
php artisan migration --seed
```

### Executing Program
- Run NPM Dev
```
npm run dev
```
- Run Laravel Server
```
php artisan serve
```

### Deployment
- Run NPM Build
```
npm run build
```

### Testing
- Run Testing Laravel Dusk
```
php artisan dusk
```
- Run Unit Test
```
php artisan test
```