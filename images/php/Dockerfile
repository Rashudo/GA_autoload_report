FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        nano \
        libonig-dev \
        tar \
        git \
        zip \
        unzip

RUN apt-get install -y libc-client-dev libkrb5-dev && \
        set -eux; \
        PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl; \
        docker-php-ext-install imap

RUN docker-php-ext-install pdo pdo_mysql mysqli



RUN apt-get install -y libpng-dev zlib1g-dev libzip-dev

RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd





RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www


CMD bash -c "source /var/www/.env && composer install && php-fpm"