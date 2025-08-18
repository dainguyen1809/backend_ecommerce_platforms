FROM php:8.2-fpm

# Install required dependencies and clean up afterwards
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libmagickwand-dev \
    imagemagick \
    tzdata \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd zip pdo_pgsql mbstring exif pcntl bcmath \
    && pecl install imagick redis \
    && docker-php-ext-enable imagick redis \
    && apt-get remove -y libpng-dev libonig-dev libxml2-dev libzip-dev libjpeg-dev libfreetype6-dev libpq-dev libmagickwand-dev \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy custom PHP configuration
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Create and set permissions for PHP log directory
RUN mkdir -p /var/log/php && chmod -R 777 /var/log/php

# Set working directory for Laravel
WORKDIR /var/www

