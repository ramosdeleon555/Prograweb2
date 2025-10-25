# Usamos PHP 8.3 CLI como base
FROM php:8.3-cli

# Instalamos dependencias del sistema y extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev sqlite3 libsqlite3-dev nodejs npm curl \
    && docker-php-ext-install pdo pdo_sqlite bcmath

# Configuramos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos todos los archivos del proyecto
COPY . .

# Copiamos el .env.example a .env
RUN cp .env.example .env

# Instalamos Composer y dependencias de Laravel
RUN curl -sS https://getcomposer.org/installer | php && \
    php composer.phar install --no-dev --optimize-autoloader

# Instalamos Node.js y compilamos assets
RUN npm install && npm run build

# Creamos la base de datos SQLite si no existe
RUN mkdir -p database && touch database/database.sqlite

# Generamos la key de Laravel y ejecutamos migraciones
RUN php artisan key:generate --force
RUN php artisan migrate --force

# Exponemos el puerto que Render usará
EXPOSE 10000

# Comando para iniciar la aplicación
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
