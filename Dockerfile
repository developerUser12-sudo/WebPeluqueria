# Stage 1: Node para Vite
FROM node:20 AS node
WORKDIR /var/www/html

COPY package*.json ./
RUN npm install
COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

# Stage 2: PHP + Apache
FROM php:8.2-apache

# Instalar extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip pdo_pgsql

RUN a2enmod rewrite

# Copiar VirtualHost explícito
COPY docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Copiar proyecto
WORKDIR /var/www/html
COPY . .

# Copiar build de Vite
COPY --from=node /var/www/html/public/build /var/www/html/public/build

# Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]