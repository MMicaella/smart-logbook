FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install and build frontend assets
RUN npm install
RUN npm run build

# Create Laravel storage link
RUN php artisan storage:link || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}