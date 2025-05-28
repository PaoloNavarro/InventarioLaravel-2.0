# Usa PHP-FPM con nginx integrado
FROM webdevops/php-nginx:8.3

# Configura el working dir
WORKDIR /app

# Copia el código de Laravel
COPY . /app

# Instala dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Asigna permisos correctos para Laravel
# Para `webdevops/php-nginx`, el usuario es `application`
RUN chown -R application:application /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Expone el puerto estándar para nginx
EXPOSE 80
