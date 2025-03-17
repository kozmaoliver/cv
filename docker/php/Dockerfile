FROM mlocati/php-extension-installer:2.7 AS php_extension_installer

FROM composer/composer:2.7-bin AS composer

FROM php:8.2-fpm-alpine3.21

COPY --chown=root:root --chmod=755 --from=php_extension_installer /usr/bin/install-php-extensions /usr/local/bin/

COPY --chown=root:root --chmod=755 --from=composer /composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install required PHP extensions
RUN apk add libpq-dev \
    && install-php-extensions \
      pdo pdo_pgsql

# Set the working directory
WORKDIR /var/www/html

# Copy project files
COPY ../.. /var/www/html

# Set file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 9000
