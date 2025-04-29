# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Set working directory to the root of the CI3 project
WORKDIR /var/www/html

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite (important for CI3 routing)
RUN a2enmod rewrite

# Copy the entire project into container's web root
COPY . /var/www/html/

# Optional: Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for Apache
EXPOSE 80
