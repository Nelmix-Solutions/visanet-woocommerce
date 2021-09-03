FROM php:5.6-apache
RUN apt-get update && apt-get install -y \
        libmcrypt-dev \
        zip \
        unzip \
    && docker-php-ext-install -j$(nproc) iconv mcrypt
RUN apt-get install -y libxml2-dev
RUN apt-get install -y php-soap
RUN docker-php-ext-install soap
RUN chown --recursive www-data:www-data /var/www/html
RUN cd /var/www/html

# Composer Setup:
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Composer Install dependencies
ADD composer.json composer.json
ADD composer.lock composer.lock
RUN php composer install

# PHP Unit
ADD phpunit.xml phpunit.xml
