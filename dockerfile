FROM php:8.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y zip unzip git netcat-openbsd \
    && docker-php-ext-install pdo pdo_mysql

COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

# http://localhost:8085/