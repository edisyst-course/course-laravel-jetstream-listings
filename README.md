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


# Policies
Utili per gestire accessi/autorizzazioni a degli object. Per non ripetere IF nei vari file

`php artisan make:policy ListingPolicy --model=Listing`


# Photos
`composer require "spatie/laravel-medialibrary:^9.0.0"`

https://spatie.be/docs/laravel-medialibrary/v9/installation-setup

    if ($request->hasFile('photo' . $i)) {
        $listing->addMediaFromRequest('photo' . $i)->toMediaCollection('listings');
    }

Il metodo `Listing::registerMediaConversions(Media $media = null): void` crea i thumbnail


# Taxonomies
Volendo potrei usare`composer require lecturize/laravel-taxonomies`, ma faccio alla vecchia maniera con 3 Model e le Relationship


# Saved
Posso salvare i listing che mi piacciono (devono essere di altri utenti, non miei), è un altro parametro di ricerca


# Mail
Uso sempre il mio https://mailtrap.io/, devo fare almeno qualche test
