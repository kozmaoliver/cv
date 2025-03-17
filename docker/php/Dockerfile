FROM composer/composer:2.7-bin AS composer

FROM php:8.2-fpm

COPY --chown=root:root --chmod=755 --from=composer /composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set the working directory
WORKDIR /var/www/html

# Copy project files
COPY ../.. /var/www/html

# Set file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 9000
