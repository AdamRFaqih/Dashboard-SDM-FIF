# Build stage for frontend assets
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

# PHP base stage
FROM php:8.2-fpm AS base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    zip

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Production stage for PHP-FPM
FROM base AS production

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --no-scripts --no-autoloader --optimize-autoloader

# Copy application files
COPY . .

# Copy built frontend assets from node-builder stage
COPY --from=node-builder /app/public/build ./public/build

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# PHP configuration
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Setup entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set initial permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]

# Production stage for Nginx web server
FROM nginx:alpine AS nginx

COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html
COPY public ./public
COPY --from=node-builder /app/public/build ./public/build

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
