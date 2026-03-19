# ---------- STAGE NODE ----------
FROM node:20 as node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

RUN npm run build


# ---------- STAGE PHP ----------
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . /var/www/html/

# 🔥 COPIAR BUILD DE VITE
COPY --from=node /app/public/build /var/www/html/public/build

WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# 🔥 limpiar TODAS las caches de laravel (MUY IMPORTANTE en Docker)
RUN php artisan optimize:clear

# storage link
RUN php artisan storage:link

# 🔥 permisos IMPORTANTES para que apache pueda leer assets
RUN chmod -R 755 public/build && \
    chown -R www-data:www-data public/build

RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# apache rewrite
RUN a2enmod rewrite

# document root a public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

# 🔥 arrancar migraciones pero sin romper contenedor
CMD php artisan migrate --force || true && apache2-foreground

EXPOSE 80