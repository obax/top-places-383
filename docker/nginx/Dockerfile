FROM debian:jessie

LABEL maintainer="olivier.bacs@outlook.com"

RUN apt-get update && apt-get install -y \
    nginx

LABEL tier=second

ADD nginx.conf /etc/nginx/
ADD conf.d/* /etc/nginx/conf.d/

RUN ln -s /etc/nginx/conf.d/top-places-vhost.conf /etc/nginx/sites-available/top-places
RUN ln -s /etc/nginx/sites-available/top-places-vhost.conf /etc/nginx/sites-enabled/top-places
RUN rm /etc/nginx/sites-enabled/default


RUN usermod -u 1000 www-data

#RUN chown -R www-data:www-data var

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
