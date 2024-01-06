FROM webdevops/php-nginx:8.1 as pxdmail-php-client

COPY . /app

EXPOSE 80

WORKDIR /app
