# Imagen oficial de PHP
FROM php:8.3-cli

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev sqlite3 libsqlite3-dev curl \
    && docker-php-ext-install pdo pdo_sqlite bcmath \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de PHP optimizadas (no dev)
RUN composer install --no-dev --optimize-autoloader

# Generar la key de Laravel
RUN php artisan key:generate --force

# Exponer el puerto que Render usará
EXPOSE 10000

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
