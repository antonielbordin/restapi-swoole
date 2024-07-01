# Base image
FROM php:8.1-fpm

# Update sources and install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    wget \
    zip \
    unzip \
    inkscape \
    openssl \
    libssl-dev \
    libpng-dev \
    libzip-dev \
    libgd-dev \
    libonig-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Swoole
RUN cd /tmp && wget https://pecl.php.net/get/swoole-4.8.1.tgz && \
    tar zxvf swoole-4.8.1.tgz && \
    cd swoole-4.8.1  && \
    phpize  && \
    ./configure  --enable-openssl && \
    make && make install

RUN touch /usr/local/etc/php/conf.d/swoole.ini && \
    echo 'extension=swoole.so' > /usr/local/etc/php/conf.d/swoole.ini

# Install PHP extensions (zip, gd)
RUN docker-php-ext-install zip gd

# Create data directory
RUN mkdir -p /app/data

WORKDIR /app

# Copy source to api folder in container
COPY ./api /app

EXPOSE 5000

# Standard command to start the service
CMD ["/usr/local/bin/php", "/app/index.php"]
