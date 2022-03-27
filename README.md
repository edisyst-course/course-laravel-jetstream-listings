# Installation

```php
composer create-project laravel/laravel:^8.0 course-laravel-jetstream-listings
composer require laravel/jetstream
php artisan jetstream:install livewire
npm install && npm run dev
php artisan migrate:fresh --seed
php artisan route:list --compact
php artisan vendor:publish --tag=jetstream-views
```


# Seeder delle città
Cerco l'elenco delle città della mia nazione, per esempio UK, e importo ad esempio un CSV su phpmyadmin

Giusto per popolare la tabella delle cities scrivo `UPDATE categories SET created_at = now(), updated_at = now()`

Dal DB pieno questo pkg mi crea il seeder

    composer require --dev orangehill/iseed
    php artisan iseed cities


# Profile photo

In .env imposto `APP_URL=http://127.0.0.1:8000`

`php artisan storage:link`

