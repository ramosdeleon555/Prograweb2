# Usamos la imagen oficial de PHP 8.3 con CLI
FROM php:8.3-cli

# Instalamos dependencias del sistema necesarias para Laravel y Node
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_sqlite bcmath

# Configuramos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos todos los archivos del proyecto
COPY . .

# Copiamos .env.example a .env
COPY .env.example .env

# Instalamos dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    php composer.phar install --no-dev --optimize-autoloader

# Instalamos dependencias de Node y compilamos los assets con Vite/Tailwind
RUN npm install
RUN npm run build

# Creamos la base de datos SQLite si no existe
RUN mkdir -p database && touch database/database.sqlite

# Generamos la key de Laravel y ejecutamos migraciones
RUN php artisan key:generate --force
RUN php artisan migrate --force

# Exponemos el puerto que Render usará
EXPOSE 10000

# Comando por defecto al iniciar el contenedor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
