FROM php:8.2-apache

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar archivo de configuración de Apache
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar el proyecto
COPY . /var/www/html
WORKDIR /var/www/html

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de PHP y Node
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Generar clave y crear base de datos SQLite
RUN php artisan key:generate --force
RUN mkdir -p /tmp/database && touch /tmp/database/database.sqlite

# Asignar permisos correctos
RUN chown -R www-data:www-data /var/www/html /tmp/database

EXPOSE 80
CMD ["apache2-foreground"]
