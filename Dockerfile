FROM php:8.3-fpm-alpine

# Instale dependências e extensões PHP de forma mais robusta
# O pacote "icu-dev" é necessário para a extensão "intl"
# O pacote "libzip-dev" é necessário para a extensão "zip"
# O pacote "gd-dev" (que é resolvido pelo docker-php-ext-install) é necessário para a extensão "gd"
# O pacote "mariadb-connector-c-dev" é o recomendado para pdo_mysql no Alpine

RUN apk update && apk add --no-cache \
    git \
    autoconf \
    mysql-client \
    icu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    build-base \
    mariadb-connector-c-dev \
    # Instala as dependências necessárias para as extensões de forma automática
    && docker-php-ext-install -j$(nproc) \
        pdo pdo_mysql opcache zip intl \
        gd \
    # Configuração e ativação de extensões adicionais
    && docker-php-ext-enable opcache \
    # Limpeza para reduzir o tamanho da imagem
    && apk del --no-cache autoconf mariadb-connector-c-dev \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]