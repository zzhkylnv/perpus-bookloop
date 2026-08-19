FROM php:8.2-fpm

# Install ekstensi PDO MySQL untuk Laravel
RUN docker-php-ext-install pdo pdo_mysql