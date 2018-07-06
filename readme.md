##Cara setup
1. Run **composer install**
2. Run **php artisan key:generate**
3. Pada file **default-configuration.ini** di path **BismillahNLC\public\js\tinymce\plugins\tiny_mce_wiris\integration\lib\**
   ganti **wiriscachedirectory** dan **wirisformuladirectory** ke absolute path folder /storage/app/public/cache dan /storage/app/public/formulas.
   Contoh: J:/KULIAH/schematics/NLC2018/BismillahNLC/storage/app/public/formulas
4. Run **php artisan storage:link**
5. Serve pake XAMPP, jangan pakai php artisan serve. DOMPDF lemot kalau pakai php artisan serve.
6. Makasih :)
