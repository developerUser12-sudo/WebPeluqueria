# Stage 1: Node para construir assets
FROM node:20 AS node

WORKDIR /var/www/html

# Copiar package.json y lock
COPY package*.json ./

# Instalar dependencias JS
RUN npm install

# Copiar recursos de Laravel para build (JS/CSS)
COPY vite.config.js ./
COPY resources ./resources

# Construir assets
RUN npm run build

# Stage 2: PHP + Apache
FROM php:8.2-apache

# Instalar dependencias de PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip pdo_pgsql

# Instalar Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copiar todo el proyecto
COPY . /var/www/html/

# Copiar assets build desde stage Node
COPY --from=node /var/www/html/public/build /var/www/html/public/build

# Establecer WORKDIR
WORKDIR /var/www/html

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Ajustar permisos
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Cambiar DocumentRoot a /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Permitir .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Exponer puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]