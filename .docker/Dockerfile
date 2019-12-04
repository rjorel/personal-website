FROM alpine

COPY . /srv/app
WORKDIR /srv/app

COPY .docker/vhost.conf /etc/nginx/conf.d/default.conf

RUN set -ex; \
        apk add --update --quiet --no-cache \
            composer \
            nginx \
            php7 \
            php7-fileinfo \
            php7-fpm \
            php7-json \
            php7-mbstring \
            php7-opcache \
            php7-session \
            php7-tokenizer \
            php7-zip \
            tzdata \
            yarn; \
        composer install --no-dev --no-interaction --no-scripts --prefer-dist --quiet; \
        composer clear-cache --quiet; \
        yarn install --silent; \
        yarn run production --silent; \
        yarn cache clean --silent; \
        cp /usr/share/zoneinfo/Europe/Paris /etc/localtime; \
        mkdir -p /run/nginx; \
        apk del --quiet composer tzdata yarn; \
        rm -rf node_modules/; \
        rm -rf /tmp/*

RUN set -ex; \
        sed -i 's/#gzip on/gzip on/' /etc/nginx/nginx.conf; \
        sed -i 's/memory_limit = .*/memory_limit = 256M/' /etc/php7/php.ini; \
        sed -i "s/^;date.timezone =$/date.timezone = \"Europe\/Paris\"/" /etc/php7/php.ini; \
        sed -i 's/;clear_env = no/clear_env = no/' /etc/php7/php-fpm.d/www.conf; \
        echo "Europe/Paris" > /etc/timezone

COPY .docker/entrypoint.sh .docker/wrapper.sh /
RUN chmod +x /entrypoint.sh /wrapper.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/wrapper.sh"]
