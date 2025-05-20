# Gunakan image PHP + Apache untuk kemudahan (atau PHP-FPM + Nginx jika lebih ahli)
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy aplikasi
COPY . .


# Install dependencies (production)
RUN composer install --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

# Buat symlink storage → public/storage
# Pastikan folder public/storage belum ada (jika ada, hapus dulu)
RUN if [ -d public/storage ]; then rm -rf public/storage; fi \
 && php artisan storage:link

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Aktifkan mod rewrite Apache
RUN a2enmod rewrite

# Port ekspos
EXPOSE 80

# Apache akan otomatis menjalankan service