FROM php:8.1-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add autoconf g++ make libstdc++ pkgconfig brotli-dev 

RUN pecl install swoole 
RUN docker-php-ext-enable swoole

RUN docker-php-ext-install pdo pdo_mysql pcntl

# Открытие порта для Octane
EXPOSE 8000

# Команда для запуска Octane
CMD ["sh", "-c", "php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000"]