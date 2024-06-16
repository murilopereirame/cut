FROM php:8.2.20-zts
LABEL authors="Murilo Pereira"

RUN apt update &&  \
    apt install -y libzip-dev libsodium-dev libicu-dev nodejs npm libonig-dev libcurl4-openssl-dev && \
    rm -rf /var/lib/apt/lists/*

RUN mkdir /.npm && chown -R 1000:1000 "/.npm"

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-install intl mbstring curl zip pdo_mysql && \
    docker-php-ext-enable intl mbstring curl zip pdo_mysql

WORKDIR /app
COPY . .

EXPOSE 8000

ENTRYPOINT /app/entrypoint.sh
