# Usa la imagen oficial de PHP con extensiones
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev zip unzip nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite gd

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos de la app
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Crear base de datos SQLite temporal
RUN touch /tmp/database.sqlite && chmod 777 /tmp/database.sqlite

# Generar clave si no existe (Render la usa de todos modos)
RUN php artisan key:generate || true

# Exponer el puerto para Render
EXPOSE 8000

# Comando para iniciar Laravel
CMD php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 8000
