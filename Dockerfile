# Usamos la imagen oficial de PHP 8.2 con CLI
FROM php:8.2-cli

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Instalamos dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libsqlite3-dev \
        libonig-dev \
        curl \
        zip \
        unzip \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install pdo pdo_sqlite gd \
        && rm -rf /var/lib/apt/lists/*

# Instalamos Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiamos los archivos del proyecto al contenedor
COPY . .

# Instalamos dependencias de Laravel
RUN composer install

# Exponemos el puerto para PHP built-in server
EXPOSE 8000

# Comando por defecto al iniciar el contenedor
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
