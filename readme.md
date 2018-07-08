## Cara setup
1. Run **composer install**
2. Run **php artisan key:generate**, copy dulu .env nya, setting DB disesuaikan juga
3. Pada file **default-configuration.ini** di path **BismillahNLC\public\js\tinymce\plugins\tiny_mce_wiris\integration\lib\**
   ganti **wiriscachedirectory** dan **wirisformuladirectory** ke absolute path folder /storage/app/public/cache dan /storage/app/public/formulas.
   Contoh: J:/KULIAH/schematics/NLC2018/BismillahNLC/storage/app/public/formulas
4. Run **php artisan storage:link**
5. Run **php artisan migrate:fresh**
6. Run **php artisan db:seed** (untuk dummy user data)
7. Dummy data https://notepad.pw/mockdata & https://notepad.pw/mockdata2
8. Serve pake XAMPP, jangan pakai php artisan serve. DOMPDF lemot kalau pakai php artisan serve.
9. Makasih :)
