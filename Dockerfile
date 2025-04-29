FROM php:8.1-apache

# Enable Apache mod_rewrite (needed for CodeIgniter)
RUN a2enmod rewrite

# Copy project files to Apache server
COPY . /var/www/html/

# Give permissions (optional but safe)
RUN chown -R www-data:www-data /var/www/html

# Expose default Apache port
EXPOSE 80

RUN apt-get update && apt-get install -y libmysqli-driver

