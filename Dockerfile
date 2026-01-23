FROM php:8.0-apache

RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpng-dev libonig-dev \
 && docker-php-ext-install pdo pdo_mysql zip gd opcache \
 && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar opcache.ini (asegúrate que el archivo exista)
COPY ./docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

EXPOSE 80
CMD ["apache2-foreground"]
