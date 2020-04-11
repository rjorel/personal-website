FROM node:12-alpine AS builder

COPY ./package.json ./webpack.mix.js ./yarn.lock /app/
COPY ./assets/ /app/assets/

WORKDIR /app

RUN set -ex; \
        yarn install --silent; \
        yarn run production --silent


FROM alpine

COPY . /srv/app
WORKDIR /srv/app

COPY .docker/vhost.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /app/www /srv/app/www

RUN set -ex; \
        apk add --update --quiet --no-cache \
            nginx \
            php7 \
            php7-fileinfo \
            php7-fpm \
            php7-json \
            php7-mbstring \
            php7-opcache \
            php7-session \
            php7-tokenizer \
            php7-zip; \
        apk add --quiet --no-cache --virtual .build-deps \
            composer; \
        composer install --quiet --no-dev --no-interaction --no-scripts --no-cache --prefer-dist; \
        mkdir -p /run/nginx; \
        apk del --quiet .build-deps

RUN set -ex; \
        sed -i 's/memory_limit.*/memory_limit = 256M/' /etc/php7/php.ini; \
        sed -i "s/;opcache\.validate_timestamps.*/opcache\.validate_timestamps = 0/" /etc/php7/php.ini

COPY .docker/entrypoint.sh .docker/wrapper.sh /
RUN chmod +x /entrypoint.sh /wrapper.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/wrapper.sh"]
