# Stage 1: Build assets
FROM node:20 AS node

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY vite.config.js ./
COPY resources ./resources

RUN npm run build


# Stage 2: PHP + Apache
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY . .

COPY --from=node /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN chown -R www-data:www-data storage bootstrap/cache public && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["sh","-c","php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan migrate --force && php artisan storage:link && apache2-foreground"]