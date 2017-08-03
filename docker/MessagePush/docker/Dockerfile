# Dockerfile for swing deploy

FROM php:5.6-fpm

MAINTAINER swing <app@dddsway.com>

ENV CODEPATH=/usr/local/push

# add php.ini, official images has not default php.ini
COPY php.ini /usr/local/etc/php

RUN mkdir -p /usr/local/push \
    && sed -i "s#listen = 127.0.0.1:9000#listen = 0.0.0.0:9000#" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s#listen = 127.0.0.1:9000#listen = 0.0.0.0:9000#" /usr/local/etc/php-fpm.d/docker.conf \
    && sed -i "s#pm.max_children = 5#pm.max_children = 500#" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s#pm.max_children = 5#pm.max_children = 500#" /usr/local/etc/php-fpm.d/docker.conf \
    && echo "catch_workers_output = yes" >>/usr/local/etc/php-fpm.d/www.conf \
    && echo "catch_workers_output = yes" >>/usr/local/etc/php-fpm.d/docker.conf

COPY MessagePush/ $CODEPATH/MessagePush/

WORKDIR $CODEPATH/MessagePush

EXPOSE 9000
CMD ["bash", "/usr/local/sbin/php-fpm"]






