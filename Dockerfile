# Imagem base
FROM php:8.1-fpm

# Atualizar fontes e instalar dependências do sistema
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

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Swoole
RUN cd /tmp && wget https://pecl.php.net/get/swoole-4.8.1.tgz && \
    tar zxvf swoole-4.8.1.tgz && \
    cd swoole-4.8.1  && \
    phpize  && \
    ./configure  --enable-openssl && \
    make && make install

RUN touch /usr/local/etc/php/conf.d/swoole.ini && \
    echo 'extension=swoole.so' > /usr/local/etc/php/conf.d/swoole.ini

# Instalar as extensões do PHP (zip, gd)
RUN docker-php-ext-install zip gd

# Criar diretório de dados
RUN mkdir -p /app/data

WORKDIR /app

# Copiar fonte para a pasta api no contêiner
COPY ./api /app

EXPOSE 5000

# Comando padrão para iniciar o serviço
CMD ["/usr/local/bin/php", "/app/index.php"]
