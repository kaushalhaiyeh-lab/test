FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    zip \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        zip \
        intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Publish Livewire & Filament assets
RUN php artisan livewire:publish --assets \
 && php artisan filament:assets

# Permissions
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

# Run migrations, seed, start server
CMD php artisan migrate --force \
 && php artisan db:seed --force \
 && php -S 0.0.0.0:10000 -t public
