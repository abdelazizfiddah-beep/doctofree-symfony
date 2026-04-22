FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Create system user
RUN useradd -G www-data,root -u 1000 -d /home/dev dev || true
RUN mkdir -p /home/dev/.composer && \
    chown -R dev:dev /home/dev

# Create var directory with proper permissions
RUN mkdir -p /var/www/html/var/cache /var/www/html/var/log && \
    chown -R www-data:www-data /var/www/html/var && \
    chmod -R 777 /var/www/html/var

USER dev

EXPOSE 9000
CMD ["php-fpm"]
