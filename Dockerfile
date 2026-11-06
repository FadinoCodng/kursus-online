FROM php:8.3-cli-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite \
    sqlite-dev \
    oniguruma-dev

RUN docker-php-ext-install pdo pdo_sqlite mbstring gd bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Prepare environment & database
RUN touch database/database.sqlite
RUN php artisan config:clear
RUN php artisan storage:link

# Port configuration
ENV PORT=8080
EXPOSE 8080

# Entrypoint script
CMD php artisan migrate --force --seed && php artisan serve --host=0.0.0.0 --port=${PORT}
