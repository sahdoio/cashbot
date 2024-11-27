FROM php:8.3.1-fpm

WORKDIR /var/www

RUN apt-get update && apt-get -f -y install build-essential unzip wget

# Install SSL libraries and other dependencies
RUN apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    locales \
    locales-all \
    zip \
    vim \
    unzip \
    git \
    curl \
    libssl-dev \
    libmcrypt-dev \
    freetds-bin \
    freetds-dev \
    freetds-common \
    libxml2-dev \
    libxslt-dev \
    libaio1 \
    libreadline-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    gd \
    zip \
    calendar \
    exif \
    gettext \
    pcntl mysqli \
    shmop \
    soap bcmath \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    xsl \
    opcache

# Install and enable MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log_level=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV LC_ALL pt_BR.UTF-8
ENV LANG pt_BR.UTF-8
ENV LANGUAGE pt_BR.UTF-8

COPY php/local.ini /usr/local/etc/php/php.ini

ADD . /var/www

RUN chown -R www-data:www-data /var/www
