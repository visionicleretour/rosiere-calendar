FROM php:8.1-apache

RUN apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y \
  && apt-get update

RUN mkdir /var/www/html/rosieres
WORKDIR /var/www/html/rosieres

#COPY apache2.conf /etc/apache2/apache2.conf
COPY ./apache-config.conf /etc/apache2/sites-enabled/000-default.conf
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart

#COPY . /var/www/html/rosieres

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
#RUN composer update

EXPOSE 80
