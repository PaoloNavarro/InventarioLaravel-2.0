#!/bin/sh

# Instala dependencias si no existen
if [ ! -d "vendor" ]; then
  echo "==> Ejecutando composer install..."
  composer install 
fi

# Permisos para Laravel
echo "==> Asignando permisos a storage y bootstrap/cache..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache


# Ejecuta PHP-FPM
exec php-fpm

