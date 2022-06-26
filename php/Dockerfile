FROM php:8.1-apache

ENV COMPOSER_HOME=/usr/local/lib/composer

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt update \
    && apt install -y curl libcurl4-openssl-dev libicu-dev libxml2-dev libzip-dev unzip wget zip

COPY install_composer.sh /usr/local/bin/
RUN mkdir -p $COMPOSER_HOME
RUN chown -R www-data:www-data $COMPOSER_HOME
WORKDIR /tmp
RUN /usr/local/bin/install_composer.sh

RUN pecl install apcu
RUN docker-php-ext-install pdo pdo_mysql opcache zip
RUN docker-php-ext-enable apcu opcache

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

COPY config/php.ini /usr/local/etc/php

COPY entrypoint.sh /usr/local/bin/

WORKDIR /var/www/

ENTRYPOINT [ "/usr/local/bin/entrypoint.sh" ]

CMD ["apache2-foreground"]