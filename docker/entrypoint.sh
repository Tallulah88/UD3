#!/bin/sh

# Verificar si .env existe, si no, crearlo
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Instalar dependencias de Composer
composer install --prefer-dist

# Generar clave de Laravel si no está definida
if ! grep -q "APP_KEY=" .env; then
    php artisan key:generate
fi

# Esperar a que la base de datos esté disponible antes de ejecutar migraciones
until mysqladmin ping -h mariadb --silent; do
    echo "Esperando a que MariaDB esté disponible..."
    sleep 2
done

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Iniciar PHP-FPM
exec php-fpm
