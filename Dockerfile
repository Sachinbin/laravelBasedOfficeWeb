FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libonig-dev libpq-dev \
    && docker-php-ext-install pdo_mysql zip

# Set working directory
WORKDIR /var/www/html

# Copy all project files
COPY . /var/www/html

# ---- FIX: Set correct Apache DocumentRoot to /public ----
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf

RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# ---- FIX: STORAGE + CACHE + VIEW PATHS ----
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]
