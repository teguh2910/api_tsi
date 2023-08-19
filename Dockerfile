# Use an official PHP 7.3 image with Alpine Linux
FROM php:8.1-fpm-alpine

# Set the working directory inside the container
WORKDIR /var/www/html

# Install system dependencies
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN apk add --update --no-cache libpng-dev libjpeg-turbo-dev freetype-dev zip unzip nginx

# Install PHP extensions
#RUN docker-php-ext-install -j$(nproc) gd
#RUN docker-php-ext-install pdo pdo_mysql
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync
RUN install-php-extensions pdo_mysql
RUN install-php-extensions grpc
RUN install-php-extensions mongodb

# Copy application code into the container
COPY . .

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf
COPY php.ini /usr/local/etc/php/php.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
# Set permissions for Laravel files and directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN composer install

# Expose port 80 for Nginx
EXPOSE 80

# Start Nginx and PHP-FPM
CMD ["sh", "-c", "nginx && php-fpm"]