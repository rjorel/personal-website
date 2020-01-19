FROM alpine

COPY . /srv/app
WORKDIR /srv/app

COPY .docker/vhost.conf /etc/nginx/conf.d/default.conf

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
            composer \
            yarn; \
        composer install --no-dev --no-interaction --no-scripts --prefer-dist --quiet; \
        composer clear-cache --quiet; \
        yarn install --silent; \
        yarn run production --silent; \
        yarn cache clean --silent; \
        mkdir -p /run/nginx; \
        apk del --quiet .build-deps; \
        rm -rf node_modules/; \
        rm -rf /tmp/*

RUN set -ex; \
        sed -i 's/memory_limit.*/memory_limit = 256M/' /etc/php7/php.ini; \
        sed -i "s/;opcache\.validate_timestamps.*/opcache\.validate_timestamps = 0/" /etc/php7/php.ini

COPY .docker/entrypoint.sh .docker/wrapper.sh /
RUN chmod +x /entrypoint.sh /wrapper.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/wrapper.sh"]
