FROM php:8.4-cli

RUN apt-get update -y && apt-get install -y libpq-dev libzip-dev zip unzip git
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app
RUN composer install

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]