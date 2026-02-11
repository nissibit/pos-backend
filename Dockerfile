FROM php:8.3-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    zip unzip git curl \
    libpng-dev libonig-dev libxml2-dev \
    libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev

# Extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar projecto (para build sem bind mount)
COPY . .

# Instalar dependências (SEM scripts)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Permissões mínimas necessárias (Windows-friendly)
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
