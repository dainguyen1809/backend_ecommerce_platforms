FROM php:8.2-fpm as php

# Set environment variables
ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=1
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_REVALIDATE_FREQ=0

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libcurl4-gnutls-dev \
    nginx \
    libonig-dev \
    && docker-php-ext-install pdo_pgsql bcmath curl opcache mbstring

# Install Composer
COPY --from=composer:2.4.1 /usr/bin/composer /usr/bin/composer

# Copy config files
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Set working directory
WORKDIR /var/www

RUN usermod --uid 1000 www-data && groupmod --gid 1001 www-data

COPY --chown=www-data:www-data . .

RUN mkdir -p storage/framework/{cache,sessions,views,testing} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap \
    && chmod -R 775 storage bootstrap

# Adjust www-data UID/GID (optional, helps when syncing with host system)
RUN usermod --uid 1000 www-data && groupmod --gid 1001 www-data

COPY docker/scripts/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
