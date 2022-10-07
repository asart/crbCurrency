FROM php:8.1-fpm

# apt-get
RUN apt-get update && apt-get -y --no-install-recommends install  \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# php ext
RUN docker-php-ext-configure intl && docker-php-ext-install \
    zip \
    intl \
    soap

# xdebug
RUN pecl install xdebug

USER www-data

CMD ["php-fpm"]
