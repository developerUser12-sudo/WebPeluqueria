# ------------------------------
# Stage 1: Build assets con Node
# ------------------------------
FROM node:20 as node

WORKDIR /var/www/html

# ⚠️ Copiar TODO el proyecto (no solo resources)
COPY . .

# Instalar dependencias JS
RUN npm install

# Build producción Vite
RUN npm run build


# ------------------------------
# Stage 2: PHP + Apache
# ------------------------------
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip pdo_pgsql

# Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar proyecto Laravel
COPY . .

# Copiar assets generados por Vite
COPY --from=node /var/www/html/public/build /var/www/html/public/build

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Permisos Laravel
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# Activar rewrite
RUN a2enmod rewrite

# Servir desde public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]