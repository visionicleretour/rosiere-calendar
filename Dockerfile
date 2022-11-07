FROM php:7.4-apache

RUN apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y \
  && apt-get update

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart

COPY . .

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

EXPOSE 80

COPY apache-config.conf /etc/apache2/sites-enabled/000-default.conf