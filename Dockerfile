# ---------- STAGE NODE: Build assets ----------
FROM node:20 AS node

WORKDIR /app

# Copiar package.json y package-lock.json y luego instalar dependencias
COPY package*.json ./
RUN npm install

# Copiar todo el código
COPY . .

# 🔹 Asegurar que la carpeta de build exista
RUN mkdir -p public/build

# Build de Vite
RUN npm run build

# ---------- STAGE PHP + Apache ----------
FROM php:8.2-apache

# Instalar extensiones y dependencias de PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Copiar Composer desde la imagen oficial
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copiar todo el código al contenedor PHP
COPY . /var/www/html/

# 🔥 Copiar build de Node
COPY --from=node /app/public/build /var/www/html/public/build

WORKDIR /var/www/html

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Limpiar caches de Laravel y crear enlace de storage
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan optimize:clear \
    && php artisan storage:link || true

# Ajustar permisos
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Configurar Apache
RUN a2enmod rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

# 🔹 Forzar que Laravel genere URLs HTTPS
RUN php artisan config:cache
ENV APP_URL=https://webpeluqueria.onrender.com

# CMD: ejecutar migraciones y arrancar Apache
CMD php artisan migrate --force || true && apache2-foreground

EXPOSE 80