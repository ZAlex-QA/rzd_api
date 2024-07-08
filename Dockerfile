FROM composer:lts
WORKDIR /app
COPY . /app
RUN composer install
EXPOSE 8000
CMD [ "php",  "-S", "0.0.0.0:8000", "-t", "controllers" ]
