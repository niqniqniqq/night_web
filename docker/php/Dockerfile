FROM php:8.3-fpm AS builder

RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libxslt1-dev \
    default-mysql-client \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install pdo_mysql gd mbstring exif pcntl bcmath opcache zip intl xml xsl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ローカル開発用イメージ
FROM builder AS local_image

COPY docker/php/config/php.ini /usr/local/etc/php/php.ini
COPY docker/php/config/php.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000
CMD ["php-fpm"]

# AWS本番用イメージ
FROM builder AS aws_image

COPY ./html /var/www/html
COPY ./html/.env /var/www/html/.env

RUN composer install --no-dev --optimize-autoloader

COPY docker/php/config/php_aws.ini /usr/local/etc/php/php.ini
COPY docker/php/config/php_aws.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
