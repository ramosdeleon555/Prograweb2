# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones y dependencias del sistema necesarias para Laravel y SQLite
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev zip unzip nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_sqlite gd

# Habilitar mod_rewrite de Apache (necesario para Laravel)
RUN a2enmod rewrite

# Configurar Apache para servir el contenido desde public/
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar todos los archivos del proyecto
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node y compilar el frontend
RUN npm install && npm run build

# Generar la clave de Laravel
RUN php artisan key:generate --force

# Crear base de datos SQLite (se almacenará en /tmp)
RUN mkdir -p /tmp/database && touch /tmp/database/database.sqlite

# Asignar permisos correctos
RUN chown -R www-data:www-data /var/www/html /tmp/database

# Exponer el puerto
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
