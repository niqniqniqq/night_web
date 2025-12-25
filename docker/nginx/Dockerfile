FROM nginx:1.27-alpine

RUN rm /etc/nginx/conf.d/default.conf

COPY docker/nginx/vhost.conf.template /etc/nginx/templates/default.conf.template

WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
