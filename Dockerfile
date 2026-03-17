# ------------------------------
# Stage 1: Node para Vite
# ------------------------------
FROM node:20 AS node
WORKDIR /var/www/html

# Copiar package.json y package-lock.json
COPY package*.json ./

# Instalar dependencias JS
RUN npm install

# Copiar recursos de Laravel (JS/CSS)
COPY vite.config.js ./
COPY resources ./resources

# Construir assets para producción
RUN npm run build

# ------------------------------
# Stage 2: PHP + Apache
# ------------------------------
FROM php:8.2-apache

# Instalar extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip pdo_pgsql

# Activar mod_rewrite (rutas Laravel)
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto Laravel completo
COPY . .

# Copiar build de Vite desde stage Node
COPY --from=node /var/www/html/public/build /var/www/html/public/build

# Instalar dependencias de PHP (solo prod)
RUN composer install --no-dev --optimize-autoloader

# Ajustar permisos para storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Configurar DocumentRoot a /public y permitir .htaccess
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Agregar configuración específica para Laravel
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/sites-available/000-default.conf

# Exponer puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]