FROM php:8.3-cli

WORKDIR /var/www/html

# Instalar dependencias de sistema, PHP y SQLite
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev sqlite3 libsqlite3-dev curl npm \
    && docker-php-ext-install pdo pdo_sqlite bcmath \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto
COPY . .

# Copiar .env.example a .env si no existe
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Crear archivo SQLite si no existe
RUN mkdir -p database && touch database/database.sqlite

# Dar permisos a storage y cache
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependencias PHP y generar key
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --force

# Instalar dependencias de Node.js y construir assets de Vite/Tailwind
RUN npm install
RUN npm run build

# Exponer puerto de Laravel
EXPOSE 10000

# Iniciar servidor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
