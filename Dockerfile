# 1. part: PHP basics and Composer dependecis 
FROM dunglas/frankenphp:1-php8.4 AS base

RUN install-php-extensions opcache zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . . 
RUN composer dump-autoload --optimize --no-dev \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views \
        storage/logs storage/app/public bootstrap/cache \
    && php artisan storage:link

# 2. part: frontend build (Vite & Tailwind)
FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY --from=base /app ./
RUN npm run build

# 3. part: Final image
FROM base 

COPY --from=assets /app/public/build ./public/build

RUN sed -i 's/\r$//' docker/start.sh \
    && setcap -r /usr/local/bin/frankenphp

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr

EXPOSE 8080

CMD ["sh", "docker/start.sh"]