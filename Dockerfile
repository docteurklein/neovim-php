FROM php:5.6

RUN pecl install channel://pecl.php.net/msgpack-0.5.7
RUN docker-php-ext-enable msgpack.so
WORKDIR /usr/src/app/
COPY . /usr/src/app/
