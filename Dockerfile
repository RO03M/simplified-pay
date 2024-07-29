FROM php:8.0

RUN apt-get update -y && apt-get install -y openssl zip unzip git libzip-dev libpng-dev
# RUN apt-get install php8.0-pgsql
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath gd
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN docker-php-ext-install pdo mbstring

WORKDIR /app
COPY . /app
RUN composer install

CMD php artisan optimize
CMD php artisan migrate

CMD php artisan serve --host=0.0.0.0
EXPOSE 8000