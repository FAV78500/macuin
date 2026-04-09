FROM php:8.4-cli

RUN apt-get update -y \
    && apt-get install -y libpq-dev libzip-dev libcurl4-openssl-dev zip unzip git \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]