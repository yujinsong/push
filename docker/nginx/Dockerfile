# Nginx Dockerfile 

FROM nginx

MAINTAINER swing <app@dddsway.com>

RUN mkdir -p /etc/nginx/sslkey

VOLUME ["/etc/nginx/sites-enabled", "/etc/nginx/sslkey", "/etc/nginx/conf.d"]

WORKDIR /etc/nginx

COPY nginx.conf /etc/nginx
COPY push.conf /etc/nginx/conf.d
COPY xkeys.crt /etc/nginx/sslkey
COPY xkeys.key /etc/nginx/sslkey
COPY xkeys.key.unsecure /etc/nginx/sslkey

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

CMD service nginx start

EXPOSE 443


RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*



