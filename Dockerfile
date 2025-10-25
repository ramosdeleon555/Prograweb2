# Imagen base oficial de PHP con extensiones necesarias
FROM php:8.3-cli

WORKDIR /var/www/html

# Instalar dependencias del sistema y extensiones requeridas
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev sqlite3 libsqlite3-dev curl npm \
    && docker-php-ext-install pdo pdo_sqlite bcmath \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar todos los archivos del proyecto
COPY . .

# Crear archivo SQLite y dar permisos correctos
RUN touch database/database.sqlite && chmod -R 775 database storage bootstrap/cache

# Copiar .env.example a .env si no existe
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Instalar dependencias de PHP optimizadas
RUN composer install --no-dev --optimize-autoloader

# Generar la app key de Laravel
RUN php artisan key:generate --force

# Instalar dependencias de Node.js y compilar assets
RUN npm install && npm run build

# Exponer el puerto que Render utilizará
EXPOSE 10000

# Iniciar el servidor de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
