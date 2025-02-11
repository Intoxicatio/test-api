FROM php:8.1-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add autoconf g++ make libstdc++ pkgconfig brotli-dev cronie sudo

RUN pecl install swoole 
RUN docker-php-ext-enable swoole

RUN docker-php-ext-install pdo pdo_mysql pcntl

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 8000

CMD ["/bin/sh", "-c", "/usr/local/bin/start.sh"]