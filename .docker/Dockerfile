FROM node:14-alpine AS builder

WORKDIR /app/
COPY ./package.json ./yarn.lock /app/

RUN yarn install --silent

COPY ./purgecss.config.js ./webpack.mix.js /app/
COPY ./assets/ /app/assets/
COPY ./templates/ /app/templates/

RUN yarn run build


FROM php:8.1-fpm-alpine

RUN set -ex; \
        apk add --update --quiet --no-cache \
            nginx; \
        docker-php-ext-install -j$(nproc) > /dev/null \
            opcache; \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
        ln -sf /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini; \
        sed -i 's/memory_limit.*/memory_limit = 256M/' /usr/local/etc/php/php.ini; \
        sed -i "s/;opcache\.validate_timestamps.*/opcache\.validate_timestamps = 0/" /usr/local/etc/php/php.ini; \
        mkdir -p /run/nginx

COPY .docker/vhost.conf /etc/nginx/http.d/default.conf
COPY .docker/entrypoint.sh /
RUN chmod +x /entrypoint.sh

WORKDIR /srv/
COPY ./composer.json ./composer.lock /srv/

RUN composer install --no-cache --no-dev --no-interaction --no-scripts --no-progress

COPY . /srv/
COPY --from=builder /app/www/ /srv/www/

RUN chmod 777 /srv/var

ENTRYPOINT ["/entrypoint.sh"]
