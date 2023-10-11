FROM php:8.1-apache

RUN apt-get update; \
    apt-get install -y zip; \
    apt-get install -y unzip; \
    apt-get install -y vim; \
    apt-get install -y ssh; \
    apt-get install -y less; \
	apt-get install -y curl; \
    apt-get install -y git;

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y \
        libzip-dev \
        zip \
        && docker-php-ext-install zip


COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer