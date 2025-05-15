# 1. Base image
FROM php:8.1-fpm

# 2. Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
    libicu-dev \
    git curl \
 && docker-php-ext-configure zip --with-libzip \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd intl \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# 3. Install Composer (dari official Composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www

# 5. Copy aplikasi ke dalam container
COPY . /var/www

# 6. Install PHP dependencies via Composer
RUN composer install --optimize-autoloader --no-dev

# 7. Set permissions (sesuaikan dengan user/nginx atau www-data)
RUN chown -R www-data:www-data /var/www \
 && chmod -R 755 /var/www/storage

# 8. Expose port dan jalankan PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]


# Gunakan image PHP 8.2 resmi
# FROM php:8.2-fpm

# # Instal dependensi sistem
# RUN apt-get update && apt-get install -y \
#     build-essential \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     locales \
#     zip \
#     jpegoptim optipng pngquant gifsicle \
#     vim \
#     unzip \
#     git \
#     curl

# # Instal ekstensi PHP yang diperlukan
# RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# # Instal Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Atur direktori kerja
# WORKDIR /var/www

# # Salin file aplikasi ke dalam container
# COPY . .

# # Instal dependensi PHP
# RUN composer install

# # Atur izin file
# RUN chown -R www-data:www-data /var/www

# # Jalankan PHP-FPM
# CMD ["php-fpm"]
