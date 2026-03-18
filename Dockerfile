# Stage 1: Build assets con Node
FROM node:20 AS node

WORKDIR /var/www/html

# Copiar dependencias de Node y construir assets
COPY package*.json ./
RUN npm install

COPY vite.config.js ./
COPY resources ./resources

RUN npm run build

# Stage 2: PHP + Apache
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Copiar composer desde imagen oficial
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Configurar Apache
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copiar todo el proyecto
WORKDIR /var/www/html
COPY . /var/www/html/

# Copiar los assets build de Node
COPY --from=node /var/www/html/public/build /var/www/html/public/build

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Configurar permisos correctos
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache public

# Crear el enlace para storage
RUN php artisan storage:link

# Exponer puerto 80
EXPOSE 80

# Arrancar Apache en primer plano
CMD ["apache2-foreground"]