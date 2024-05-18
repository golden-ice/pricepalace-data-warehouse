FROM php:8.0-apache

# Install additional packages
# RUN apt-get update \
#     && apt-get install -y libmariadb-dev \
#     && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mysqli

WORKDIR /var/www/html