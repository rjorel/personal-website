FROM node:lts-alpine AS builder

WORKDIR /app/
COPY ./package.json ./package-lock.json /app/

RUN npm clean-install

COPY ./vite.config.js /app/
COPY ./resources/ /app/resources/
COPY ./templates/ /app/templates/

RUN npm run build


FROM php:8.2-fpm-alpine

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
