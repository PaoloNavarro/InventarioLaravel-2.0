# Usa PHP-FPM en lugar de Apache
FROM php:8.3-fpm

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev git unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el código de Laravel al contenedor
WORKDIR /var/www/html
COPY . /var/www/html

# Instala dependencias de Laravel
RUN composer install  

# Verifica si el directorio vendor está presente
RUN ls -alh /var/www/html/vendor



# Da permisos a las carpetas necesarias para storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]