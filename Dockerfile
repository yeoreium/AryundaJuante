# Gunakan image PHP 8.2 resmi
FROM php:8.2-fpm

# Pasang build tools + semua dev headers yang diperlukan
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    zlib1g-dev \
    libxml2-dev \
    libexif-dev \
    pkg-config \
    locales \
    zip \
    unzip \
    git \
    curl \
    vim \
    jpegoptim optipng pngquant gifsicle \
  && rm -rf /var/lib/apt/lists/*

# Konfigurasikan ZIP agar pakai libzip, lalu compile ekstensi
RUN docker-php-ext-configure zip --with-libzip=/usr \
 && docker-php-ext-install \
      pdo_mysql \
      mbstring \
      zip \
      exif \
      pcntl

# Salin dan jalankan Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www

# Salin aplikasi
COPY . .

# Install deps PHP
RUN composer install --no-dev --optimize-autoloader

# Izin file
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
