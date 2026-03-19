# ---------- STAGE NODE: Build assets ----------
FROM node:20 AS node
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN mkdir -p public/build
RUN npm run build

# ---------- STAGE PHP + Apache ----------
FROM php:8.2-apache
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/
COPY --from=node /app/public/build /var/www/html/public/build

WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Limpiar caches y storage
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan optimize:clear \
    && php artisan storage:link || true

# Ajustar permisos
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Apache
RUN a2enmod rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# CMD: ejecutar migraciones y arrancar Apache
CMD ["sh", "-c", "php artisan migrate --force || true; apache2-foreground"]

EXPOSE 80