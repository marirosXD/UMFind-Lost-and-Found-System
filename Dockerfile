FROM php:8.4-apache

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring xml gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite
RUN a2enmod rewrite headers

# Make Apache listen on port 10000 (Render's default)
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

# Set Laravel public as document root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Allow .htaccess for Laravel
RUN printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app files
COPY . .

# Remove any local .env so production env vars are used
RUN rm -f .env

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install and build frontend assets
RUN npm ci && npm run build

# Fix storage & cache permissions (storage:link runs at startup, not build)
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public/uploads \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Startup: run migrations, create storage link, then start Apache
CMD bash -c "\
    php artisan storage:link --force 2>/dev/null || true && \
    php artisan migrate --force && \
    php artisan config:clear && \
    php artisan view:clear && \
    apache2-foreground"
