## Cara setup
1. Run **composer install**
2. Run **php artisan key:generate**
3. Copy isi file **BismillahNLC\public\js\tinymce\plugins\tiny_mce_wiris\integration\lib\sample-default-configuration.ini** ke file baru bernama **default-configuration.ini** di path **BismillahNLC\public\js\tinymce\plugins\tiny_mce_wiris\integration\lib\**.
   Ganti **wiriscachedirectory** dan **wirisformuladirectory** ke absolute path folder /storage/app/public/cache dan /storage/app/public/formulas.
   Contoh: J:/KULIAH/schematics/NLC2018/BismillahNLC/storage/app/public/formulas
4. Run **php artisan storage:link**
5. Download redis server
6. Run redis server
7. Nyalakan mysql server, serve app.
8. Enjoy

## .env sample
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
