# Stage 1: Build assets con Node
FROM node:20 as node

WORKDIR /var/www/html

COPY package*.json ./
RUN npm install

COPY vite.config.js ./
COPY resources ./resources

RUN npm run build

# Stage 2: PHP + Apache
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip pdo_pgsql

# Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Copiar build Vite
COPY --from=node /var/www/html/public/build /var/www/html/public/build

# Instalar deps PHP
RUN composer install --no-dev --optimize-autoloader

# 🔥 CREAR SYMLINK STORAGE (MUY IMPORTANTE)
RUN php artisan storage:link || true

# 🔥 Permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/public && \
    chmod -R 755 /var/www/html/storage && \
    chmod -R 755 /var/www/html/bootstrap/cache

# 🔥 Permitir acceso a storage
RUN echo '<Directory /var/www/html/public/storage>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>' >> /etc/apache2/apache2.conf

# Rewrite Laravel
RUN a2enmod rewrite

# DocumentRoot a /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]