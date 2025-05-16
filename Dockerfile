# PHP-FPM
FROM php:8.2-fpm

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
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Install Xdebug (untuk development)
# RUN pecl install xdebug \
#     && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install dependencies (production)
RUN composer install --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Expose port 9000
EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080

# CMD ["php-fpm"]


# # 1. Gunakan base image PHP 8.2
# FROM php:8.2.20-fpm

# # 2. Install system dependencies & PHP extensions
# RUN apt-get update && apt-get install -y \
#     libzip-dev zip unzip \
#     libpng-dev libjpeg-dev libfreetype6-dev \
#     libwebp-dev \
#     libonig-dev libxml2-dev \
#     libicu-dev \
#     git curl \
#  && docker-php-ext-configure zip \
#  && docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
#  && docker-php-ext-install -j$(nproc) \
#     zip pdo_mysql mbstring exif pcntl bcmath gd intl \
#  && pecl install xdebug-3.3.1 \
#  && docker-php-ext-enable xdebug \
#  && apt-get clean \
#  && rm -rf /var/lib/apt/lists/*

# # 3. Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # 4. Set working directory
# WORKDIR /var/www

# # 5. Copy aplikasi
# COPY . /var/www

# # 6. Install dependencies
# RUN composer install --optimize-autoloader --no-dev

# # 7. Set permissions
# RUN chown -R www-data:www-data /var/www \
#  && chmod -R 755 /var/www/storage

# # 8. Expose port
# EXPOSE 9000
# CMD ["php-fpm"]
# # Gunakan image PHP 8.2 resmi
# # FROM php:8.2-fpm

# # # Instal dependensi sistem
# # RUN apt-get update && apt-get install -y \
# #     build-essential \
# #     libpng-dev \
# #     libjpeg-dev \
# #     libfreetype6-dev \
# #     locales \
# #     zip \
# #     jpegoptim optipng pngquant gifsicle \
# #     vim \
# #     unzip \
# #     git \
# #     curl

# # # Instal ekstensi PHP yang diperlukan
# # RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# # # Instal Composer
# # COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # # Atur direktori kerja
# # WORKDIR /var/www

# # # Salin file aplikasi ke dalam container
# # COPY . .

# # # Instal dependensi PHP
# # RUN composer install

# # # Atur izin file
# # RUN chown -R www-data:www-data /var/www

# # # Jalankan PHP-FPM
# # CMD ["php-fpm"]
