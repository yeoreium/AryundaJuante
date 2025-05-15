# Gunakan image PHP 8.2 resmi
FROM php:8.2-fpm

# Instal dependensi sistem + library-header untuk ekstensi PHP
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    zlib1g-dev \
    libxml2-dev \
  && rm -rf /var/lib/apt/lists/*

# Konfigurasi ZIP agar menggunakan libzip, lalu install ekstensi PHP
RUN docker-php-ext-configure zip --with-libzip \
 && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Instal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www

# Salin file aplikasi ke dalam container
COPY . .

# Instal dependensi PHP
RUN composer install --no-dev --optimize-autoloader

# Atur izin file
RUN chown -R www-data:www-data /var/www

# Jalankan PHP-FPM
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
