FROM php:8.1-apache

# Install mysqli extension for MySQL connection
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (needed for CodeIgniter)
RUN a2enmod rewrite

# Copy project files to Apache server
COPY . /var/www/html/

# Give permissions (optional but safe)
RUN chown -R www-data:www-data /var/www/html

# Expose default Apache port
EXPOSE 80
