# ------------------------------
# Stage 1: Node para Vite
# ------------------------------
FROM node:20 AS node
WORKDIR /var/www/html

COPY package*.json ./
RUN npm install

COPY vite.config.js ./
COPY resources ./resources

RUN npm run build

# ------------------------------
# Stage 2: PHP + Apache
# ------------------------------
FROM php:8.2-apache

# Extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip pdo_pgsql

# Activar mod_rewrite (rutas Laravel)
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar proyecto Laravel completo
COPY . .

# Copiar build de Vite desde stage Node
COPY --from=node /var/www/html/public/build /var/www/html/public/build

# Instalar dependencias de PHP (solo prod)
RUN composer install --no-dev --optimize-autoloader

# Ajustar permisos para storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 storage bootstrap/cache

# Configurar DocumentRoot a /public y permitir .htaccess
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN echo '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/apache2.conf

# Exponer puerto
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]