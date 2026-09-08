FROM php:8.2-apache

# Activer le module rewrite d'Apache (indispensable pour FastRoute)
RUN a2enmod rewrite

# Installer les outils nécessaires et l'extension de base de données pour PHP
RUN apt-get update && apt-get install -y zip unzip git \
    && docker-php-ext-install pdo pdo_mysql

# Configurer le serveur virtuel Apache pour pointer sur le dossier /public
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Installer Composer globalement
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
