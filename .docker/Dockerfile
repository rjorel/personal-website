FROM node:14-alpine AS builder

COPY ./package.json ./webpack.mix.js ./yarn.lock /app/
COPY ./assets/ /app/assets/

WORKDIR /app/

RUN set -ex; \
        yarn install --silent; \
        yarn run production --silent


FROM php:8.0-fpm-alpine

COPY . /srv/
WORKDIR /srv/

COPY .docker/vhost.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /app/www/ /srv/www/

RUN set -ex; \
        apk add --update --quiet --no-cache \
            nginx; \
        apk add --quiet --no-cache --virtual .build-deps \
            composer; \
        docker-php-ext-install -j$(nproc) > /dev/null \
            opcache; \
        composer install --quiet --no-dev --no-interaction --no-scripts --no-cache --prefer-dist; \
        mkdir -p /run/nginx; \
        apk del --quiet .build-deps

RUN set -ex; \
        ln -sf /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini; \
        sed -i 's/memory_limit.*/memory_limit = 256M/' /usr/local/etc/php/php.ini; \
        sed -i "s/;opcache\.validate_timestamps.*/opcache\.validate_timestamps = 0/" /usr/local/etc/php/php.ini;

COPY .docker/entrypoint.sh .docker/wrapper.sh /
RUN chmod +x /entrypoint.sh /wrapper.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/wrapper.sh"]
