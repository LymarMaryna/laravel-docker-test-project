FROM php:8.2.1-fpm

RUN apt-get -y update && apt-get -y upgrade
RUN apt-get -y install libpq-dev



# Install Postgre PDO
RUN docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql

RUN pecl install xdebug-3.2.0 && docker-php-ext-enable xdebug

COPY docker/php/conf.d/* $PHP_INI_DIR/conf.d/

CMD ["php-fpm"]