## About Kemhan-App

Aplikasi Kemhan bertujuan untuk memanejemen data katalog perusahaan yang ada pada kementrian pertahanan. Sehingga memudahkan dalam pengaksesan data perusahaan dan product lelang.

### Installation
- Buka terminal atau command prompt, clone git dengan perintah : 
```bash
git clone https://github.com/jangker75/kemhan.git
```
- Buka direktori projek kemhan yang telah selesai di clone dan copy paste file `.env.example` rename nama file menjadi `.env`
- Ubah isi file `.env` pada bagian database config :
```bash
DB_DATABASE=kemhan
DB_USERNAME=root
DB_PASSWORD=
```
- Buat database baru dengan nama `kemhan` melalui phpmyadmin ataupun database managemen lainnya
- Jalankan perintah dibawah pada terminal atau command prompt didalam folder projek secara berurutan
```bash
composer install
php artisan key:generate
composer dump-autoload
php artisan kemhan:createdb
php artisan kemhan:dummydb
```
- Upload/Import file .sql yang ada didalam folder database kedalam Mysql melalui phpmyadmin atau database managemen lainnya kedalam database `kemhan`
- Akses aplikasi ke url projek
`http://domain/{namafolderprojek}/public (Frontend)`
`http://domain/{namafolderprojek}/public/admin (Admin panel)`
- Password default admin `User : admin@kkip.com` `Password : 123456`

## Daftar CR

28 Oktober 2021 :
- Penambahan Kolom Sub Sub-Category pada data product(Charged).
- Penambahan Kolom NIB pada Supplier(Charged).
- Penambahan fitur add supplier ke product(Charged).

3 November 2021 :
- Perubahan relasi jadi many to many relasi-product (product bisa punya lebih dari 1 supplier)(Charged).
- Penambahan kolom tipe product, many to many ke product.
- Penambahan kolom satuan kemampuan produksi.
- Penambahan kolom mata uang harga product.

