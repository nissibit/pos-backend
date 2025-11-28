FROM php:8.3-fpm-alpine

# Instale dependências do sistema necessárias para o Laravel (como extensões PDO, GD, etc.)
RUN apk update && apk add --no-cache \
    git \
    build-base \
    libxml2-dev \
    autoconf \
    mysql-client \
    zip \
    libzip-dev \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql opcache zip intl \
    && docker-php-ext-enable opcache \
    && rm -rf /var/cache/apk/* /tmp/*
# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install 

RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]