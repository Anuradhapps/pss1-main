# Use official PHP 8.1 FPM image as base
FROM php:8.1-fpm

# Install system dependencies needed for Laravel
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql mbstring zip

# Install Composer (PHP package manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory inside container
WORKDIR /var/www/html

# Copy all project files to working directory
COPY . .

# Install PHP dependencies without dev packages and optimize
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Cache Laravel config for better performance
RUN php artisan config:cache

# Expose port 9000 (default php-fpm port)
EXPOSE 9000

# Start php-fpm process when container launches
CMD ["php-fpm"]
