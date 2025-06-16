FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

COPY . .

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", ".", "router.php"]
