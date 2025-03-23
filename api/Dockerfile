FROM php:8.2-apache

# Configuraciones PHP
RUN echo 'memory_limit = 512M' > /usr/local/etc/php/conf.d/memlimit.ini \
 && echo 'upload_max_filesize = 40M' > /usr/local/etc/php/conf.d/uploads.ini

# Dependencias necesarias para PHP, composer y GRPC
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    git \
    unzip \
    libzip-dev \
    zlib1g-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    autoconf \
    pkg-config \
    libssl-dev \
    libtool \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) zip pdo pdo_pgsql bcmath gd sockets \
    && pecl install grpc \
    && docker-php-ext-enable grpc \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN a2enmod rewrite
WORKDIR /var/www
COPY ./ /var/www
RUN rm -r /var/www/html \
    && mv /var/www/public /var/www/html \
    && chmod -R 0777 /var/www/storage/ 
RUN composer install 

