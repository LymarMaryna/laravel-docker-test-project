FROM php:8.2.1-fpm

RUN apt-get -y update && apt-get -y upgrade
RUN apt-get -y install libpq-dev


# Install Postgre PDO
RUN docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql

CMD ["php-fpm"]