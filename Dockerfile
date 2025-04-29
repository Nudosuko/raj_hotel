FROM php:8.1-apache

# Install PHP mysqli extension (for MySQL)
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (needed for CodeIgniter)
RUN a2enmod rewrite

# Copy project files to Apache server directory
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose Apache port
EXPOSE 80
