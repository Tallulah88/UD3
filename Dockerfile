FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar los archivos del proyecto
COPY . /var/www

# Permisos para almacenamiento y caché de Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Ejecutar Composer para instalar dependencias
RUN composer install --prefer-dist

# Definir usuario para ejecutar el contenedor
USER www-data

# Exponer el puerto de PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
