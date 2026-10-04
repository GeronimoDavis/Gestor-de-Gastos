FROM php:8.4-apache

# Instalar librerías del sistema y extensiones necesarias de PHP (zip, bcmath, pdo_pgsql)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip bcmath

# Activar mod_rewrite de Apache para el ruteo de Laravel
RUN a2enmod rewrite

# Configurar Apache para apuntar a la carpeta /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# Copiar el código del proyecto al contenedor
COPY . /var/www/html

# Copiar ejecutable de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias de Composer para producción
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Otorgar permisos de escritura a Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80