# ---------- STAGE PHP ----------
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copiar todo el código
COPY . /var/www/html/

# Copiar build de Node
COPY --from=node /app/public/build /var/www/html/public/build

WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# 🔹 Laravel setup
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan optimize:clear \
    && php artisan storage:link || true

# Permisos
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Apache mod
RUN a2enmod rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

# Ejecutar migraciones y arrancar Apache
CMD php artisan migrate --force || true && apache2-foreground

EXPOSE 80