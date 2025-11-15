# PHP 8.3
FROM php:8.3-fpm-bookworm

# Install dependensis
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl zip bcmath sockets opcache

# Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Check Node.js and npm
RUN node -v && npm -v

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Clean cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Permissions Composer
RUN chmod +x /usr/bin/composer

# Work directory
WORKDIR /var/www/html

EXPOSE 9000

# PHP-FPM
CMD ["php-fpm"]