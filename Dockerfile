FROM php:8.2-apache

# Install MySQLi extension for PHP
RUN docker-php-ext-install mysqli

# Copy your project files into the container
COPY . /var/www/html/

# Fix permissions (optional)
RUN chown -R www-data:www-data /var/www/html
