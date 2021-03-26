FROM php:7.4-fpm

ARG APP_ENV
ARG DB_NAME
ARG DB_USER
ARG DB_PASS
ARG DB_HOST

# Adding extensions
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
        libzip-dev unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libyaml-dev \
        libevent-dev \
        libssl-dev \
        libmagickwand-dev --no-install-recommends \
    && docker-php-ext-install -j$(nproc) bcmath \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) sockets \
    && docker-php-ext-install -j$(nproc) pcntl \
    && docker-php-ext-install -j$(nproc) intl \
    && apt-get autoremove -y

# Some additional PHP Extensions go here:
RUN pecl channel-update pecl.php.net
# Adding native YAML support
RUN pecl install yaml && docker-php-ext-enable yaml

# Adding composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --chown=www-data:www-data ./server/ /var/www/html/

WORKDIR /var/www/html

RUN composer install

RUN chown -R www-data:www-data vendor

RUN mkdir -p /var/symfony/cache && chown -R www-data:www-data /var/symfony/cache
RUN mkdir -p /var/symfony/log && chown -R www-data:www-data /var/symfony/log

WORKDIR /var/www/html
